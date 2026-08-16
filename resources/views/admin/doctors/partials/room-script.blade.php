<script>
    document.addEventListener('DOMContentLoaded', function() {
        const specSelect = document.getElementById('specialization_select');
        const roomSelect = document.getElementById('room_select');

        if (!specSelect || !roomSelect) return;

        const roomOptions = Array.from(roomSelect.options);

        function filterRooms(resetValue = true) {
            const selectedSpecId = specSelect.value;

            if (resetValue) {
                roomSelect.value = "";
            }

            roomOptions.forEach(option => {
                if (!option.value) return; // Giữ lại option "-- Select Clinic Room --"

                const roomSpecId = option.getAttribute('data-specialization');

                // Hiển thị phòng nếu không chọn chuyên khoa HOẶC chuyên khoa của phòng trùng với chuyên khoa được chọn
                if (!selectedSpecId || roomSpecId === selectedSpecId) {
                    option.style.display = '';
                    option.disabled = false;
                } else {
                    option.style.display = 'none';
                    option.disabled = true;
                }
            });
        }

        // Tự động lọc khi tải trang (giữ lại giá trị khi Edit hoặc Validate lỗi)
        const selectedOption = roomSelect.querySelector('option[selected]');
        if (selectedOption && selectedOption.value) {
            filterRooms(false);
        } else {
            filterRooms(false);
        }

        specSelect.addEventListener('change', () => filterRooms(true));
    });
</script>