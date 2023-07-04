<div>
    <x-form-section submit="save">
        <x-slot name="title">
            {{ __('Course Students') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Add students to this course.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Profile Photo -->
            <div x-data="{photoName: null}" class="col-span-6 sm:col-span-6">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="excel"
                            x-ref="excel"
                            x-on:change="
                                    photoName = $refs.excel.files[0].name;
                            " />

                <x-label for="excel" value="{{ __('Course students') }}" />

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoName" style="display: none;">
                    <h2 x-text="photoName" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:text-gray-800 dark:hover:text-gray-100 transition ease-in-out duration-150" >
                    </h2>
                </div>

                <x-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.excel.click()">
                    {{ __('Select A XLSX file') }}
                </x-secondary-button>

                <x-secondary-button class="mt-2 mr-2" type="button" wire:click="download()">
                    {{ __('Download XLSX file example') }}
                </x-secondary-button>

                <x-input-error for="photo" class="mt-2" />

                @if ($team !== null)
                    <x-section-border />

                    <!-- Manage Team Members -->
                    <div class="mt-10 sm:mt-0">
                        @foreach ($team as $usere)
                            <div class="flex mt-2 items-center justify-between">
                                <div class="flex items-center">
                                    <img class="w-8 h-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ $usere[0] }}">
                                    <div class="ml-4 dark:text-white">{{ $usere[0] }}</div>
                                </div>

                                <div class="flex items-center">
                                    <!-- Manage Team Member Role -->
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mr-3">
                                        {{$usere[1]}}
                                    </p>

                                    <button class="cursor-pointer ml-6 text-sm text-red-500" wire:click="confirmTeamMemberRemoval('{{ array_search($usere, $team[0]) }}')">
                                        {{ __('Remove') }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="mr-3" on="saved">
                {{ __('Students uploaded.') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled" wire:target="excel">
                {{ __('Upload students') }}
            </x-button>
        </x-slot>
    </x-form-section>
</div>
