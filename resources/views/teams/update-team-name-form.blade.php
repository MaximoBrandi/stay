<x-form-section submit="updateTeamName">
    <x-slot name="title">
        {{ __('Course Name') }}
    </x-slot>

    <x-slot name="description">
        {{ __('The team\'s name and owner information.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Course Owner Information -->
        <div class="col-span-6 lg:col-span-4">
            <x-label for="preceptor" value="{{ __('Preceptor') }}" />
            <x-input-error for="preceptor" class="mt-2" />

            <div class="relative z-0 mt-1 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer">
                @foreach (\App\Models\User::join('privileges', 'privileges.user_id', 'users.id')->where('privileges.privilege_grade', '=', '3')->get() as $index => $user)
                    <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-600 {{ $index > 0 ? 'border-t border-gray-200 dark:border-gray-700 focus:border-none rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                    wire:click="setPreceptor('{{ $user->id }}')">
                        <div class="">
                            <!-- Role Name -->
                            <div class="flex items-center">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $user->name }}
                                </div>

                                @if (2 == $user->id)
                                    <svg class="ml-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>

                            <!-- Role Description -->
                            <div class="mt-2 text-xs text-gray-600 dark:text-gray-400 text-left">
                                {{ $user->email }}
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Course Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Course Name') }}" />

            <x-input id="name"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model.defer="state.name"
                        :disabled="! Gate::check('update', $team)" />

            <x-input-error for="name" class="mt-2" />
        </div>
    </x-slot>

    @if (Gate::check('update', $team))
        <x-slot name="actions">
            <x-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button>
                {{ __('Save') }}
            </x-button>
        </x-slot>
    @endif
</x-form-section>
