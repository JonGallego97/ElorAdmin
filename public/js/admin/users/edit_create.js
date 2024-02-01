
document.getElementById('roleEdit').addEventListener('click', function() {
    // Limpiar selección previa
    document.querySelectorAll('[name="modalRoles[]"]').forEach(function(checkbox) {
        checkbox.checked = false;
    });

    // Marcar roles actuales del usuario
    var selectedRoles = document.getElementById('selectedRolesInput').value.split(',');
    selectedRoles.forEach(function(roleId) {
        var checkbox = document.getElementById('modalRole_' + roleId);
        if (checkbox) {
            checkbox.checked = true;
        }
    });

    // Mostrar el modal
    var rolesModal = new bootstrap.Modal(document.getElementById('rolesModal'));
    rolesModal.show();
});

document.getElementById('applyRolesBtn').addEventListener('click', function() {
    // Actualizar roles en el formulario original
    var selectedRoles = [];
    document.querySelectorAll('[name="modalRoles[]"]:checked').forEach(function(checkbox) {
        selectedRoles.push(checkbox.value);
    });
    document.getElementById('selectedRolesInput').value = selectedRoles.join(',');

    // Cerrar el modal
    var rolesModal = bootstrap.Modal.getInstance(document.getElementById('rolesModal'));
    rolesModal.hide();
});