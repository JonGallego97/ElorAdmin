document.addEventListener('DOMContentLoaded', function () {

    $(document).ready(function() {
        $('#deleteCycleModal').on('show.bs.modal', function (event) {
            debugger;
            var button = $(event.relatedTarget);
            var cycleId = button.data('cycle-id');
            var cycleName = button.data('cycle-name');

            var cycleNameDiv = document.getElementById('cycleName');
            cycleNameDiv.innerHTML = cycleName;
            var modal = $(this);
            modal.find('.modal-title').text('Confirm Deletion');

            // Actualiza el formulario para que apunte al usuario correcto
            var form = modal.find('form');
            form.attr('action', '/admin/cycles/destroy/' + cycleId);
        });
    });
});
