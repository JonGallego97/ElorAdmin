document.addEventListener('DOMContentLoaded', function () {

    $(document).ready(function() {
        $('#deleteDepartmentModal').on('show.bs.modal', function (event) {
            debugger;
            var button = $(event.relatedTarget);
            var departmentId = button.data('department-id');
            var departmentName = button.data('department-name');

            var departmentNameDiv = document.getElementById('departmentName');
            departmentNameDiv.innerHTML = departmentName;
            var modal = $(this);
            modal.find('.modal-title').text('Confirm Deletion');

            // Actualiza el formulario para que apunte al usuario correcto
            var form = modal.find('form');
            form.attr('action', '/admin/departments/destroy/' + departmentId);
        });
    });
});
