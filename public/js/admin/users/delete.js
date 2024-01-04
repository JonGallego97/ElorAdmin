document.addEventListener('DOMContentLoaded', function () {

    $(document).ready(function() {
        $('#deleteUserModal').on('show.bs.modal', function (event) {
            debugger;
            var button = $(event.relatedTarget);
            var userId = button.data('user-id');
            var userName = button.data('user-name');

            var userNameDiv = document.getElementById('userName');
            userNameDiv.innerHTML = userName;
            var modal = $(this);
            modal.find('.modal-title').text('Confirm Deletion');

            // Actualiza el formulario para que apunte al usuario correcto
            var form = modal.find('form');
            form.attr('action', '/admin/users/destroy/' + userId);
        });
    });
});
