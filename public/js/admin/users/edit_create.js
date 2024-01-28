
$(document).ready(function() {
    // Escucha el clic en el botón "Aceptar" del modal de roles
    $('#editRolesBtn').click(function() {
        var selectedRoles = $('#roles').val();
        $('#selectedRolesInput').val(selectedRoles);
    });

    // Escucha el clic en el botón "Aceptar" del modal de ciclos
    $('#editCyclesBtn').click(function() {
        var selectedCycles = $('#cycles').val();
        $('#selectedCyclesInput').val(selectedCycles);
    });
});