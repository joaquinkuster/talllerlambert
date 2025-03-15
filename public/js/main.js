$(document).ready(function () {
    // Botón de mostrar/ocultar contraseña
    const togglePassword = $('#togglePassword');
    const togglePasswordConfirm = $('#togglePasswordConfirm');
    function mostrarOcultarPassword(input, toggle) {
        const tipo = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', tipo);
        toggle.classList.toggle('fa-eye');
        toggle.classList.toggle('fa-eye-slash');
    }
    if (togglePassword.length) {
        togglePassword.on('click', function (e) {
            e.preventDefault();
            const input = document.getElementById('password');
            mostrarOcultarPassword(input, this);
        });
    }
    if (togglePasswordConfirm.length) {
        togglePasswordConfirm.on('click', function (e) {
            e.preventDefault();
            const input = document.getElementById('password_confirmation');
            mostrarOcultarPassword(input, this);
        });
    }

    // Configuración de la acción de logout con confirmación
    const btnLogout = $(".btnLogout");
    if (btnLogout.length) {
        btnLogout.on("click", function (e) {
            e.preventDefault();
            Swal.fire({
                title: "¿Estás seguro?",
                text: "Vas a cerrar tu sesión actual.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, cerrar sesión",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirige al enlace de cierre de sesión
                    window.location.href = $(this).attr('pag-redirect');
                }
            });
        });
    }

    // Configuración de la acción de eliminar con confirmación
    const btnConfirmar = $(".btnConfirmar");
    if (btnConfirmar.length){
        btnConfirmar.each(function () {
            const btn = $(this);
            const form = btn.closest("form"); // Busca el formulario más cercano
    
            btn.on("click", function (e) {
                e.preventDefault();
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Esta acción no se puede deshacer.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Envía el formulario si el usuario confirma
                    }
                });
            });
        });
    }

    // Funciones necesarias para la reserva y modificación de turnos
    const selectServicios = $('#selectMultiple');
    const data_horarios = $("#data-horarios");
    const selectFechaHora = $('#fechaHora');

    if (selectServicios.length &&
        data_horarios.length &&
        selectFechaHora.length
    ) {
        // Selección multiple de servicios con JQuery y select2
        selectServicios.select2({
            placeholder: 'Selecciona uno o más servicios', // Texto por defecto
            allowClear: true, // Permitir borrar selección
        });

        // Evento para actualizar horarios al cambiar la selección de servicios
        selectServicios.on("change", function (e) {
            e.preventDefault();
            const serviciosSeleccionados = selectServicios.val(); // Obtener los servicios seleccionados
            const idTurnoReprogramado = data_horarios.data('id-turno') || 0;
            const url = data_horarios.data('url'); // Obtener la URL del endpoint
            const token = data_horarios.data('token'); // Obtener el token CSRF
            let horarioSeleccionado = selectFechaHora.val(); // Obtener el horario anteriormente seleccionado

            // Validar que se haya seleccionado al menos un servicio
            if (!serviciosSeleccionados || serviciosSeleccionados.length === 0) {
                selectFechaHora.empty();
                selectFechaHora.append('<option value="">No hay horarios disponibles para mostrar.</option>');
                return;
            }

            console.log(serviciosSeleccionados);
            //return;

            // Realizar la solicitud AJAX
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    servicios: serviciosSeleccionados,
                    idTurnoReprogramado: idTurnoReprogramado,
                    _token: token
                },
                dataType: 'json',
                success: function (response) {
                    // Limpiar el select de horarios
                    selectFechaHora.empty();

                    if (response.length > 0) {
                        // Añadir las nuevas opciones
                        selectFechaHora.append('<option value="">Seleccione una fecha y hora</option>');
                        response.forEach(horario => {
                            const option = $('<option>', {
                                value: horario,
                                text: horario
                            });
                            // Si es el horario previamente seleccionado, marcarlo como seleccionado
                            if (horario === horarioSeleccionado) {
                                option.prop('selected', true);
                            }
                            selectFechaHora.append(option);
                        });
                    } else {
                        // Mostrar un mensaje si no hay horarios disponibles
                        selectFechaHora.append('<option value="">No hay horarios disponibles para mostrar.</option>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("Error en la petición AJAX:", textStatus, errorThrown);
                    console.error("Detalles del error:", jqXHR.responseText);
                    alert('Hubo un error al actualizar los horarios. Por favor, revisa la consola para más detalles.');
                }
            });
        })
    }
});
