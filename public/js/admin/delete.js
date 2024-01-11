document.addEventListener('DOMContentLoaded', function () {

    $(document).ready(function() {
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var type = button.data('type');
            var action = button.data('action');

            var typeDiv = document.getElementById('type');
            typeDiv.innerHTML = type;
            var nameDiv = document.getElementById('name');
            nameDiv.innerHTML = name;
            var modal = $(this);

            // Actualiza el formulario para que apunte al usuario correcto
            var form = modal.find('form');
            form.attr('action', '/admin/' + action  + '/' + id);
        });
    });
});
