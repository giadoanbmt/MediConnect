<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title ?? 'MediConnect - Admin Management' }}</title>

<!-- Font Google & FontAwesome Icons -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    navy: {
                        800: '#1e293b',
                        900: '#0f172a',
                    }
                }
            }
        }
    }
</script>

<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
    }
</style>

<!-- HTMX CDN: Biến trang web thành SPA không cần reload -->
<!-- <script src="https://unpkg.com/htmx.org@1.9.10"></script> -->