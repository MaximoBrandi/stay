<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (Auth::user()->privilege->privilege_grade == 1)
                <div class="bg-white dark:bg-gray-800 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex mt-8 mb-8 justify-center">
                        <livewire:attendance-qr />
                    </div>
                </div>
            @endif
            @if (Auth::user()->privilege->privilege_grade == 3)
                <div class="bg-white dark:bg-gray-800 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <livewire:attendances />
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <livewire:courses />
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
