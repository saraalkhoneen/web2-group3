
    document.addEventListener('DOMContentLoaded', function () {
        var userTypeForm = document.getElementById('userTypeForm');
        var designerForm = document.getElementById('designerForm');
        var clientForm = document.getElementById('clientForm');

        userTypeForm.addEventListener('change', function(event) {
            var value = event.target.value;
            if (value === 'designer') {
                designerForm.style.display = 'block';
                clientForm.style.display = 'none';
            } else if (value === 'client') {
                clientForm.style.display = 'block';
                designerForm.style.display = 'none';
            }
        });
    });

