<div>
    <x-form-section submit="save">
        <x-slot name="title">
            {{ __('Add scan point') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Add scan point importing from a excel file.') }}
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

                <x-label for="excel" value="{{ __('Import scan point') }}" />

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoName" style="display: none;">
                    <h2 x-text="photoName" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:text-gray-800 dark:hover:text-gray-100 transition ease-in-out duration-150" >
                    </h2>
                </div>

                <x-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.excel.click()">
                    {{ __('Select A XLSX file') }}
                </x-secondary-button>

                <x-secondary-button class="mt-2 mr-2" type="button" wire:click="download()">
                    {{ __('Download import example') }}
                </x-secondary-button>

            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="mr-3" on="saved">
                {{ __('Imported.') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled" wire:target="excel">
                {{ __('Import') }}
            </x-button>
        </x-slot>
    </x-form-section>
</div>
