<div class="grid mt-8 gap-8 row-gap-10 grid-cols-2">
    <div class="grid mt-8 rounded dark:bg-gray-600 bg-indigo-100 p-4 gap-8 row-gap-10 grid-cols-6">
        @php
            use App\Http\Controllers\DateController;

            $dateController = new DateController($course);
        @endphp
        @if ($dashboard)
            @foreach (\App\Models\User::where('current_team_id', $course)->where('id', '>', 6)->pluck('id')->toArray() as $studentID)
                <div class="max-w-md sm:mx-auto sm:text-center hover:scale-125 transition-all" wire:click="change({{$studentID}})" style="cursor: pointer">
                    @php
                        $status = $dateController->estadoDelDia($studentID);
                    @endphp
                    <div class="flex items-center justify-center rounded-full @if ($status == 1) bg-red-400 @elseif($status == 2) bg-yellow-200 @elseif($status == 3) bg-green-600  @else bg-indigo-50 dark:bg-gray-400 @endif sm:mx-auto">
                        <svg class="text-deep-purple-accent-400 sm:w-12 sm:h-12" stroke="currentColor xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="person">
                            <g data-name="Layer 2"><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm6 10a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z" data-name="person"></path></g>
                        </svg>
                    </div>
                </div>
            @endforeach
        @else
            @foreach (\App\Models\User::where('current_team_id', $course)->where('id', '>', 6)->pluck('id')->toArray() as $studentID)
                @php
                    $status = $dateController->Ausentes($studentID);
                @endphp
                <div class="max-w-md sm:mx-auto sm:text-center hover:scale-125 transition-all" wire:click="change({{$studentID}})" style="cursor: pointer">
                    <div class="flex items-center justify-center rounded-full @if ($status >= 30) bg-red-600 @elseif($status >= 20) bg-red-400 @elseif($status >= 15) bg-yellow-200 @else bg-indigo-50 dark:bg-gray-400 @endif  sm:mx-auto">
                        @if ($status >= 30)
                            <svg class="text-deep-purple-accent-400 scale-50 sm:w-16 sm:h-16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="exclamation-mark">
                                <path d="M12,16a1,1,0,1,0,1,1A1,1,0,0,0,12,16Zm10.67,1.47-8.05-14a3,3,0,0,0-5.24,0l-8,14A3,3,0,0,0,3.94,22H20.06a3,3,0,0,0,2.61-4.53Zm-1.73,2a1,1,0,0,1-.88.51H3.94a1,1,0,0,1-.88-.51,1,1,0,0,1,0-1l8-14a1,1,0,0,1,1.78,0l8.05,14A1,1,0,0,1,20.94,19.49ZM12,8a1,1,0,0,0-1,1v4a1,1,0,0,0,2,0V9A1,1,0,0,0,12,8Z"></path>
                            </svg>
                        @else
                            <svg class="text-deep-purple-accent-400 sm:w-12 sm:h-12" stroke="currentColor xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="person">
                                <g data-name="Layer 2"><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm6 10a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z" data-name="person"></path></g>
                            </svg>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    @if (isset($alumnoID))
        <div class="mb-4 mt-4 max-w-xl md:mx-auto sm:text-center lg:max-w-2xl">

            <h2 class="max-w-lg mt-10 font-sans text-3xl font-bold leading-none tracking-tight dark:text-gray-200 text-gray-900 sm:text-4xl md:mx-auto">
            <span class="relative inline-block">
                <span class="relative">{{\App\Models\User::find($alumnoID)->name}}</span>
            </span>
            </h2>
            <h2 class="max-w-lg font-sans text-2xl mt-4 font-bold leading-none tracking-tight dark:text-gray-400 text-gray-600 sm:text-3xl md:mx-auto">
                <span class="relative inline-block">
                <span class="relative">Attendances: {{$presentes}}</span>
                </span>
            </h2>
            <div id="accordion-collapse" data-accordion="collapse">
                <h2 id="accordion-collapse-heading-{{$alumnoID+50}}">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-{{$alumnoID+50}}" aria-expanded="false" aria-controls="accordion-collapse-body-{{$alumnoID+50}}">
                        <span class="text-1xl sm:text-2xl">Present: {{$presentes}}</span>
                        <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-{{$alumnoID+50}}" class="hidden" aria-labelledby="accordion-collapse-heading-{{$alumnoID+50}}">
                    <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                        <span class="relative inline-block">
                        <span class="relative">Late: {{$tardes}}</span>
                        </span>
                    </h2>
                </div>
            </div>
            <div id="accordion-collapse" class="max-w-lg" data-accordion="collapse">
                <h2 id="accordion-collapse-heading-{{$alumnoID+100}}">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-{{$alumnoID+100}}" aria-expanded="true" aria-controls="accordion-collapse-body-{{$alumnoID+100}}">
                        <span class="text-1xl sm:text-2xl">Absent: {{$ausentes}}</span>
                        <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-{{$alumnoID+100}}" aria-labelledby="accordion-collapse-heading-{{$alumnoID+100}}">
                    <div>
                        <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                            <span class="relative inline-block">
                            <span class="relative">Present absent: {{$presenteAusente}}</span>
                            </span>
                        </h2>
                        <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                            <span class="relative inline-block">
                            <span class="relative">Retirements: {{$retiradas}}</span>
                            </span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>


