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
    const btnEliminar = $(".btnEliminar");
    const formEliminar = $(".formEliminar");
    if (btnEliminar.length && formEliminar.length) {
        btnEliminar.on("click", function (e) {
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
                    formEliminar.submit(); // Envía el formulario manualmente si el usuario confirma
                }
            });
        });
    }
});
