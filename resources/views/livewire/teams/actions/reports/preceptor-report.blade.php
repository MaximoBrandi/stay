<div>
    <x-form-section submit="save">
        <x-slot name="title">
            {{ __('Preceptor\'s report') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Generate preceptors reports from the database.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-6">
                <x-label class="mb-2"  value="{{ __('Export course database') }}" />
                <!-- Profile Photo File Input -->
                <select data-te-select-init multiple>
                    @foreach (\App\Models\User::whereHas('privilege', function ($query) {
                        $query->where('privilege_grade', '=', 3);
                    })->get() as $preceptor)
                        <option value="{{$preceptor->id}}">{{$preceptor->name}}</option>
                    @endforeach
                </select>
                  <label data-te-select-label-ref>Select Preceptor/s</label>

                <x-input-error for="photo" class="mt-2" />

            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="mr-3" on="saved">
                {{ __('Generated.') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled" wire:target="excel">
                {{ __('Generate') }}
            </x-button>
        </x-slot>
    </x-form-section>
</div>
