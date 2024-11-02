<div x-data="{ isCreateModalOpen: false, isModalOpen: false, changeSatusModal: false, asignaModal: false }"  class="w-full m-auto mb-4">
    <div class="relative flex flex-col w-5/6 h-full  text-gray-700 bg-white shadow-md rounded-xl bg-clip-border m-auto">
        <div class=" flex justify-center rounded bg-slate-200 text-center mt-2 mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-3xl lg:text-6xl dark:text-white">
            <h3 class="mr-3">Listado de Incidencias</h3>

            <button class="mt-2 bg-black text-white relative h-10 max-h-[40px] w-100 max-w-[150px] py-3 px-3 select-none rounded-lg text-center align-middle  text-xs  uppercase transition-all hover:bg-green-700"
            @click="isCreateModalOpen = true; @this.createNewIncidencia()">Nueva Incidencia</button>

        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-s text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Título</th>
                    <th scope="col" class="px-6 py-3">Descripción</th>
                    <th scope="col" class="px-6 py-3">Estado</th>
                    <th scope="col" class="px-6 py-3">Asignado a</th>
                    <th scope="col" class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($incidencias as $incidencia)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="p-4 border-b border-blue-gray-50">{{ $incidencia->title }}</td>
                        <td class="p-4 border-b border-blue-gray-50">{{ $incidencia->descripcion }}</td>
                        <td class="p-4 border-b border-blue-gray-50"><button class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                            @click="changeSatusModal = true; @this.cambioEstado({{ $incidencia->id }})">{{ $incidencia->estado }}</button></td>
                        <td class="p-4 border-b border-blue-gray-50">
                            @if (Auth::user()->role === 'administrador')
                                <button class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                @click="asignaModal = true; @this.asignarIncidencia({{ $incidencia->id }})">{{ $incidencia->asignado_a->name ?? 'No asignado' }}</button>
                            @else
                                {{ $incidencia->asignado_a->name ?? 'No asignado' }}
                            @endif

                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <button class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            @click="isModalOpen = true; @this.edit({{ $incidencia->id }})">
                                <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                                      class="w-4 h-4">
                                      <path
                                        d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z">
                                      </path>
                                    </svg>
                                  </span>
                            </button>
                            <button class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button"  wire:click="delete({{ $incidencia->id }})">
                                <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                      </svg>

                                  </span>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div x-show="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-lg max-w-md mx-auto">
            <h2 class="text-xl font-semibold mb-4">Editar Incidencia</h2>
            @if (Auth::user()->role === 'soporte')
                <input type="text" wire:model="title" class="w-full px-4 py-2 border rounded mb-4"  readonly />
                <textarea wire:model="descripcion" class="w-full px-4 py-2 border rounded mb-4"  readonly></textarea>
            @elseif (Auth::user()->role === 'administrador')
                <input type="text" wire:model="title" class="w-full px-4 py-2 border rounded mb-4"  />
                <textarea wire:model="descripcion" class="w-full px-4 py-2 border rounded mb-4" ></textarea>
            @else
                <input type="text" wire:model="title" class="w-full px-4 py-2 border rounded mb-4" />
                <textarea wire:model="descripcion" class="w-full px-4 py-2 border rounded mb-4"></textarea>
            @endif

            <select wire:model="estado" class="w-full px-4 py-2 border rounded mb-4">
                <option value="To Do">To Do</option>
                <option value="Doing">Doing</option>
                <option value="Done">Done</option>
            </select>
            @if (Auth::user()->role === 'administrador')
                <select wire:model="asignado" class="w-full px-4 py-2 border rounded mb-4">
                    <option value="">Seleccione un usuario</option>
                    @foreach(\App\Models\User::all() as $user)
                        @if($user->role === "soporte")
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endif
                    @endforeach
                </select>
            @endif
            <div class="flex justify-end">
                <button @click="isModalOpen = false" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded mr-2">Cancelar</button>
                <button wire:click="update" @click="isModalOpen = false" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">Guardar</button>
            </div>
        </div>
    </div>

    <div x-show="isCreateModalOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-lg max-w-md mx-auto">
            <h2 class="text-xl font-semibold mb-4">Nueva Incidencia</h2>
            <input type="text" wire:model="title" class="w-full px-4 py-2 border rounded mb-4" placeholder="Title" />
            <textarea wire:model="descripcion" class="w-full px-4 py-2 border rounded mb-4" placeholder="Descripción"></textarea>
            <select wire:model="estado" class="w-full px-4 py-2 border rounded mb-4">
                <option value="To Do">To Do</option>
                <option value="Doing">Doing</option>
                <option value="Done">Done</option>
            </select>
            @if (Auth::user()->role === 'administrador')
                <select wire:model="asignado" class="w-full px-4 py-2 border rounded mb-4">
                    <option value="">Seleccione un usuario</option>
                    @foreach(\App\Models\User::all() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            @endif
            <div class="flex justify-end">
                <button @click="isCreateModalOpen = false" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded mr-2">Cancelar</button>
                <button wire:click="store" @click="isCreateModalOpen = false" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">Crear</button>
            </div>
        </div>
    </div>

    <div x-show="changeSatusModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-lg max-w-md mx-auto">
            <h2 class="text-xl font-semibold mb-4">Cambiar estado</h2>
            <select wire:model="estado" class="w-full px-4 py-2 border rounded mb-4">
                <option value="To Do">To Do</option>
                <option value="Doing">Doing</option>
                <option value="Done">Done</option>
            </select>
            <div class="flex justify-end">
                <button @click="changeSatusModal = false" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded mr-2">Cancelar</button>
                <button wire:click="actualizaEstado" @click="changeSatusModal = false" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">Guardar</button>
            </div>
        </div>
    </div>

    <div x-show="asignaModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-lg max-w-md mx-auto">
            <h2 class="text-xl font-semibold mb-4">Asigna a Soporte</h2>
            @if (Auth::user()->role === 'administrador')
                <select wire:model="asignado" class="w-full px-4 py-2 border rounded mb-4">
                    @foreach(\App\Models\User::all() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            @endif
            <div class="flex justify-end">
                <button @click="asignaModal = false" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded mr-2">Cancelar</button>
                <button wire:click="asignarSoporte" @click="asignaModal = false" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">Guardar</button>
            </div>
        </div>
    </div>


</div>
