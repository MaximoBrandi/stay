<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Database') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="vendor/hystModal/hystmodal.min.css">
    <script src="vendor/hystModal/hystmodal.min.js"></script>

    <div class="py-12">
        @if (Auth::user()->privilege->privilege_grade == 4)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div id="accordionExample5">
                    @foreach (App\Models\Team::all() as $value)
                        <livewire:database.course.row :course="$value" />
                    @endforeach
                </div>
            </div>
        @else
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <livewire:database-course :course="Auth::user()->currentTeam" />
            </div>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
</x-app-layout>
