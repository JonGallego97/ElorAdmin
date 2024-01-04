document.addEventListener('DOMContentLoaded', function () {

    $(document).ready(function() {
        $('#deleteModuleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var moduleId = button.data('module-id');
            var moduleName = button.data('module-name');

            var moduleNameDiv = document.getElementById('moduleName');
            moduleNameDiv.innerHTML = moduleName;
            var modal = $(this);
            modal.find('.modal-title').text('Confirm Deletion');

            // Actualiza el formulario para que apunte al usuario correcto
            var form = modal.find('form');
            form.attr('action', '/admin/modules/destroy/' + moduleId);
        });
    });
});
