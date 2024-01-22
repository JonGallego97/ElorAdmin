import './bootstrap';
// Función para establecer el tipo y nombre del elemento a eliminar
import './darkmode';
// Luego puedes usar los íconos en tu código HTML o CSS


$(document).ready(function() {
    $(".toggle-incidencias").on("click", function() {
        debugger;
        var target = $(this).data("target");
        var incidenciasDiv = $(this).closest(".row").next(target);
        var mostrarImage = $(this).find(".mostrar-image");
        var ocultarImage = $(this).find(".ocultar-image");
        mostrarImage.toggle();
        ocultarImage.toggle();
        if (incidenciasDiv.css("display") === "none") {
            incidenciasDiv.css("display", "block");
        } else {
            incidenciasDiv.css("display", "none");
        }
    });
});

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
