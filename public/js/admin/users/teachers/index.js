/* document.addEventListener('DOMContentLoaded', function () {

    document.getElementById("roleEdit").onclick = function() {
        roleModal()
    };

    function roleModal() {
        var rolesList = document.getElementById('hiddenRoleIds').value;
        var selectedRoles = rolesList ? rolesList.split(',') : [];
        selectedRoles.forEach(function(roleId) {
            var checkbox = document.getElementById('role_' + roleId);
            if (checkbox !== null) {
                checkbox.checked = true;
            }
        });
    }

    //Precargar cyclos en la modal
    document.getElementById("cycleEdit").onclick = function() {
        cycleModal()

    };

    function cycleModal() {
        var cyclesList = document.getElementById('hiddenCycleIds').value;
        var selectedCycles = cyclesList ? cyclesList.split(',') : [];
        selectedCycles.forEach(function(cycleId) {
            var checkbox = document.getElementById('cycle_' + cycleId);
            if (checkbox !== null) {
                checkbox.checked = true;
            }
        });
        // var submitButton = document.getElementById('editCyclesBtn');
        // submitButton.addEventListener('click', function() {
        //     var form = document.getElementById('editCyclesForm');
        //     form.formAction = "{{  route('users.editModules', $user) }}"
        //     form.submit();
        // });
        
    }

    //Precargar modules en la modal
    document.getElementById("moduleEdit").onclick = function() {
        moduleModal();
    };

    function moduleModal() {
        var modulesList = document.getElementById('hiddenModuleIds').value;
        var selectedModules = modulesList ? modulesList.split(',') : [];
        selectedModules.forEach(function(moduleId) {
            var checkbox = document.getElementById('module_' + moduleId);
            if (checkbox !== null) {
                checkbox.checked = true;
            }
        });
    }

    //Cargar roles en el array para llevar al controller

    $(document).ready(function() {
        $('#editRolesBtn').on('click', function(event) {
            event.preventDefault();
            var selectedRoles = obtenerRolesSeleccionados();
            var userDataElement = document.getElementById('user_data');
            var userDataJson = userDataElement.getAttribute('data-user');
            var userRoles = JSON.parse(userDataJson);

            // Comparar roles seleccionados con roles del usuario
            selectedRoles.forEach(function(selectedRole) {
                // Verificar si el rol ya existe en la lista de roles del usuario
                var existingRole = userRoles.find(function(userRole) {
                    return userRole.id === selectedRole.id;
                });

                // Si no existe, agregarlo
                if (!existingRole) {
                    userRoles.push(selectedRole);
                }
            });

            // Filtrar roles del usuario que no están seleccionados
            userRoles = userRoles.filter(function(userRole) {
                return selectedRoles.some(function(selectedRole) {
                    return userRole.id === selectedRole.id;
                });
            });

            // Actualizar el atributo 'data-user' con la nueva lista de roles
            userDataElement.setAttribute('data-user', JSON.stringify(userRoles));
            console.log(JSON.stringify(userRoles));

            // Actualizar la lista de roles en el HTML
            actualizarListaRoles(userRoles);
            $(this).find('#selectedInputRoles').attr('value',JSON.stringify(userRoles));
            document.getElementById("editRolesForm").submit();
            
        });

        // Obtener los roles que estén chequeados
        function obtenerRolesSeleccionados() {
            var checkedRoles = [];
            $('.form-check-input:checked').each(function() {
                var roleId = $(this).val();
                var roleName = $(this).siblings('.form-check-label').text();
                checkedRoles.push({ id: roleId, name: roleName });
            });
            return checkedRoles;
        }

        // Actualizar la lista de roles en el HTML
        function actualizarListaRoles(userRoles) {
            var rolesSelect = $('#roles');
            rolesSelect.empty(); // Limpiar la lista actual

            // Agregar opciones basadas en la nueva lista de roles
            userRoles.forEach(function(role) {
                rolesSelect.append('<option value="' + role.id + '">' + role.name + '</option>');
            });
        }
    });
});

 */