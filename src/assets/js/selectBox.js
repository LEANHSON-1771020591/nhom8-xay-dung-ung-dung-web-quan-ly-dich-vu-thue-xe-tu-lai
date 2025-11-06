document.addEventListener("DOMContentLoaded", function () {

    const allSelectWrappers = document.querySelectorAll('.custom-select-wrapper');

    allSelectWrappers.forEach(wrapper => {
        const selectElement = wrapper.querySelector('select');
        const options = selectElement.querySelectorAll('option');

        const trigger = document.createElement('div');
        trigger.className = 'custom-select-trigger';

        let selectedOptionText = '';
        options.forEach(option => {
            if (option.selected) {
                selectedOptionText = option.textContent;
            }
        });
        trigger.textContent = selectedOptionText;
        wrapper.appendChild(trigger);

        const optionsContainer = document.createElement('div');
        optionsContainer.className = 'custom-options';

        options.forEach(option => {
            if (option.disabled) return;

            const customOption = document.createElement('span');
            customOption.className = 'custom-option';
            customOption.textContent = option.textContent;
            customOption.dataset.value = option.value;

            if (option.selected) {
                customOption.classList.add('selected');
            }

            customOption.addEventListener('click', function (e) {
                e.stopPropagation();

                const allCustomOptions = optionsContainer.querySelectorAll('.custom-option');
                allCustomOptions.forEach(opt => opt.classList.remove('selected'));

                this.classList.add('selected');

                trigger.textContent = this.textContent;

                selectElement.value = this.dataset.value;

                wrapper.classList.remove('active');
            });

            optionsContainer.appendChild(customOption);
        });

        wrapper.appendChild(optionsContainer);

        trigger.addEventListener('click', function () {
            allSelectWrappers.forEach(s => {
                if (s !== wrapper) {
                    s.classList.remove('active');
                }
            });
            wrapper.classList.toggle('active');
        });
    });

    document.addEventListener('click', function (e) {
        allSelectWrappers.forEach(wrapper => {
            if (!wrapper.contains(e.target)) {
                wrapper.classList.remove('active');
            }
        });
    });
});