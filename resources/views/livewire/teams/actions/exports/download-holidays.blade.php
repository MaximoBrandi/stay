<div>
    <x-form-section submit="save">
        <x-slot name="title">
            {{ __('Export holidays') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Export all holidays from the database.') }}
        </x-slot>


        <x-slot name="form">
            <!-- Profile Photo -->
            <div wire:ignore class="col-span-6 sm:col-span-6">
                <x-label  value="{{ __('Export holidays database') }}" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="mr-3" on="saved">
                {{ __('Exported.') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled">
                {{ __('Export') }}
            </x-button>
        </x-slot>
    </x-form-section>
</div>
