<x-app-layout>
    {{-- nuevo sidebar --}}
    <!-- component -->
    <style>
        /* This example part of kwd-dashboard see https://kamona-wd.github.io/kwd-dashboard/ */
        /* So here we will write some classes to simulate dark mode and some of tailwind css config in our project */
        nav {
    position: relative;
    z-index: 1000;
}
#chartdiv {
    width: 200px; /* Ajusta el ancho según sea necesario */
    height: 100px; /* Ajusta la altura según sea necesario */
}

        :root {
        }
        label {
            color: #34495e;
            /* Puedes cambiar a otro color seg�n tus preferencias */
        }
        .hover\:overflow-y-auto:hover {
            overflow-y: auto;
        }
    </style>
    <div x-data="setup()" x-init="$refs.loading.classList.add('hidden');" :class="{ 'dark': isDark }" @resize.window="watchScreen()">
        <div class="flex h-screen antialiased text-gray-900 bg-gray-100 dark:bg-dark dark:text-light">
            <!-- Loading screen -->
            <div x-ref="loading"
                class="fixed inset-0 z-50 flex items-center justify-center text-2xl font-semibold text-white bg-neutral-800">
                Cargando.....
            </div>
            <!-- Sidebar -->
            <!-- Backdrop -->
            <div x-show="isSidebarOpen" @click="isSidebarOpen = false" class="fixed inset-0 z-10 bg-neutral-800 lg:hidden"
                style="opacity: 0.5" aria-hidden="true"></div>

            <aside x-show="isSidebarOpen" x-transition:enter="transition-all transform duration-300 ease-in-out"
                x-transition:enter-start="-translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition-all transform duration-300 ease-in-out"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="-translate-x-full opacity-0" x-ref="sidebar"
                @keydown.escape="window.innerWidth <= 1024 ? isSidebarOpen = false : ''" tabindex="-1"
                class="fixed inset-y-0 z-10 flex flex-shrink-0 overflow-hidden bg-white border-r lg:static dark:border-neutral-800  focus:outline-none">
                <!-- Mini column -->
                <div class="flex flex-col flex-shrink-0 h-full px-2 py-4 border-r dark:border-neutral-800 bg-gray-300 hidden">
                    <!-- Brand -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('Ver.graficos') }}"
                            class="inline-block text-xl font-bold tracking-wider text-neutral-700 uppercase dark:text-light">
                            <img src="{{ asset('storage/logoAgrogesAjustado.png') }}"
                                class="bg-cover bg-center bg-auto w-14 rounded-lg shadow-lg shadow-neutral-800">
                        </a>
                    </div>
                    <div class="flex flex-col items-center justify-center flex-1 space-y-4">
                        <!-- Notification button -->
                        <button @click="openNotificationsPanel"
                            class="p-2 text-neutral-400 transition-colors duration-200 rounded-full bg-neutral-50 hover:text-neutral-600 hover:bg-neutral-100 hover:text-light dark:hover:bg-neutral-700 dark:bg-dark focus:outline-none focus:bg-neutral-100 dark:focus:bg-neutral-700 focus:ring-neutral-800">
                            
                            @livewire('notificacion.campana')
                        </button>
                        <!-- Settings button -->
                        <button @click="openSettingsPanel"
                            class=" p-2 text-neutral-400 transition-colors duration-200 rounded-full bg-neutral-50 hover:text-neutral-600 hover:bg-neutral-100 hover:text-light dark:hover:bg-neutral-700 dark:bg-dark focus:outline-none focus:bg-neutral-100 dark:focus:bg-neutral-700 focus:ring-neutral-800">
                            <span class="sr-only">Open settings panel</span>
                            <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                    <!-- Mini column footer -->
                    <div class="relative flex items-center justify-center flex-shrink-0">
                        <!-- User avatar button -->
                        <div class="" x-data="{ open: false }">
                            <button @click="open = !open; $nextTick(() => { if(open){ $refs.userMenu.focus() } })"
                                type="button" aria-haspopup="true" :aria-expanded="open ? 'true' : 'false'"
                                class="block transition-opacity duration-200 rounded-full dark:opacity-75 dark:hover:opacity-100 focus:outline-none focus:ring dark:focus:opacity-100">
                                <span class="sr-only">User menu</span>
                                <i class="fa-regular fa-user fa-2xl"></i>
                            </button>
                            <!-- User dropdown menu -->
                            <div x-show="open" x-ref="userMenu" x-transition:enter="transition-all transform ease-out"
                                x-transition:enter-start="-translate-y-1/2 opacity-0"
                                x-transition:enter-end="translate-y-0 opacity-100"
                                x-transition:leave="transition-all transform ease-in"
                                x-transition:leave-start="translate-y-0 opacity-100"
                                x-transition:leave-end="-translate-y-1/2 opacity-0" @click.away="open = false"
                                @keydown.escape="open = false"
                                class="absolute w-56 py-1 mb-4 bg-white rounded-md shadow-lg min-w-max left-5 bottom-full ring-1 ring-black ring-opacity-5 bg-dark focus:outline-none"
                                tabindex="-1" role="menu" aria-orientation="vertical" aria-label="User menu">
                                <a href="{{ route('profile.show') }}" role="menuitem"
                                    class="block px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100 dark:text-light dark:hover:bg-neutral-600">
                                    @if (auth()->check())
                                        {{ auth()->user()->name }}
                                    @else
                                        {{-- Código para mostrar cuando el usuario no está autenticado --}}
                                        Usuario no autenticado
                                    @endif
                                    {{-- Cierre de la sesión, independientemente de si el usuario está autenticado o no --}}
                                    @if (auth()->check())
                                        {{-- Código adicional si el usuario está autenticado --}}
                                    @else
                                        {{-- modal session --}}
                                        <!-- Modal -->
                                        <div data-te-modal-init
                                            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
                                            id="staticBackdrop" data-te-backdrop="static" data-te-keyboard="false"
                                            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div data-te-modal-dialog-ref
                                                class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
                                                <div
                                                    class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                                                    <div
                                                        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                                                        <!--Modal title-->
                                                        <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                                                            id="staticBackdropLabel">
                                                            Modal title
                                                        </h5>
                                                        <!--Close button-->
                                                        <button type="button"
                                                            class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                                                            data-te-modal-dismiss aria-label="Close">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="h-6 w-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <!--Modal body-->
                                                    <div data-te-modal-body-ref class="relative p-4">...</div>
                                                    <!--Modal footer-->
                                                    <div
                                                        class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                                                        <button type="button"
                                                            class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                                                            data-te-modal-dismiss data-te-ripple-init
                                                            data-te-ripple-color="light">
                                                            Close
                                                        </button>
                                                        <button type="button"
                                                            class="ml-1 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                                                            data-te-ripple-init data-te-ripple-color="light">
                                                            Understood
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- fin modal --}}
                                    @endif
                                    <a href="#" role="menuitem"
                                        class="block px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100 dark:text-light dark:hover:bg-neutral-600">
                                        <form method="POST" action="{{ route('logout') }}" x-data>
                                            @csrf
                                            <x-dropdown-link href="{{ route('logout') }}"
                                                @click.prevent="$root.submit();">
                                                {{ __('Salir') }}
                                            </x-dropdown-link>
                                        </form>
                                    </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sidebar links -->
                <nav aria-label="Main"
                    class="bg-gray-900 flex-1 w-64 px-1 py-4 space-y-2 overflow-y-hidden hover:overflow-y-auto shadow-lg shadow-neutral-500 borded-2">
                    <!-- Dashboards links -->
                    @can('prod.menu.btn')
                        <div x-data="{ isActive: false, open: false }">
                            <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                            <a href="#" @click="$event.preventDefault(); open = !open"
                                class="flex items-center p-2 text-gray-100 transition-colors rounded-md dark:text-white hover:bg-neutral-600 dark:hover:bg-neutral-900"
                                :class="{ 'bg-neutral-600 bg-neutral-600': isActive || open }" role="button"
                                aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                                <span aria-hidden="true">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </span>
                                <span class="ml-2 text-sm"> Producción. </span>
                                <span class="ml-auto" aria-hidden="true">
                                    <!-- active class 'rotate-180' -->
                                    <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </a>
                            <div role="menu" x-show="open" class="mt-2 space-y-2 px-7" aria-label="Dashboards">
                                @can('prod.crear.despacho')
                                    <a href="{{ route('Guias.index') }}" role="menuitem"
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Despacho&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                @endcan
                                @can('prod.crear.recepcion')
                                    <a href="{{ route('Guias.recepcion') }}" role="menuitem"
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Recepción&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-arrow-left"></i>
                                    </a>
                                @endcan
                                @can('prod.crear.devtras')
                                    <a href="{{ route('Devolucion.Envases') }}" role="menuitem"
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Traspaso/Devolucion&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-arrows-turn-to-dots"></i>
                                    </a>
                                @endcan
                                @can('prod.guias.finalizadas')
                                    <a href="{{ route('Guias.show') }}" role="menuitem"
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Guías Emitidas&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-clipboard"></i>
                                    </a>
                                @endcan
                                <hr>
                                @can('adm.crear.planificacion')
                                    <a href="{{ route('Cosecha.planificacionCreate') }}" role="menuitem"
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Planificaciones&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-calendar-days"></i>
                                    </a>
                                @endcan
                                @can('adm.ver.planificacion')
                                    <a href="{{ route('Cosecha.planificacion') }}" role="menuitem"
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Ver Planificaciones&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-search"></i>
                                    </a>
                                @endcan
                                @can('adm.crear.plantacion')
                                    <a href="{{ route('Plantacion.create') }}" role="menuitem"
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Plantaciones&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-tree"></i>
                                    </a>
                                @endcan
                                @can('adm.ver.plantacion')
                                    <a href="{{ route('Plantacion.index') }}" role="menuitem"
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Ver Plantaciones&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-search"></i>
                                    </a>
                                @endcan
                                @can('adm.crear.cosechar')
                                    <hr>
                                    <a href="{{ route('Cosecha.index') }}" role="menuitem"
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Ver Cosechas&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-apple-whole"></i>
                                    </a>
                                @endcan
                                @can('adm.ver.cosechas.finalizadas')
                                    <a href="{{ route('CosechasCerradas.index') }}" role="menuitem" {{-- class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400"> --}}
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Cosechas Realizadas&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-carrot"></i>
                                    </a>
                                @endcan
                            </div>
                        </div>
                    @endcan
                    @can('Adm.menu.btn')
                        <!-- Components links -->
                        <div x-data="{ isActive: false, open: false }">
                            <!-- active classes 'bg-neutral-100 dark:bg-neutral-600' -->
                            <a href="#" @click="$event.preventDefault(); open = !open"
                                class="flex items-center p-2 text-gray-100 transition-colors rounded-md dark:text-white hover:bg-neutral-600 dark:hover:bg-neutral-900"
                                :class="{ 'bg-neutral-100 bg-neutral-600': isActive || open }" role="button"
                                aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                                <span aria-hidden="true">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                </span>
                                <span class="ml-2 text-sm"> Usuario y Roles </span>
                                <span aria-hidden="true" class="ml-auto">
                                    <!-- active class 'rotate-180' -->
                                    <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </a>
                            <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" arial-label="Components">
                                @can('adm.crear.usuarios')
                                    <a href="{{ route('User.create') }}" role="menuitem"
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Crear Usuarios&nbsp;&nbsp;&nbsp;<i class="fa-regular fa-plus"></i>
                                    </a>
                                @endcan
                                @can('adm.ver.usuarios')
                                    <a href="{{ route('User.index') }}" role="menuitem"
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Ver Usuarios&nbsp;&nbsp;&nbsp;<i class="fa-regular fa-users"></i>
                                    </a>
                                @endcan
                                @can('adm.crear.roles')
                                    <a href="{{ route('Rol.create') }}" role="menuitem"
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Roles y Permisos&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-plus"></i>

                                    </a>
                                @endcan
                                @can('adm.ver.roles')
                                    <a href="{{ route('RolePermisos.index') }}" role="menuitem"
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Ver Roles/Permisos&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-table-list"></i>
                                    </a>
                                @endcan
                               
                            </div>
                        </div>
                    @endcan
                    @can('Adm.emp.btn')
                        <!-- Pages links -->
                        <div x-data="{ isActive: false, open: false }">
                            <!-- active classes 'bg-neutral-100 dark:bg-neutral-600' -->
                            <a href="#" @click="$event.preventDefault(); open = !open"
                                class="flex items-center p-2 text-gray-100 transition-colors rounded-md dark:text-white hover:bg-neutral-600 dark:hover:bg-neutral-900"
                                :class="{ 'bg-neutral-100 bg-neutral-600': isActive || open }" role="button"
                                aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                                <span aria-hidden="true">
                                   <i class="fa-solid fa-building ml-1 mr-1"></i>
                                </span>
                                <span class="ml-2 text-sm"> Empresas </span>
                                <span aria-hidden="true" class="ml-auto">
                                    <!-- active class 'rotate-180' -->
                                    <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </a>
                            <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" arial-label="Pages">
                                @can('adm.crear.empresas')
                                    <a href="{{ route('Empresa.create') }}" role="menuitem"
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Crear Empresa&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-plus ml-1 mr-1"></i>
                                    </a>
                                @endcan
                                @can('adm.ver.empresas')
                                    <a href="{{ route('Empresa.index') }}" role="menuitem"
                                        class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                        Ver Empresas&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-search ml-1 mr-1"></i>
                                    </a>
                                @endcan
                               
                            </div>
                        </div>
                    @endcan
                    <!-- Authentication links -->
                    <div x-data="{ isActive: false, open: false }">
                        <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                        <a href="#" @click="$event.preventDefault(); open = !open"
                            class="flex items-center p-2 text-gray-100 transition-colors rounded-md dark:text-white hover:bg-neutral-600 dark:hover:bg-neutral-900"
                            :class="{ 'bg-neutral-100 bg-neutral-600': isActive || open }" role="button"
                            aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                            <span aria-hidden="true">
                                
                                <i class="fa-solid fa-layer-group ml-1 mr-1"></i>
                            </span>
                            <span class="ml-2 text-sm"> Campos </span>
                            <span aria-hidden="true" class="ml-auto">
                                <!-- active class 'rotate-180' -->
                                <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </a>
                        <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" aria-label="Authentication">
                            <a href="{{ route('Campo.create') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Creación de Campos&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Layouts links -->
                    <div x-data="{ isActive: false, open: false }">
                        <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                        <a href="#" @click="$event.preventDefault(); open = !open"
                            class="flex items-center p-2 text-gray-100 transition-colors rounded-md dark:text-white hover:bg-neutral-600 dark:hover:bg-neutral-900"
                            :class="{ 'bg-neutral-100 bg-neutral-600': isActive || open }" role="button"
                            aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                            <span aria-hidden="true">
                               <i class="fa-solid fa-hashtag ml-1 mr-1"></i>
                            </span>
                            <span class="ml-2 text-sm"> Cuarteles </span>
                            <span aria-hidden="true" class="ml-auto">
                                <!-- active class 'rotate-180' -->
                                <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </a>
                        <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" aria-label="Authentication">
                            <a href="{{ route('Cuartel.create') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Crear Cuarteles&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-plus"></i>
                            </a>
                            
                        </div>
                    </div>
                    <!-- Layouts links -->
                    <div x-data="{ isActive: false, open: false }">
                        <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                        <a href="#" @click="$event.preventDefault(); open = !open"
                            class="flex items-center p-2 text-gray-100 transition-colors rounded-md dark:text-white hover:bg-neutral-600 dark:hover:bg-neutral-900"
                            :class="{ 'bg-neutral-100 bg-neutral-600': isActive || open }" role="button"
                            aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                            <span aria-hidden="true">
                              <i class="fa-solid fa-medal ml-1 mr-1"></i>
                            </span>
                            <span class="ml-2 text-sm"> Certificaciones</span>
                            <span aria-hidden="true" class="ml-auto">
                                <!-- active class 'rotate-180' -->
                                <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </a>
                        <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" aria-label="Authentication">
                            <a href="{{ route('Certificacion.index') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Campos&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-layer-group"></i>
                            </a>
                            <a href="{{ route('CertificacionCuartel.index') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Cuarteles&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-hashtag"></i>
                            </a>
                            
                        </div>
                    </div>
                    {{-- boton planificacion estimada --}}
                    <!-- Layouts links -->
                    {{-- @can('Adm.plan.est.btn') --}}
                    <div x-data="{ isActive: false, open: false }">
                        <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                        <a href="#" @click="$event.preventDefault(); open = !open"
                            class="flex items-center p-2 text-gray-100 transition-colors rounded-md dark:text-white hover:bg-neutral-600 dark:hover:bg-neutral-900"
                            :class="{ 'bg-neutral-100 bg-neutral-600': isActive || open }" role="button"
                            aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                            <span aria-hidden="true">
                               <i class="fa-solid fa-paperclip"></i>
                            </span>
                            <span class="ml-2 text-sm">Estimación Producción</span>
                            <span aria-hidden="true" class="ml-auto">
                                <!-- active class 'rotate-180' -->
                                <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </a>
                        <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" aria-label="Authentication">
                            <a href="{{ route('Create.plan') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Planificar&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-paperclip"></i>
                            </a>
                            {{-- @endcan --}}
                            {{-- @can('prod.plan.estimada.ver') --}}
                            <a href="{{ route('PlanEstimado.index') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Ver Planificaciones&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-search"></i>
                            </a>
                          
                        </div>
                    </div>
                    {{-- fin boton --}}
                    {{-- @endcan --}}
                    <!-- Layouts links -->
                    <div x-data="{ isActive: false, open: false }">
                        <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                        <a href="#" @click="$event.preventDefault(); open = !open"
                            class="flex items-center p-2 text-gray-100 transition-colors rounded-md dark:text-white hover:bg-neutral-600 dark:hover:bg-neutral-900"
                            :class="{ 'bg-neutral-100 bg-neutral-600': isActive || open }" role="button"
                            aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                            <span aria-hidden="true">
                               <i class="fa-solid fa-truck"></i>
                            </span>
                            <span class="ml-2 text-sm"> Registro Vehículos</span>
                            <span aria-hidden="true" class="ml-auto">
                                <!-- active class 'rotate-180' -->
                                <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </a>
                        <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" aria-label="Authentication">
                            <a href="{{ route('Vehiculos.index') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Registrar Vehículos&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-truck"></i>
                            </a>
                            
                        </div>
                    </div>
                    {{-- boton planificacion estimada --}}
                    <!-- Layouts links -->
                    <div x-data="{ isActive: false, open: false }">
                        <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                        <a href="#" @click="$event.preventDefault(); open = !open"
                            class="flex items-center p-2 text-gray-100 transition-colors rounded-md dark:text-white hover:bg-neutral-600 dark:hover:bg-neutral-900"
                            :class="{ 'bg-neutral-100 bg-neutral-600': isActive || open }" role="button"
                            aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                            <span aria-hidden="true">
                               <i class="fa-solid fa-warehouse"></i>
                            </span>
                            <span class="ml-2 text-sm"> Control Bodega</span>
                            <span aria-hidden="true" class="ml-auto">
                                <!-- active class 'rotate-180' -->
                                <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </a>
                        <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" aria-label="Authentication">
                            <a href="{{ route('bodega.ingreso') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Ingresos&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-warehouse"></i>&nbsp;&nbsp;&nbsp;<i
                                    class="fa-solid fa-truck-ramp-box"></i>
                            </a>
                            <a href="{{ route('bodega.egreso') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Entregas&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-warehouse"></i>&nbsp;&nbsp;&nbsp;<i
                                    class="fa-solid fa-share-from-square"></i>
                            </a>
                            <a href="{{ route('Registros.bodega') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Registros Bodega&nbsp;&nbsp;&nbsp;<i
                                    class="fa-solid fa-warehouse"></i>&nbsp;&nbsp;&nbsp;<i
                                    class="fa-solid fa-search"></i>
                            </a>
                        </div>
                    </div>
                    {{-- boton planificacion estimada --}}
                    <!-- Layouts links -->
                    <div x-data="{ isActive: false, open: false }">
                        <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                        <a href="#" @click="$event.preventDefault(); open = !open"
                            class="flex items-center p-2 text-gray-100 transition-colors rounded-md dark:text-white hover:bg-neutral-600 dark:hover:bg-neutral-900"
                            :class="{ 'bg-neutral-100 bg-neutral-600': isActive || open }" role="button"
                            aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                            <span aria-hidden="true">
                                <i class="fa-solid fa-list-check"></i>
                            </span>
                            <span class="ml-2 text-sm"> Administracion Tareas</span>
                            <span aria-hidden="true" class="ml-auto">
                                <!-- active class 'rotate-180' -->
                                <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </a>
                        <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" aria-label="Authentication">
                            <a href="{{ route('Tarea.crear') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Crear&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-plus"></i>
                            </a>
                            <a href="{{ route('bodega.egreso') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Listar&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-search"></i>
                            </a>
                            <a href="{{ route('Tareas.planificadas') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Tareas Planificadas&nbsp;&nbsp;&nbsp;<i class="fa-regular fa-calendar-days"></i>
                            </a>
                            <a href="{{ route('Tareas.finalizadas') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Tareas Realizadas&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-calendar-check"></i></i>
                            </a>
                        </div>
                    </div>
                    {{-- boton planificacion estimada --}}
                    {{-- boton admin cuentas --}}
                    <!-- Layouts links -->
                    <div x-data="{ isActive: false, open: false }">
                        <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                        <a href="#" @click="$event.preventDefault(); open = !open"
                            class="flex items-center p-2 text-gray-100 transition-colors rounded-md dark:text-white hover:bg-neutral-600 dark:hover:bg-neutral-900"
                            :class="{ 'bg-neutral-100 bg-neutral-600': isActive || open }" role="button"
                            aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                            <span aria-hidden="true">
                               <i class="fa-solid fa-box ml-1 mr-1"></i>
                            </span>
                            <span class="ml-2 text-sm">Cuentas Envases</span>
                            <span aria-hidden="true" class="ml-auto">
                                <!-- active class 'rotate-180' -->
                                <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </a>
                        <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" aria-label="Authentication">
                            <!-- active & hover classes 'text-gray-700 dark:text-light' -->
                            <!-- inActive classes 'text-gray-400 dark:text-gray-400' -->
                            <a href="{{ route('CuentaCorriente.index') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Campos&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-layer-group"></i>
                            </a>
                            <a href="{{ route('CuentaCorrienteExportadoras.index') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                Exportadoras&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-hashtag"></i>
                            </a>
                             
                      
                        </div>
                    </div>
                    {{-- boton cuentas--}}
                    {{-- boton env esp variedades --}}
                    <!-- Layouts links -->
                    <div x-data="{ isActive: false, open: false }">
                        <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                        <a href="#" @click="$event.preventDefault(); open = !open"
                            class="flex items-center p-2 text-gray-100 transition-colors rounded-md dark:text-white hover:bg-neutral-600 dark:hover:bg-neutral-900"
                            :class="{ 'bg-neutral-100 bg-neutral-600': isActive || open }" role="button"
                            aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                            <span aria-hidden="true">
                               <i class="fa-solid fa-gear ml-1 mr-1"></i>
                            </span>
                            <span class="ml-2 text-sm">Conf. Envas.,Especie.,Varie.</span>
                            <span aria-hidden="true" class="ml-auto">
                                <!-- active class 'rotate-180' -->
                                <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </a>
                        <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" aria-label="Authentication">
                            <!-- active & hover classes 'text-gray-700 dark:text-light' -->
                            <!-- inActive classes 'text-gray-400 dark:text-gray-400' -->
                            <a href="{{ route('Parametros.index') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                <i class="fa-solid fa-box"></i>&nbsp;&nbsp;&nbsp;<i
                                                class="fa-solid fa-apple-whole"></i>&nbsp;&nbsp;&nbsp;<i
                                                class="fa-solid fa-tag"></i>&nbsp;&nbsp;&nbsp;Envases,Especies,Variedades
                            </a>
                        </div>
                    </div>
                    {{-- boton cuentas--}}
                    {{-- boton cierres --}}
                    <!-- Layouts links -->
                    <div x-data="{ isActive: false, open: false }">
                        <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                        <a href="#" @click="$event.preventDefault(); open = !open"
                            class="flex items-center p-2 text-gray-100 transition-colors rounded-md dark:text-white hover:bg-neutral-600 dark:hover:bg-neutral-900"
                            :class="{ 'bg-neutral-100 bg-neutral-600': isActive || open }" role="button"
                            aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                            <span aria-hidden="true">
                               <i class="fa-solid fa-arrow-down-up-across-line"></i> 
                            </span>
                            <span class="ml-2 text-sm">Cierre Temp. Camp./Cuart.</span>
                            <span aria-hidden="true" class="ml-auto">
                                <!-- active class 'rotate-180' -->
                                <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </a>
                        <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" aria-label="Authentication">
                            <a href="{{ route('CierreInicioTemporada.index') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                <i class="fa-solid fa-box-open"></i>&nbsp;&nbsp;&nbsp;Cierres de Temporada
                            </a>
                        </div>
                    </div>
                    <div class="text-center">
                         
                    {{-- boton cierres--}}
                                        <!-- Layouts links -->
                    <div x-data="{ isActive: false, open: false }">
                        <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                        <a href="#" @click="$event.preventDefault(); open = !open"
                            class="flex items-center p-2 text-gray-100 transition-colors rounded-md dark:text-white hover:bg-neutral-600 dark:hover:bg-neutral-900"
                            :class="{ 'bg-neutral-100 bg-neutral-600': isActive || open }" role="button"
                            aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                            <span aria-hidden="true">
                               <i class="fa-solid fa-store"></i> 
                            </span>
                            <span class="ml-2 text-sm">Bodega e Items</span>
                            <span aria-hidden="true" class="ml-auto">
                                <!-- active class 'rotate-180' -->
                                <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </a>
                        <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" aria-label="Authentication">
                            <a href="{{ route('BodegaItem.show') }}" role="menuitem"
                                class="block p-2 text-sm transition-colors duration-200 rounded-md text-gray-100 hover:text-orange-400">
                                <i class="fa-solid fa-box-open"></i>&nbsp;&nbsp;&nbsp;Crear Bodega/Items
                            </a>
                        </div>
                    </div>
                    <div class="text-center">
                         <button @click="openNotificationsPanel"
                            class="p-2 text-neutral-400 transition-colors duration-200 rounded-full bg-gray-900 hover:text-neutral-600 hover:bg-neutral-100 hover:text-light dark:hover:bg-neutral-700 dark:bg-dark focus:outline-none focus:bg-neutral-100 dark:focus:bg-neutral-700 focus:ring-neutral-800">
                            
                            @livewire('notificacion.campana')
                        </button>
                    {{-- boton cierres--}}
                    </div>
                </nav>
            </aside>
            <!-- Sidebars button -->
            <div class="fixed flex items-center space-x-4 top-5 right-10 lg:hidden">
                <button @click="isSidebarOpen = true; $nextTick(() => { $refs.sidebar.focus() })"
                    class="p-1 text-neutral-400 transition-colors duration-200 rounded-md bg-neutral-50 hover:text-neutral-600 hover:bg-neutral-100 hover:text-light dark:hover:bg-neutral-700 dark:bg-dark focus:outline-none focus:ring">
                    <span class="sr-only">Toggle main manu</span>
                    <span aria-hidden="true">
                        <svg x-show="!isSidebarOpen" class="w-8 h-8" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="isSidebarOpen" class="w-8 h-8" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </button>
            </div>
            {{-- fin --}}
            <!-- Main content -->
          
            <main class="flex-1 p-1 bg-neutral-100">
                {{ $slot }}
                <!-- component -->
                <!-- This is an example component -->
              
  
            
                <div class="text-right mt-2 mb-2 mr-2 fixed bottom-0 left-15 right-0">
                    <footer class="p-1 bg-gray-900 rounded-lg shadow md:flex md:items-center md:p-1 dark:bg-gray-800">
                        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a
                                href="https://flowbite.com" class="hover:underline" target="_blank">Comercial Caro
                                Hnos. SpA™</a>. All Rights Reserved.
                        </span>
                        <ul class="flex flex-wrap items-center mt-2 ml-2 sm:mt-0">
                            <li>
                                <a href="#"
                                    class="mr-4 text-sm text-white hover:underline md:mr-6 dark:text-white">Soporte</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="mr-4 text-sm text-white hover:underline md:mr-6 dark:text-white">Manual del
                                    Sistema
                                </a>
                            </li>
                            <li>
                                <div class="inline-block mr-4 text-sm text-gray-500 md:mr-6 dark:text-gray-400">
                                    @if (auth()->check())
                                        <label class="text-white">Usuario:</label>&nbsp;&nbsp;&nbsp;<label class="text-amber-300">{{ auth()->user()->name }}</label>
                                </div>
                                
                                <div class="inline-block mr-4 text-sm text-gray-500 md:mr-6 dark:text-gray-400">
                                        <form method="POST" action="{{ route('logout') }}" x-data>
                                            @csrf
                                            <a href="{{ route('logout') }}"
                                                @click.prevent="$root.submit();">
                                                <div>
                                                    <span class="group relative">
                                                        <div class="absolute bottom-[calc(100%+0.5rem)] left-[50%] -translate-x-[50%] hidden group-hover:block w-auto">
                                                        <div class="bottom-full right-0 rounded bg-gray-900 border-2 px-4 py-1 text-xs text-white whitespace-nowrap">
                                                            Cerrar Sesión
                                                            <svg class="absolute left-0 top-full h-2 w-full text-black" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve"><polygon class="fill-current" points="0,0 127.5,127.5 255,0" /></svg>
                                                        </div>
                                                        </div>
                                                        <span><i class="fa-solid fa-door-open text-green-500"></i></span>
                                                    </span>
                                                    </div>
                                                
                                                {{-- {{ __('Cerrar Sesión') }} --}}
                                            </a>
                                        </form>
                                </div>
                                <div class="inline block mt-1 mr-5">
                                    <span class="group relative">
                                        <div class="absolute bottom-[calc(100%+0.5rem)] left-[50%] -translate-x-[50%] hidden group-hover:block w-auto">
                                            <div class="bottom-full right-0 rounded bg-gray-900 border-2 px-4 py-1 text-xs text-white whitespace-nowrap">
                                                Gráficos
                                                <svg class="absolute left-0 top-full h-2 w-full text-black" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve"><polygon class="fill-current" points="0,0 127.5,127.5 255,0" /></svg>
                                            </div>
                                        </div>
                                        <span class="mt-1"> <a href="{{ route('Ver.graficos') }}">
                                        <i class="fa-solid fa-chart-simple text-white mt-1"></i>
                                    </a></span>
                                    </span>
                                </div>
                                <!-- component -->
                            </li>
                            {{-- Código para mostrar cuando el usuario no está autenticado --}}
                            @else
                                <label class="text-white">Usuario:</label>&nbsp;&nbsp;&nbsp; no autenticado, <a href="/">Iniciar Sesión</a>
                            @endif
                        </ul>
                    </footer>
                </div>
            </main>
            <!-- Panels -->
            <!-- Settings Panel -->
            <!-- Backdrop -->
            <div x-transition:enter="transition duration-300 ease-in-out" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300 ease-in-out"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                x-show="isSettingsPanelOpen" @click="isSettingsPanelOpen = false"
                class="fixed inset-0 z-10 bg-neutral-800" style="opacity: 0.5" aria-hidden="true"></div>
            <!-- Panel -->
            <section x-transition:enter="transition duration-300 ease-in-out transform sm:duration-500"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition duration-300 ease-in-out transform sm:duration-500"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                x-ref="settingsPanel" tabindex="-1" x-show="isSettingsPanelOpen"
                @keydown.escape="isSettingsPanelOpen = false"
                class="fixed inset-y-0 right-0 z-20 w-full max-w-xs bg-white shadow-xl  dark:text-light sm:max-w-md focus:outline-none"
                aria-labelledby="settinsPanelLabel">
                <div class="absolute left-0 p-2 transform -translate-x-full">
                    <!-- Close button -->
                    <button @click="isSettingsPanelOpen = false"
                        class="p-2 text-white rounded-md focus:outline-none focus:ring">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Panel content -->
                <div class="flex flex-col h-screen">
                    <!-- Panel header -->
                    <div
                        class="flex flex-col items-center justify-center flex-shrink-0 px-4 py-8 space-y-4 border-b dark:border-neutral-700">
                        <span aria-hidden="true" class="text-gray-500 dark:text-neutral-600">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </span>
                        <h2 id="settinsPanelLabel" class="text-xl font-medium text-gray-900">
                            Configuración del Sistema</h2>
                    </div>
                    <!-- Content -->
                    <div class="flex-1 overflow-hidden hover:overflow-y-auto">
                        <!-- Theme -->
                        <div class="p-4 space-y-4 md:p-8">
                            <h6 class="mb-5 text-center text-lg font-medium text-gray-400">Menu
                                Administrador</h6>
                            <div class="flex flex-col">
                             
                                {{-- boton nuevo --}}
                                <!-- Layouts links -->
                                <div x-data="{ isActive: false, open: false }">
                                    <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                                    <a href="#" @click="$event.preventDefault(); open = !open"
                                        class="mb-2 flex items-center border-2 p-2 text-gray-900 transition-colors rounded-md w-full hover:bg-neutral-600 dark:hover:bg-neutral-900 hover:text-white"
                                        :class="{ 'bg-neutral-100 dark:bg-neutral-500': isActive || open }"
                                        role="button" aria-haspopup="true"
                                        :aria-expanded="(open || isActive) ? 'true' : 'false'">
                                        <span aria-hidden="true">
                                           <i class="fa-solid fa-box ml-1 mr-1"></i>
                                        </span>
                                        <span class="ml-2 text-sm"> Cuentas Corrientes Envases</span>
                                        <span aria-hidden="true" class="ml-auto">
                                            <!-- active class 'rotate-180' -->
                                            <svg class="ml-5 w-4 h-4 transition-transform transform"
                                                :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </span>
                                    </a>
                                    <div x-show="open" class="mt-2 space-y-2 px-7" role="menu"
                                        aria-label="Authentication">
                                        <!-- active & hover classes 'text-gray-700 dark:text-light' -->
                                        <!-- inActive classes 'text-gray-400 dark:text-gray-400' -->
                                        <a href="{{ route('CuentaCorriente.index') }}" role="menuitem"
                                            class="text-left block p-2 text-sm text-gray-300 transition-colors duration-200 rounded-md dark:text-gray-900 hover:text-light hover:text-white hover:bg-gray-500">
                                            <i class="fa-solid fa-layer-group"></i>&nbsp;&nbsp;&nbsp;Campos
                                        </a>
                                        <a href="{{ route('CuentaCorrienteExportadoras.index') }}" role="menuitem"
                                            class="text-left block p-2 text-sm text-gray-300 transition-colors duration-200 rounded-md dark:text-gray-900 hover:text-light hover:text-white hover:bg-gray-500">
                                            <i class="fa-solid fa-hashtag"></i>&nbsp;&nbsp;&nbsp;Exportadoras
                                        </a>
                                       
                                    </div>
                                </div>
                                {{-- fin boton nuevo --}}
                                {{-- boton nuevo --}}
                                <!-- Layouts links -->
                                <div x-data="{ isActive: false, open: false }">
                                    <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                                    <a href="#" @click="$event.preventDefault(); open = !open"
                                        class="flex items-center border-2 p-2 text-gray-900 transition-colors rounded-md w-full hover:bg-neutral-600 dark:hover:bg-neutral-900 hover:text-white"
                                        :class="{ 'bg-neutral-100 dark:bg-neutral-500': isActive || open }"
                                        role="button" aria-haspopup="true"
                                        :aria-expanded="(open || isActive) ? 'true' : 'false'">
                                        <span aria-hidden="true">
                                           <i class="fa-solid fa-gear ml-1 mr-1"></i>
                                        </span>
                                        <span class="ml-2 text-sm"> configuración Envases, Especies, Variedades</span>
                                        <span aria-hidden="true" class="ml-auto">
                                            <!-- active class 'rotate-180' -->
                                            <svg class="ml-5 w-4 h-4 transition-transform transform"
                                                :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </span>
                                    </a>
                                    <div x-show="open" class="mt-2 space-y-2 px-7" role="menu"
                                        aria-label="Authentication">
                                        <!-- active & hover classes 'text-gray-700 dark:text-light' -->
                                        <!-- inActive classes 'text-gray-400 dark:text-gray-400' -->
                                        <a href="{{ route('Parametros.index') }}" role="menuitem"
                                            class="text-left block p-2 text-sm text-gray-300 transition-colors duration-200 rounded-md dark:text-gray-900 hover:text-light hover:text-white hover:bg-gray-500">
                                            <i class="fa-solid fa-box"></i>&nbsp;&nbsp;&nbsp;<i
                                                class="fa-solid fa-apple-whole"></i>&nbsp;&nbsp;&nbsp;<i
                                                class="fa-solid fa-tag"></i>&nbsp;&nbsp;&nbsp;Envases,Especies,Variedades
                                        </a>
                                       
                                    </div>
                                </div>
                                {{-- fin boton nuevo --}}
                                {{-- boton nuevo --}}
                                <!-- Layouts links -->
                                <div x-data="{ isActive: false, open: false }">
                                    <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                                    <a href="#" @click="$event.preventDefault(); open = !open"
                                        class="mb-2 flex items-center border-2 p-2 text-gray-900 transition-colors rounded-md w-full hover:bg-neutral-600 dark:hover:bg-neutral-900 hover:text-white"
                                        :class="{ 'bg-neutral-100 dark:bg-neutral-500': isActive || open }"
                                        role="button" aria-haspopup="true"
                                        :aria-expanded="(open || isActive) ? 'true' : 'false'">
                                        <span aria-hidden="true">
                                           <i class="fa-solid fa-arrow-down-up-across-line"></i> Cierres de Temporada Campos/cuartel
                                        </span>
                                        <span class="ml-2 text-sm">Cierres de Temporada Campos/cuartel</span>
                                        <span aria-hidden="true" class="ml-auto">
                                            <!-- active class 'rotate-180' -->
                                            <svg class="ml-5 w-4 h-4 transition-transform transform"
                                                :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </span>
                                    </a>
                                    <div x-show="open" class="mt-2 space-y-2 px-7" role="menu"
                                        aria-label="Authentication">
                                        <!-- active & hover classes 'text-gray-700 dark:text-light' -->
                                        <!-- inActive classes 'text-gray-400 dark:text-gray-400' -->
                                        <a href="{{ route('CierreInicioTemporada.index') }}" role="menuitem"
                                            class="text-left block p-2 text-sm text-gray-300 transition-colors duration-200 rounded-md dark:text-gray-900 hover:text-light hover:text-white hover:bg-gray-500">
                                            <i class="fa-solid fa-box-open"></i>&nbsp;&nbsp;&nbsp;Cierres de Temporada
                                        </a>
                                        
                                    </div>
                                </div>
                                {{-- fin boton nuevo --}}
                                <!-- Layouts links -->
                                <div x-data="{ isActive: false, open: false }">
                                    <!-- active & hover classes 'bg-neutral-100 dark:bg-neutral-600' -->
                                    <a href="#" @click="$event.preventDefault(); open = !open"
                                        class="mb-2 flex items-center border-2 p-2 text-gray-900 transition-colors rounded-md w-full hover:bg-neutral-600 dark:hover:bg-neutral-900 hover:text-white"
                                        :class="{ 'bg-neutral-100 dark:bg-neutral-500': isActive || open }"
                                        role="button" aria-haspopup="true"
                                        :aria-expanded="(open || isActive) ? 'true' : 'false'">
                                        <span aria-hidden="true">
                                           <i class="fa-solid fa-warehouse"></i>
                                        </span>
                                        <span class="ml-2 text-sm">Administracion Bodega e Items</span>
                                        <span aria-hidden="true" class="ml-auto">
                                            <!-- active class 'rotate-180' -->
                                            <svg class="ml-5 w-4 h-4 transition-transform transform"
                                                :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </span>
                                    </a>
                                    <div x-show="open" class="mt-2 space-y-2 px-7" role="menu"
                                        aria-label="Authentication">
                                        <!-- active & hover classes 'text-gray-700 dark:text-light' -->
                                        <!-- inActive classes 'text-gray-400 dark:text-gray-400' -->
                                        <a href="{{ route('BodegaItem.show') }}" role="menuitem"
                                            class="text-left block p-2 text-sm text-gray-300 transition-colors duration-200 rounded-md dark:text-gray-900 hover:text-light hover:text-white hover:bg-gray-500">
                                            <i class="fa-solid fa-warehouse"></i>&nbsp;&nbsp;&nbsp;Bodega e Items..
                                        </a>
                                      
                                    </div>
                                </div>
                                {{-- fin boton nuevo --}}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Notification panel -->
            <!-- Backdrop -->
            <div x-transition:enter="transition duration-300 ease-in-out" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300 ease-in-out"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                x-show="isNotificationsPanelOpen" @click="isNotificationsPanelOpen = false"
                class="fixed inset-0 z-10 bg-neutral-800" style="opacity: 0.5" aria-hidden="true"></div>
            <!-- Panel -->
            <section x-transition:enter="transition duration-300 ease-in-out transform sm:duration-500"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition duration-300 ease-in-out transform sm:duration-500"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                x-ref="notificationsPanel" x-show="isNotificationsPanelOpen"
                @keydown.escape="isNotificationsPanelOpen = false" tabindex="-1"
                aria-labelledby="notificationPanelLabel"
                class="fixed inset-y-0 z-20 w-full max-w-xs bg-white dark:text-light sm:max-w-md focus:outline-none">
                <div class="absolute right-0 p-2 transform translate-x-full">
                    <!-- Close button -->
                    <button @click="isNotificationsPanelOpen = false"
                        class="p-2 text-white rounded-md focus:outline-none focus:ring">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-col h-screen" x-data="{ activeTabe: 'action' }">
                    <!-- Panel header -->
                    <div class="flex-shrink-0">
                        <div
                            class="flex items-center justify-between px-4 pt-4 border-b text-neutral-800 dark:border-neutral-800">
                            <h2 id="notificationPanelLabel" class="pb-4 font-semibold text">Notificationes</h2>
                            <div class="space-x-2 p-1">
                                <button @click.prevent="activeTabe = 'action'"
                                    class="px-px pb-4 transition-all duration-200 transform translate-y-px border-b focus:outline-none"
                                    :class="{
                                        'border-neutral-700 dark:border-neutral-600': activeTabe ==
                                            'action',
                                        'border-transparent': activeTabe != 'action'
                                    }">
                                    Notificaciones Pendientes
                                </button>
                               
                            </div>
                        </div>
                    </div>
                    <!-- Panel content (tabs) -->
                    <div class="flex-1 pt-4 overflow-y-hidden hover:overflow-y-auto">
                        <!-- Action tab -->
                        <div class="space-y-4" x-show.transition.in="activeTabe == 'action'">
                            <p class="px-4">
                                @livewire('notificacion.notificaciones')
                            </p>
                        </div>
                        <!-- User tab -->
                        <div class="space-y-4" x-show.transition.in="activeTabe == 'user'">
                            <p class="px-4">Debe Realizar cosecha !!</p>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Search panel -->
            <!-- Backdrop -->
            <div x-transition:enter="transition duration-300 ease-in-out" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300 ease-in-out"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-show="isSearchPanelOpen"
                @click="isSearchPanelOpen = false" class="fixed inset-0 z-10 bg-neutral-800" style="opacity: 0.5"
                aria-hidden="ture"></div>
            <!-- Panel -->
            <section x-transition:enter="transition duration-300 ease-in-out transform sm:duration-500"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition duration-300 ease-in-out transform sm:duration-500"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                x-show="isSearchPanelOpen" @keydown.escape="isSearchPanelOpen = false"
                class="fixed inset-y-0 z-20 w-full max-w-xs bg-white shadow-xl  dark:text-light sm:max-w-md focus:outline-none">
                <div class="absolute right-0 p-2 transform translate-x-full">
                    <!-- Close button -->
                    <button @click="isSearchPanelOpen = false"
                        class="p-2 text-white rounded-md focus:outline-none focus:ring">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <h2 class="sr-only">Search panel</h2>
                <!-- Panel content -->
                <div class="flex flex-col h-screen">
                    <!-- Panel header (Search input) -->
                    <div
                        class="relative flex-shrink-0 px-4 py-8 text-gray-400 border-b dark:border-neutral-800 dark:focus-within:text-light focus-within:text-gray-700">
                        <span class="absolute inset-y-0 inline-flex items-center px-4">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input x-ref="searchInput" type="text"
                            class="w-full py-2 pl-10 pr-4 border rounded-full dark:bg-dark dark:border-transparent dark:text-light focus:outline-none focus:ring"
                            placeholder="Search..." />
                    </div>
                    <!-- Panel content (Search result) -->
                    <div class="flex-1 px-4 pb-4 space-y-4 overflow-y-hidden h hover:overflow-y-auto">
                        <h3 class="py-2 text-sm font-semibold text-gray-600 dark:text-light">History</h3>
                        <p class="px=4">Search resault</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script>
        const setup = () => {
            const getTheme = () => {
                if (window.localStorage.getItem('dark')) {
                    return JSON.parse(window.localStorage.getItem('dark'))
                }
                return !!window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
            }
            const setTheme = (value) => {
                window.localStorage.setItem('dark', value)
            }
            return {
                loading: true,
                isDark: getTheme(),
                toggleTheme() {
                    this.isDark = !this.isDark
                    setTheme(this.isDark)
                },
                setLightTheme() {
                    this.isDark = false
                    setTheme(this.isDark)
                },
                setDarkTheme() {
                    this.isDark = true
                    setTheme(this.isDark)
                },
                watchScreen() {
                    if (window.innerWidth <= 1024) {
                        this.isSidebarOpen = false
                    } else if (window.innerWidth >= 1024) {
                        this.isSidebarOpen = true
                    }
                },
                isSidebarOpen: window.innerWidth >= 1024 ? true : false,
                toggleSidbarMenu() {
                    this.isSidebarOpen = !this.isSidebarOpen
                },
                isNotificationsPanelOpen: false,
                openNotificationsPanel() {
                    this.isNotificationsPanelOpen = true
                    this.$nextTick(() => {
                        this.$refs.notificationsPanel.focus()
                    })
                },
                isSettingsPanelOpen: false,
                openSettingsPanel() {
                    this.isSettingsPanelOpen = true
                    this.$nextTick(() => {
                        this.$refs.settingsPanel.focus()
                    })
                },
                isSearchPanelOpen: false,
                openSearchPanel() {
                    this.isSearchPanelOpen = true
                    this.$nextTick(() => {
                        this.$refs.searchInput.focus()
                    })
                },
            }
        }
    </script>
    {{-- script de gauge --}}
        <script>
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/radar-chart/
var chart = root.container.children.push(am5radar.RadarChart.new(root, {
  panX: false,
  panY: false,
  startAngle: 160,
  endAngle: 380
}));


// Create axis and its renderer
// https://www.amcharts.com/docs/v5/charts/radar-chart/gauge-charts/#Axes
var axisRenderer = am5radar.AxisRendererCircular.new(root, {
  innerRadius: -40
});

axisRenderer.grid.template.setAll({
  stroke: root.interfaceColors.get("background"),
  visible: true,
  strokeOpacity: 0.8
});

var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
  maxDeviation: 0,
  min: -40,
  max: 100,
  strictMinMax: true,
  renderer: axisRenderer
}));


// Add clock hand
// https://www.amcharts.com/docs/v5/charts/radar-chart/gauge-charts/#Clock_hands
var axisDataItem = xAxis.makeDataItem({});

var clockHand = am5radar.ClockHand.new(root, {
  pinRadius: am5.percent(20),
  radius: am5.percent(100),
  bottomWidth: 40
})

var bullet = axisDataItem.set("bullet", am5xy.AxisBullet.new(root, {
  sprite: clockHand
}));

xAxis.createAxisRange(axisDataItem);

var label = chart.radarContainer.children.push(am5.Label.new(root, {
  fill: am5.color(0xffffff),
  centerX: am5.percent(50),
  textAlign: "center",
  centerY: am5.percent(50),
  fontSize: "3em"
}));

axisDataItem.set("value", 45);
bullet.get("sprite").on("rotation", function () {
  var value = axisDataItem.get("value");
  var text = Math.round(axisDataItem.get("value")).toString();
  var fill = am5.color(0x000000);
  xAxis.axisRanges.each(function (axisRange) {
    if (value >= axisRange.get("value") && value <= axisRange.get("endValue")) {
      fill = axisRange.get("axisFill").get("fill");
    }
  })

  label.set("text", Math.round(value).toString());

  clockHand.pin.animate({ key: "fill", to: fill, duration: 500, easing: am5.ease.out(am5.ease.cubic) })
  clockHand.hand.animate({ key: "fill", to: fill, duration: 500, easing: am5.ease.out(am5.ease.cubic) })
});

// setInterval(function () {
//   axisDataItem.animate({
//     key: "value",
//     to: Math.round(Math.random() * 140 - 40),
//     duration: 500,
//     easing: am5.ease.out(am5.ease.cubic)
//   });
// }, 2000)

chart.bulletsContainer.set("mask", undefined);


// Create axis ranges bands
// https://www.amcharts.com/docs/v5/charts/radar-chart/gauge-charts/#Bands
var bandsData = [{
  title: "Unsustainable",
  color: "#ee1f25",
  lowScore: -40,
  highScore: -20
}, {
  title: "Volatile",
  color: "#f04922",
  lowScore: -20,
  highScore: 0
}, {
  title: "Foundational",
  color: "#fdae19",
  lowScore: 0,
  highScore: 20
}, {
  title: "Developing",
  color: "#f3eb0c",
  lowScore: 20,
  highScore: 40
}, {
  title: "Maturing",
  color: "#b0d136",
  lowScore: 40,
  highScore: 60
}, {
  title: "Sustainable",
  color: "#54b947",
  lowScore: 60,
  highScore: 80
}, {
  title: "High Performing",
  color: "#0f9747",
  lowScore: 80,
  highScore: 100
}];

am5.array.each(bandsData, function (data) {
  var axisRange = xAxis.createAxisRange(xAxis.makeDataItem({}));

  axisRange.setAll({
    value: data.lowScore,
    endValue: data.highScore
  });

  axisRange.get("axisFill").setAll({
    visible: true,
    fill: am5.color(data.color),
    fillOpacity: 0.8
  });

  axisRange.get("label").setAll({
    text: data.title,
    inside: true,
    radius: 15,
    fontSize: "0.9em",
    fill: root.interfaceColors.get("background")
  });
});


// Make stuff animate on load
chart.appear(1000, 100);

}); // end am5.ready()
</script>
    {{-- fin --}}
</x-app-layout>
