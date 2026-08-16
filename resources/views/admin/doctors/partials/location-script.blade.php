<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cityFilter = document.getElementById('city_filter');
        const districtSelect = document.getElementById('district_select');

        if (!cityFilter || !districtSelect) return;

        const districtOptions = Array.from(districtSelect.options);

        function filterDistricts(resetValue = true) {
            const selectedCity = cityFilter.value;

            if (resetValue) {
                districtSelect.value = "";
            }

            districtOptions.forEach(option => {
                if (!option.value) return;

                if (!selectedCity || option.getAttribute('data-city') === selectedCity) {
                    option.style.display = '';
                    option.disabled = false;
                } else {
                    option.style.display = 'none';
                    option.disabled = true;
                }
            });
        }

        // Tự động khôi phục dữ liệu đã chọn (khi Edit hoặc khi Validate lỗi)
        const selectedOption = districtSelect.querySelector('option[selected]');
        if (selectedOption && selectedOption.value) {
            const initialCity = selectedOption.getAttribute('data-city');
            if (initialCity) {
                cityFilter.value = initialCity;
                filterDistricts(false);
            }
        } else {
            filterDistricts(false);
        }

        cityFilter.addEventListener('change', () => filterDistricts(true));
    });
</script>