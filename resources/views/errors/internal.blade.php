<x-app-layout>
    <x-slot name="header">
        <div class="p-3 text-center text-xl font-bold text-red-900 dark:text-gray-100">
            {{ __('500 Internal Server Error') }}
        </div>
    </x-slot>

    <div class="container mx-auto mt-12 px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold mb-4 text-orange-900">Ha ocurrido un error inesperado</h2>
            <p class="text-xl text-gray-600">Por favor vuelve a intentarlo mas tarde</p>
        </div>
        {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 cursor-pointer">
                <div class="p-6 flex flex-col items-center text-center h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-orange-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-2xl font-semibold mb-2">Ver Reportes</h3>
                    <p class="text-gray-600 mb-4">Accede a todos los reportes existentes</p>
                    <a href="{{ route('reportes-generales') }}" class="mt-auto px-4 py-2 border border-orange-900 text-orange-900 rounded hover:bg-orange-900 hover:text-white transition-colors duration-300 group">
                        Comenzar
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block ml-2 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 cursor-pointer">
                <div class="p-6 flex flex-col items-center text-center h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-orange-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-2xl font-semibold mb-2">Crear Reporte</h3>
                    <p class="text-gray-600 mb-4">Registra una nueva incidencia</p>
                    <a href="{{ route('crear-reporte') }}" class="mt-auto px-4 py-2 border border-orange-900 text-orange-900 rounded hover:bg-orange-900 hover:text-white transition-colors duration-300 group">
                        Comenzar
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block ml-2 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 cursor-pointer">
                <div class="p-6 flex flex-col items-center text-center h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-orange-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h3 class="text-2xl font-semibold mb-2">Mantenimientos</h3>
                    <p class="text-gray-600 mb-4">Configura y mantén el sistema</p>
                    <a href="{{ route('aulas.index') }}" class="mt-auto px-4 py-2 border border-orange-900 text-orange-900 rounded hover:bg-orange-900 hover:text-white transition-colors duration-300 group">
                        Comenzar
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block ml-2 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 mb-4">
            <h3 class="text-2xl font-semibold mb-4">Resumen de Actividad Reciente</h3>
            <div class="flex justify-around text-center">
                <div>
                    <p class="text-3xl font-bold text-orange-900">25</p>
                    <p class="text-sm text-gray-600">Reportes Nuevos</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-orange-900">18</p>
                    <p class="text-sm text-gray-600">En Progreso</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-orange-900">7</p>
                    <p class="text-sm text-gray-600">Resueltos Hoy</p>
                </div>
            </div>
        </div> --}}
    </div>
</x-app-layout>
