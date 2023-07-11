
<div class="mt-10 sm:mt-0">
    <x-action-section>
        <x-slot name="title">
            {{ __('Scan points') }}
        </x-slot>

        <x-slot name="description">
            {{ __('All the configured scan point\'s and their status.') }}
        </x-slot>

        <!-- Course Member List -->
        <x-slot name="content">
            <div class="space-y-6">
                @if (!$team->isEmpty())
                    @foreach ($team as $user)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img class="w-8 h-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                <div class="ml-4 dark:text-white">{{ $user->name }}</div>
                            </div>

                            <div class="flex items-center">
                                <!-- Remove Course Member -->
                                    <button class="cursor-pointer ml-6 text-sm text-red-500" wire:click="confirmTeamMemberRemoval('{{ $user->id }}')">
                                        {{ __('Remove') }}
                                    </button>
                            </div>
                        </div>
                    @endforeach
                @else
                There's no scan points
                @endif
            </div>
        </x-slot>
    </x-action-section>
</div>
