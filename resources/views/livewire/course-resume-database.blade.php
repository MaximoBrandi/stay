<div class="grid mt-8 gap-8 row-gap-10 grid-cols-2">
    <div class="grid mt-8 rounded dark:bg-gray-600 bg-indigo-100 p-4 gap-8 row-gap-10 grid-cols-6">
        @php
            use App\Http\Controllers\DateController;

            $dateController = new DateController($course);
        @endphp
        @if ($dashboard)
            @foreach (\App\Models\User::where('current_team_id', $course)->where('id', '>', 6)->get('id')->map(function($i) {return array_values($i->only('id'));})->toArray() as $studentID)
                <div class="max-w-md sm:mx-auto sm:text-center hover:scale-125 transition-all" wire:click="change({{$studentID[0]}})" style="cursor: pointer">
                    @php
                        $status = $dateController->estadoDelDia($studentID[0]);
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
                <span class="relative">Present: {{$presentes}}</span>
                </span>
            </h2>
            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                <span class="relative inline-block">
                <span class="relative">Late: {{$tardes}}</span>
                </span>
            </h2>
            <h2 class="max-w-lg font-sans text-2xl mt-4 font-bold leading-none tracking-tight dark:text-gray-400 text-gray-600 sm:text-3xl md:mx-auto">
                <span class="relative inline-block">
                <span class="relative">Absent: {{$ausentes}}</span>
                </span>
            </h2>
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
    @endif
</div>
