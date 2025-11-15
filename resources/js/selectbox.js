document.addEventListener('DOMContentLoaded', function () {
    const selectButton = document.getElementById('city-select-button');
    const optionsList = document.getElementById('city-options-list');
    const selectedText = document.getElementById('selected-city-text');

    let selectedValue = 'ho-chi-minh';
    if (optionsList) {
        const initial = optionsList.querySelector('[aria-selected="true"]')?.getAttribute('data-value');
        if (initial) selectedValue = initial;
    }

    if (selectButton && optionsList) {
        selectButton.addEventListener('click', function (e) {
            e.preventDefault();
            const isHidden = optionsList.classList.contains('hidden');
            if (isHidden) {
                optionsList.classList.remove('hidden');
                selectButton.setAttribute('aria-expanded', 'true');
            } else {
                optionsList.classList.add('hidden');
                selectButton.setAttribute('aria-expanded', 'false');
            }
        });
    }

    if (optionsList && selectedText) {
        const options = optionsList.querySelectorAll('li');
        options.forEach(option => {
            option.addEventListener('click', function () {
                selectedText.textContent = this.textContent.trim();
                options.forEach(o => o.setAttribute('aria-selected', 'false'));
                this.setAttribute('aria-selected', 'true');
                selectedValue = this.getAttribute('data-value');
                optionsList.classList.add('hidden');
                if (selectButton) selectButton.setAttribute('aria-expanded', 'false');
            });
        });
    }

    const searchButton = document.getElementById('search-button');
    if (searchButton) {
        searchButton.addEventListener('click', function (e) {
            e.preventDefault();
            const m = { HoChiMinh: 'ho-chi-minh', HaNoi: 'ha-noi', DaNang: 'da-nang', ThanhHoa: 'thanh-hoa' };
            const slug = m[selectedValue] || selectedValue;
            window.location.href = `/filter/${slug}`;
        });
    }

    if (selectButton && optionsList) {
        document.addEventListener('click', function (e) {
            if (!selectButton.contains(e.target) && !optionsList.contains(e.target)) {
                optionsList.classList.add('hidden');
                selectButton.setAttribute('aria-expanded', 'false');
            }
        });
    }
});
