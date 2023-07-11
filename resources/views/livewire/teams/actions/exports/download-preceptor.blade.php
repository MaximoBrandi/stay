<div>
    <x-form-section submit="save">
        <x-slot name="title">
            {{ __('Export preceptor') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Export preceptors from the database.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Profile Photo -->
            <div wire:ignore class="col-span-6 sm:col-span-6">
                <x-label class="mb-2"  value="{{ __('Export preceptor/s') }}" />
                <!-- Profile Photo File Input -->
                <select wire:model="selectedInput" data-te-select-init multiple>
                    @foreach (\App\Models\User::whereHas('privilege', function ($query) {
                        $query->where('privilege_grade', '=', 3);
                    })->get() as $preceptor)
                        <option value="{{$preceptor->id}}">{{$preceptor->name}}</option>
                    @endforeach
                </select>
                <label data-te-select-label-ref>Select preceptor/s</label>

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
