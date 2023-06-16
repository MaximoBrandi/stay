<div class="justify-center">
    @switch($classes)
        @case(1)
            @if ($qrlink)
            <div class="mt-8 mb-8">
                {!! QrCode::size(168)->generate($qrlink) !!}
            </div>
            @endif
            <div>
                <x-nav-link wire:click="generate" href="javascript:void(0)">
                    {{ __('Generate Attendance QR') }}
                </x-nav-link>
            </div>

            @break
        @case(2)
            <x-nav-link href="javascript:void(0)">
                {{ __("Today there's no class") }}
            </x-nav-link>
            @break
        @case(3)
            <x-nav-link href="javascript:void(0)">
                {{ __("You must wait to give attendance") }}
            </x-nav-link>
            @break
        @case(4)
            <x-nav-link href="javascript:void(0)">
                {{ __("Attendance has been given already") }}
            </x-nav-link>
            @break

        @default

    @endswitch
</div>
