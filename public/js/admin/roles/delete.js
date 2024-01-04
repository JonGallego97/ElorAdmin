document.addEventListener('DOMContentLoaded', function () {

    $(document).ready(function() {
        $('#deleteRoleModal').on('show.bs.modal', function (event) {
            debugger;
            var button = $(event.relatedTarget);
            var roleId = button.data('role-id');
            var roleName = button.data('role-name');

            var roleNameDiv = document.getElementById('roleName');
            roleNameDiv.innerHTML = roleName;
            var modal = $(this);
            modal.find('.modal-title').text('Confirm Deletion');

            // Actualiza el formulario para que apunte al usuario correcto
            var form = modal.find('form');
            form.attr('action', '/admin/roles/destroy/' + roleId);
        });
    });
});
