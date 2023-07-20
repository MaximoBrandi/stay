<div>
    <x-form-section submit="save">
        <x-slot name="title">
            {{ __('Student\'s report') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Generate students reports from the database.') }}
        </x-slot>

        <x-slot name="form">

            <div class="col-span-6 sm:col-span-6">
                <div>
                    <x-label class="mb-2" value="{{ __('Students') }}" />
                    <!-- Profile Photo File Input -->
                    <select data-te-select-init data-te-select-filter="true" multiple>
                        @foreach (\App\Models\Team::all() as $team)
                            <optgroup label="{{$team->name}}">
                                @foreach (\App\Models\User::where('current_team_id', '=', $team->id)->whereHas('privilege', function ($query) {
                                    $query->where('privilege_grade', '=', 1);
                                })->get() as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <label data-te-select-label-ref>Select course</label>
                </div>
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
