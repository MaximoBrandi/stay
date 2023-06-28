<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Database') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="vendor/hystModal/hystmodal.min.css">
    <script src="vendor/hystModal/hystmodal.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>


    <div class="py-12">
        @if (Auth::user()->privilege->privilege_grade == 4)
            @foreach (App\Models\Team::all() as $value)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div id="accordion-collapse" data-accordion="collapse">
                    <h2 id="accordion-collapse-heading-{{$value->id}}">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-{{$value->id}}" aria-expanded="false" aria-controls="accordion-collapse-body-{{$value->id}}">
                        <span>{{ $value->name }}</span>
                        <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    </h2>
                    <div id="accordion-collapse-body-{{$value->id}}" class="hidden" aria-labelledby="accordion-collapse-heading-{{$value->id}}">
                        <livewire:database.course-database :course=" $value " />
                    </div>
                </div>
            </div>
            @endforeach
        @else
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:database.course-database :course=" Auth::user()->currentTeam()->get()[0] " />
        </div>
        @endif
    </div>
</x-app-layout>
