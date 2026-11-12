<script>
    document.addEventListener('DOMContentLoaded', function () {
        const errorLinks = document.querySelectorAll('[data-validation-field]');

        errorLinks.forEach(function (link, index) {
            const fieldName = link.dataset.validationField;
            const normalizedErrorName = fieldName.replace(/\[(.*?)\]/g, '.$1');
            const wildcardName = normalizedErrorName
                .split('.')
                .map(function (segment) {
                    return segment === '*'
                        ? '\\d+'
                        : segment.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                })
                .join('\\.');
            const wildcardPattern = new RegExp(`^${wildcardName}$`);
            const field = Array.from(document.querySelectorAll('input, select, textarea'))
                .find(function (control) {
                    const normalizedFieldName = control.name.replace(/\[(.*?)\]/g, '.$1');

                    return normalizedFieldName === normalizedErrorName
                        || wildcardPattern.test(normalizedFieldName);
                });

            if (!field) {
                link.removeAttribute('href');
                link.classList.add('error-summary-item-unlinked');

                return;
            }

            const fieldId = field.dataset.validationTargetId || `campo-validacao-${index}`;
            field.dataset.validationTargetId = fieldId;
            field.id = fieldId;
            link.href = `#${fieldId}`;
            link.addEventListener('click', function (event) {
                event.preventDefault();
                field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                field.focus({ preventScroll: true });
            });
            field.setAttribute('aria-invalid', 'true');

            if (field.dataset.validationEnhanced === 'true') {
                return;
            }

            const container = field.closest('.field, .form-group, .mb-3, .mb-4') || field.parentElement;
            const existingMessage = container.querySelector('.invalid-feedback');

            if (existingMessage) {
                existingMessage.id = `${fieldId}-erro`;
                field.setAttribute('aria-describedby', existingMessage.id);
            } else {
                const message = document.createElement('span');
                message.className = 'field-error-message';
                message.id = `${fieldId}-erro`;
                message.textContent = link.dataset.validationMessage;
                container.append(message);
                field.setAttribute('aria-describedby', message.id);
            }

            field.classList.add('has-validation-error');
            field.dataset.validationEnhanced = 'true';
        });
    });
</script>
