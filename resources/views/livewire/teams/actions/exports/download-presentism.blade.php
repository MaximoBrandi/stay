<div>
    <x-form-section submit="save">
        <x-slot name="title">
            {{ __('Export presentism') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Export presentism of a course from the database.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Profile Photo -->
            <div wire:ignore class="col-span-6 sm:col-span-6">
                <x-label class="mb-2"  value="{{ __('Export presentism database') }}" />
                <!-- Profile Photo File Input -->
                <select wire:model="selectedInput" data-te-select-init multiple>
                    @foreach (\App\Models\Team::all() as $team)
                        <option value="{{$team->id}}">{{$team->name}}</option>
                    @endforeach
                </select>
                <label data-te-select-label-ref>Select course</label>

            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="mr-3" on="saved">
                {{ __('Exported.') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled" wire:target="excel">
                {{ __('Export') }}
            </x-button>
        </x-slot>
    </x-form-section>
</div>
