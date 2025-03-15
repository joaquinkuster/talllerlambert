<nav class="navbar navbar-expand-lg navbar-light bg-light py-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('servicios') }}">Logo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto me-3">
                <li class="nav-item me-3">
                    <a class="nav-link  {{ request()->routeIs('servicios') ? 'active' : '' }}"
                        href="{{ route('servicios') }}">Servicios</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="#">Nosotros</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="#">Galería</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link" href="#">Contacto</a>
                </li>
                @if (auth()->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                                alt="Profile" class="rounded-circle" width="30" height="30">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('modificar.perfil') }}">
                                    <p class="mb-0">{{ Str::limit(auth()->user(), 15) }}</p>
                                    <p class="text-muted small mb-0">{{ auth()->user()->rol }}</p>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            @if (auth()->user()->rol == 'Cliente')
                                <li><a class="dropdown-item {{ request()->routeIs('vehiculos') ? 'active' : '' }}"
                                        href="{{ route('vehiculos') }}">Mis vehiculos</a></li>
                            @endif
                            <li><a class="dropdown-item {{ request()->routeIs('turnos') ? 'active' : '' }}"
                                    href="{{ route('turnos') }}">Ver turnos</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('modificar.perfil') ? 'active' : '' }}"
                                    href="{{ route('modificar.perfil') }}">Modificar perfil</a></li>
                            <li><a class="dropdown-item btnLogout" pag-redirect="/logout">Cerrar sesión</a></li>
                        </ul>
                    </li>
                    <!-- Links para el menu responsive -->
                    <li class="nav-item vehiculos d-none me-3">
                        <a class="nav-link {{ request()->routeIs('vehiculos') ? 'active' : '' }}"
                            href="{{ route('vehiculos') }}">Mis vehiculos</a>
                    </li>
                    <li class="nav-item turnos d-none me-3">
                        <a class="nav-link {{ request()->routeIs(patterns: 'turnos') ? 'active' : '' }}"
                            href="{{ route('turnos') }}">Ver turnos</a>
                    </li>
                    <li class="nav-item perfil d-none me-3">
                        <a class="nav-link {{ request()->routeIs(patterns: 'modificar.perfil') ? 'active' : '' }}"
                            href="{{ route('modificar.perfil') }}">Modificar perfil</a>
                    </li>
                    <li class="nav-item logout d-none me-3">
                        <a class="nav-link btnLogout" pag-redirect="/logout">Cerrar sesión</a>
                    </li>
                @else
                    <li class="nav-item me-3">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                            href="{{ route('login') }}">Iniciar sesión</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link {{ request()->routeIs('registro') ? 'active' : '' }}"
                            href="{{ route('registro') }}">Registrarse</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
