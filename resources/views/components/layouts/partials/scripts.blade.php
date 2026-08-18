<script src="{{ asset('Novena/plugins/jquery/jquery.js') }}"></script>
<script src="{{ asset('Novena/plugins/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('Novena/plugins/slick-carousel/slick/slick.min.js') }}"></script>
<script src="{{ asset('Novena/plugins/shuffle/shuffle.min.js') }}"></script>
<script src="{{ asset('Novena/js/script.js') }}"></script>


<script>
    // Fallback cho menu tài khoản vì bộ Bootstrap hiện tại không kèm Popper.js.
    document.addEventListener('click', (event) => {
        const toggle = event.target.closest('#topUserMenu');

        if (toggle) {
            event.preventDefault();
            const menu = toggle.nextElementSibling;
            const isOpen = menu.classList.toggle('show');
            toggle.setAttribute('aria-expanded', String(isOpen));
            return;
        }

        if (!event.target.closest('.top-right-bar .dropdown')) {
            document.querySelectorAll('.top-right-bar .dropdown-menu.show').forEach((menu) => menu.classList.remove('show'));
            document.querySelectorAll('.top-right-bar [aria-expanded="true"]').forEach((item) => item.setAttribute('aria-expanded', 'false'));
        }
    });

    // Điều hướng nội bộ: chỉ thay phần nội dung chính để tránh tải lại toàn bộ giao diện.
    (() => {
        const mainSelector = 'main';
        let activeRequest;

        const isInternalNavigation = (link, event) => {
            if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return false;
            if (link.target && link.target !== '_self') return false;
            if (link.hasAttribute('download') || link.dataset.noSpa !== undefined) return false;

            const url = new URL(link.href, window.location.href);
            return url.origin === window.location.origin &&
                url.pathname !== window.location.pathname &&
                !link.href.startsWith('#');
        };

        const setLoading = (isLoading) => document.documentElement.classList.toggle('spa-loading', isLoading);

        const syncNavigation = (pathname) => {
            document.querySelectorAll('#navbarmain a.nav-link').forEach((link) => {
                const url = new URL(link.href, window.location.href);
                link.classList.toggle('active', url.pathname === pathname);
            });
        };

        const visit = async (url, shouldPushState = true) => {
            if (activeRequest) activeRequest.abort();

            const request = new AbortController();
            activeRequest = request;
            setLoading(true);

            try {
                const response = await fetch(url, {
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    signal: request.signal,
                });

                if (!response.ok) throw new Error(`Navigation failed: ${response.status}`);

                const documentResponse = new DOMParser().parseFromString(await response.text(), 'text/html');
                const nextMain = documentResponse.querySelector(mainSelector);
                const currentMain = document.querySelector(mainSelector);

                // Các trang không dùng public/patient layout (ví dụ Login) vẫn chuyển trang bình thường.
                if (!nextMain || !currentMain) {
                    window.location.assign(url);
                    return;
                }

                currentMain.replaceWith(nextMain);
                document.title = documentResponse.title;
                syncNavigation(new URL(url, window.location.href).pathname);

                if (shouldPushState) window.history.pushState({}, '', url);
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            } catch (error) {
                if (error.name !== 'AbortError') window.location.assign(url);
            } finally {
                if (activeRequest === request) {
                    activeRequest = undefined;
                    setLoading(false);
                }
            }
        };

        document.addEventListener('click', (event) => {
            const link = event.target.closest('a[href]');
            if (!link || !isInternalNavigation(link, event)) return;

            event.preventDefault();
            visit(link.href);
        });

        window.addEventListener('popstate', () => visit(window.location.href, false));
    })();
</script>