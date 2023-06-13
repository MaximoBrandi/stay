<div class="grid mt-8 gap-8 row-gap-10 grid-cols-2">
    <div class="grid mt-8 rounded dark:bg-gray-600 bg-indigo-100 p-4 gap-8 row-gap-10 grid-cols-6">
        @foreach (App\Models\User::where('current_team_id', $course)->where('id', '>', 3)->get('id')->map(function($i) {return array_values($i->only('id'));})->toArray() as $studentID)
            <div class="max-w-md sm:mx-auto sm:text-center hover:scale-125 transition-all" wire:click="change({{$studentID[0]}})" style="cursor: pointer">
                <div class="flex items-center justify-center rounded-full @if ( (new App\Http\Controllers\DateController)->Ausentes($studentID) > 30) bg-red-800 @elseif((new App\Http\Controllers\DateController)->Ausentes($studentID) > 25) bg-red-400 @elseif((new App\Http\Controllers\DateController)->Ausentes($studentID) > 15) bg-yellow-200 @else bg-indigo-50 dark:bg-gray-400 @endif  sm:mx-auto">
                    <svg class="text-deep-purple-accent-400 sm:w-12 sm:h-12" stroke="currentColor xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="person">
                        <g data-name="Layer 2"><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm6 10a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z" data-name="person"></path></g>
                    </svg>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mb-4 mt-4 max-w-xl md:mx-auto sm:text-center lg:max-w-2xl">
        <h2 class="max-w-lg mt-10 font-sans text-3xl font-bold leading-none tracking-tight dark:text-gray-200 text-gray-900 sm:text-4xl md:mx-auto">
          <span class="relative inline-block">
            <span class="relative">Student {{$alumnoID - 3}}</span>
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
</div>
