<x-app-layout>
    @if (session('message'))
    <x-alert :type="session('message')['type']" :message="session('message')['content']" />
    @endif
    <x-slot name="header">
        <x-header.simple titulo="Gestión de usuarios" />
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Título para creación de usuario -->
        <x-header.simple titulo="Crear nuevo usuario" />

        <!-- Formulario para crear usuario -->
        <div class="bg-white shadow sm:rounded-lg p-6">
            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Seleccionar Persona -->
                    <div class="sm:col-span-2">
                        <label for="persona" class="block text-sm font-medium text-gray-700">Seleccionar Persona</label>
                        <select name="persona_id" id="persona"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 sm:text-sm">
                            @foreach ($personasSinUsuario as $persona)
                                <option value="{{ $persona->id }}">{{ $persona->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('email'))
                        <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span>
                    @endif
                    </div>

                    <!-- Correo Electrónico -->
                    <div class="sm:col-span-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input type="email" name="email" id="email"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 sm:text-sm">
                    </div>

                    <!-- Carnet -->
                    <div class="sm:col-span-1">
                        <label for="carnet" class="block text-sm font-medium text-gray-700">Carnet</label>
                        <input type="text" name="carnet" id="carnet"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 sm:text-sm">
                    </div>

                    <!-- Estado Activo -->
                    <div class="col-span-1">
                        <label for="activo" class="block text-sm font-medium text-gray-700">Estado</label>
                        <div class="flex items-center mt-1">
                            <input type="checkbox" name="activo" id="activo"
                                class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <label for="activo" class="ml-2 block text-sm text-gray-900">Activo</label>
                        </div>
                    </div>
                </div>

                <!-- Picklist para gestionar roles con búsqueda -->
                <div class="mt-6 py-6">
                    <div class="bg-gray-100 text-gray-700 font-medium p-2 text-center rounded-t-md py-2">
                        Detalle de roles
                    </div>

                    <!-- Ajuste para pantallas pequeñas -->
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 py-4">
                        <!-- Lista de roles disponibles con búsqueda -->
                        <div class="w-full">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Roles disponibles</h3>
                            <input type="text" id="search-available" placeholder="Buscar roles..."
                                class="mb-2 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 sm:text-sm">

                            <ul id="available-roles" class="border border-gray-300 rounded p-2 h-48 overflow-y-auto">
                                @foreach ($roles as $role)
                                    <li class="p-2 hover:bg-gray-100 cursor-pointer"
                                        data-role-id="{{ $role->id }}" data-role-name="{{ $role->name }}">
                                        {{ $role->name }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Controles para agregar y quitar roles -->
                        <div class="flex flex-col justify-center space-y-2">
                            <button id="add-all-roles"
                                class="bg-blue-500 text-white p-1 w-min rounded-full shadow hover:bg-blue-600 flex items-center justify-center">
                                <x-heroicon-o-chevron-double-right class="h-4 w-4" />
                            </button>
                            <button id="add-role"
                                class="bg-blue-500 text-white p-1 w-min rounded-full shadow hover:bg-blue-600 flex items-center justify-center">
                                <x-heroicon-o-chevron-right class="h-4 w-4" />
                            </button>
                            <button id="remove-role"
                                class="bg-blue-500 text-white p-1 w-min rounded-full shadow hover:bg-blue-600 flex items-center justify-center">
                                <x-heroicon-o-chevron-left class="h-4 w-4" />
                            </button>
                            <button id="remove-all-roles"
                                class="bg-blue-500 text-white p-1 w-min rounded-full shadow hover:bg-blue-600 flex items-center justify-center">
                                <x-heroicon-o-chevron-double-left class="h-4 w-4" />
                            </button>
                        </div>

                        <!-- Lista de roles asignados con búsqueda -->
                        <div class="w-full">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Roles asignados</h3>
                            <input type="text" id="search-assigned" placeholder="Buscar roles..."
                                class="mb-2 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 sm:text-sm">

                            <ul id="assigned-roles" class="border border-gray-300 rounded p-2 h-48 overflow-y-auto">
                                <!-- Esta lista se rellenará con los roles asignados -->
                            </ul>
                        </div>
                    </div>

                    <!-- Input hidden para almacenar roles asignados -->
                    <input type="hidden" name="roles" id="roles-input" value="">
                </div>

                <!-- Botones para guardar o cancelar -->
                <div class="flex justify-end">
                    <a href="{{ route('usuarios.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Cancelar
                    </a>
                    <button type="submit" class="ml-3 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const availableRoles = document.querySelector('#available-roles');
        const assignedRoles = document.querySelector('#assigned-roles');
        const rolesInput = document.querySelector('#roles-input');
        const addRoleButton = document.querySelector('#add-role');
        const removeRoleButton = document.querySelector('#remove-role');
        const addAllRolesButton = document.querySelector('#add-all-roles');
        const removeAllRolesButton = document.querySelector('#remove-all-roles');

        function moveRole(fromList, toList) {
            const selectedRole = fromList.querySelector('.selected');
            if (selectedRole) {
                toList.appendChild(selectedRole);
                selectedRole.classList.remove('selected');
                updateRolesInput();
            }
        }

        function moveAllRoles(fromList, toList) {
            const roles = Array.from(fromList.querySelectorAll('li'));
            roles.forEach(role => {
                toList.appendChild(role);
            });
            updateRolesInput();
        }

        function updateRolesInput() {
            const roleIds = Array.from(assignedRoles.querySelectorAll('li'))
                .map(li => li.getAttribute('data-role-id'));
            rolesInput.value = roleIds.join(',');
        }

        function filterRoles(searchInput, list) {
            const filter = searchInput.value.toLowerCase();
            Array.from(list.querySelectorAll('li')).forEach(role => {
                const roleName = role.getAttribute('data-role-name').toLowerCase();
                if (roleName.includes(filter)) {
                    role.style.display = '';
                } else {
                    role.style.display = 'none';
                }
            });
        }

        addRoleButton.addEventListener('click', (event) => {
            event.preventDefault();
            moveRole(availableRoles, assignedRoles);
        });

        removeRoleButton.addEventListener('click', (event) => {
            event.preventDefault();
            moveRole(assignedRoles, availableRoles);
        });

        addAllRolesButton.addEventListener('click', (event) => {
            event.preventDefault();
            moveAllRoles(availableRoles, assignedRoles);
        });

        removeAllRolesButton.addEventListener('click', (event) => {
            event.preventDefault();
            moveAllRoles(assignedRoles, availableRoles);
        });

        availableRoles.addEventListener('click', (e) => {
            if (e.target.tagName === 'LI') {
                clearSelection(availableRoles);
                e.target.classList.add('selected');
            }
        });

        assignedRoles.addEventListener('click', (e) => {
            if (e.target.tagName === 'LI') {
                clearSelection(assignedRoles);
                e.target.classList.add('selected');
            }
        });

        function clearSelection(list) {
            Array.from(list.children).forEach(item => item.classList.remove('selected'));
        }

        const searchAvailable = document.querySelector('#search-available');
        searchAvailable.addEventListener('input', () => {
            filterRoles(searchAvailable, availableRoles);
        });

        const searchAssigned = document.querySelector('#search-assigned');
        searchAssigned.addEventListener('input', () => {
            filterRoles(searchAssigned, assignedRoles);
        });
    });
</script>
