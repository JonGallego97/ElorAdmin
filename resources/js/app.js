import './bootstrap';
// Función para establecer el tipo y nombre del elemento a eliminar


document.addEventListener('DOMContentLoaded', function () {


    //Cargar ciclos en el array para llevar al controller
    $(document).ready(function() {
        $('#editCyclesBtn').on('click', function(event) {
            debugger;
            event.preventDefault();
            var selectedRoles = obtenerCiclosSeleccionados();

            $('#selectedCyclesInput').val(selectedRoles.join(','));

            document.getElementById("editListDeCycles").click();
        });

        //Obtener los ciclos que esten chequeados
        function obtenerCiclosSeleccionados() {
            var checkedIds = [];
            $('.form-check-input:checked').each(function() {
                checkedIds.push($(this).val());
            });
            debugger;
            return checkedIds;
        }
    });



});
