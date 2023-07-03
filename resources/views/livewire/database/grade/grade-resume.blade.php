<div>
    <div class="grid mt-8 gap-8 row-gap-10 grid-cols-2">
        <div class="grid mt-8 rounded dark:bg-gray-600 bg-indigo-100 p-4 gap-8 row-gap-10 grid-cols-6">
            {{-- @php
                use App\Http\Controllers\DateController;

                $dateController = new DateController($course);
            @endphp --}}
            {{-- @if ($dashboard) --}}
                @foreach (\App\Models\Team::where('grade_id', '=', $grade->id)->pluck('id')->toArray() as $courseID)
                    <div class="max-w-md sm:mx-auto sm:text-center hover:scale-125 transition-all" style="cursor: pointer">
                        {{-- @php
                            $status = $dateController->estadoDelDia($courseID);
                        @endphp --}}
                        <div class="flex items-center justify-center rounded-full bg-indigo-50 dark:bg-gray-400 sm:mx-auto">
                            <svg class="text-deep-purple-accent-400 sm:w-12 sm:h-12" stroke="currentColor xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="person">
                                <g data-name="Layer 2"><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm6 10a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z" data-name="person"></path></g>
                            </svg>
                        </div>
                    </div>
                @endforeach
            {{-- @else --}}
                {{-- @foreach (\App\Models\Team::where('grade_id', '=', $grade->id)->pluck('id')->toArray() as $courseID)
                    <div class="max-w-md sm:mx-auto sm:text-center hover:scale-125 transition-all" style="cursor: pointer">
                        <div class="flex items-center justify-center rounded-full bg-indigo-50 dark:bg-gray-400 sm:mx-auto">
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
                @endforeach --}}
            {{-- @endif --}}
        </div>
        @if (isset($courseID))
            <div class="mb-4 mt-4 max-w-xl md:mx-auto sm:text-center lg:max-w-2xl">

                <h2 class="max-w-lg mt-10 font-sans text-3xl font-bold leading-none tracking-tight dark:text-gray-200 text-gray-900 sm:text-4xl md:mx-auto">
                <span class="relative inline-block">
                    <span class="relative">{{\App\Models\Team::find($courseID)->name}}</span>
                </span>
                </h2>
                <h2 class="max-w-lg font-sans text-2xl mt-4 font-bold leading-none tracking-tight dark:text-gray-400 text-gray-600 sm:text-3xl md:mx-auto">
                    <span class="relative inline-block">
                    <span class="relative">Attendances: 2</span>
                    </span>
                </h2>
                <div id="accordionExample{{$courseID}}">
                    <div>
                        <h2 class="mb-0" id="headingOne{{$courseID}}">
                            <button class="group relative flex w-full items-center rounded-t-[15px] border-0 bg-white px-5 py-4 text-left text-base text-neutral-800 transition [overflow-anchor:none] hover:z-[2] focus:z-[3] focus:outline-none dark:bg-neutral-800 dark:text-white [&:not([data-te-collapse-collapsed])]:bg-white [&:not([data-te-collapse-collapsed])]:text-primary [&:not([data-te-collapse-collapsed])]:[box-shadow:inset_0_-1px_0_rgba(229,231,235)] dark:[&:not([data-te-collapse-collapsed])]:bg-neutral-800 dark:[&:not([data-te-collapse-collapsed])]:text-primary-400 dark:[&:not([data-te-collapse-collapsed])]:[box-shadow:inset_0_-1px_0_rgba(75,85,99)]" type="button" data-te-collapse-init data-te-target="#collapseOne{{$courseID}}" aria-expanded="true" aria-controls="collapseOne{{$courseID}}">
                            <span class="text-1xl sm:text-2xl">Present: 2</span>
                            <span class="-mr-1 ml-auto h-5 w-5 shrink-0 rotate-[-180deg] fill-[#336dec] transition-transform duration-200 ease-in-out group-[[data-te-collapse-collapsed]]:mr-0 group-[[data-te-collapse-collapsed]]:rotate-0 group-[[data-te-collapse-collapsed]]:fill-[#212529] motion-reduce:transition-none dark:fill-blue-300 dark:group-[[data-te-collapse-collapsed]]:fill-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /> </svg>
                            </span>
                            </button>
                        </h2>
                        <div id="collapseOne{{$courseID}}" class="!visible" data-te-collapse-item data-te-collapse-show aria-labelledby="headingOne{{$courseID}}">
                            <div class="px-5 py-4">
                                <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                    <span class="relative inline-block">
                                    <span class="relative">Late: 2</span>
                                    </span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h2 class="mb-0" id="headingTwo{{$courseID}}">
                            <button class="group relative flex w-full items-center rounded-none border-0 bg-white px-5 py-4 text-left text-base text-neutral-800 transition [overflow-anchor:none] hover:z-[2] focus:z-[3] focus:outline-none dark:bg-neutral-800 dark:text-white [&:not([data-te-collapse-collapsed])]:bg-white [&:not([data-te-collapse-collapsed])]:text-primary [&:not([data-te-collapse-collapsed])]:[box-shadow:inset_0_-1px_0_rgba(229,231,235)] dark:[&:not([data-te-collapse-collapsed])]:bg-neutral-800 dark:[&:not([data-te-collapse-collapsed])]:text-primary-400 dark:[&:not([data-te-collapse-collapsed])]:[box-shadow:inset_0_-1px_0_rgba(75,85,99)]" type="button" data-te-collapse-init data-te-collapse-collapsed data-te-target="#collapseTwo{{$courseID}}" aria-expanded="false" aria-controls="collapseTwo{{$courseID}}">
                                <span class="text-1xl sm:text-2xl">Absent: 2</span>
                            <span class="-mr-1 ml-auto h-5 w-5 shrink-0 rotate-[-180deg] fill-[#336dec] transition-transform duration-200 ease-in-out group-[[data-te-collapse-collapsed]]:mr-0 group-[[data-te-collapse-collapsed]]:rotate-0 group-[[data-te-collapse-collapsed]]:fill-[#212529] motion-reduce:transition-none dark:fill-blue-300 dark:group-[[data-te-collapse-collapsed]]:fill-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /> </svg>
                            </span>
                            </button>
                        </h2>
                        <div id="collapseTwo{{$courseID}}" class="!visible hidden" data-te-collapse-item aria-labelledby="headingTwo{{$courseID}}">
                            <div class="px-5 py-4">
                                <div>
                                    <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                        <span class="relative inline-block">
                                        <span class="relative">Present absent: 2</span>
                                        </span>
                                    </h2>
                                    <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                        <span class="relative inline-block">
                                        <span class="relative">Retirements: 2</span>
                                        </span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="hidden" id="accordionExample1">
            <div>
                <h2 class="mb-0" id="headingOne1">
                    <button class="group relative flex w-full items-center rounded-t-[15px] border-0 bg-white px-5 py-4 text-left text-base text-neutral-800 transition [overflow-anchor:none] hover:z-[2] focus:z-[3] focus:outline-none dark:bg-neutral-800 dark:text-white [&:not([data-te-collapse-collapsed])]:bg-white [&:not([data-te-collapse-collapsed])]:text-primary [&:not([data-te-collapse-collapsed])]:[box-shadow:inset_0_-1px_0_rgba(229,231,235)] dark:[&:not([data-te-collapse-collapsed])]:bg-neutral-800 dark:[&:not([data-te-collapse-collapsed])]:text-primary-400 dark:[&:not([data-te-collapse-collapsed])]:[box-shadow:inset_0_-1px_0_rgba(75,85,99)]" type="button" data-te-collapse-init data-te-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                    <span class="text-1xl sm:text-2xl">Present: s</span>
                    <span class="-mr-1 ml-auto h-5 w-5 shrink-0 rotate-[-180deg] fill-[#336dec] transition-transform duration-200 ease-in-out group-[[data-te-collapse-collapsed]]:mr-0 group-[[data-te-collapse-collapsed]]:rotate-0 group-[[data-te-collapse-collapsed]]:fill-[#212529] motion-reduce:transition-none dark:fill-blue-300 dark:group-[[data-te-collapse-collapsed]]:fill-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /> </svg>
                    </span>
                    </button>
                </h2>
                <div id="collapseOne5" class="!visible" data-te-collapse-item data-te-collapse-show aria-labelledby="headingOne5">
                    <div class="px-5 py-4">
                        <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                            <span class="relative inline-block">
                            <span class="relative">Late: s</span>
                            </span>
                        </h2>
                    </div>
                </div>
            </div>
            <div>
                <h2 class="mb-0" id="headingTwo1">
                    <button class="group relative flex w-full items-center rounded-none border-0 bg-white px-5 py-4 text-left text-base text-neutral-800 transition [overflow-anchor:none] hover:z-[2] focus:z-[3] focus:outline-none dark:bg-neutral-800 dark:text-white [&:not([data-te-collapse-collapsed])]:bg-white [&:not([data-te-collapse-collapsed])]:text-primary [&:not([data-te-collapse-collapsed])]:[box-shadow:inset_0_-1px_0_rgba(229,231,235)] dark:[&:not([data-te-collapse-collapsed])]:bg-neutral-800 dark:[&:not([data-te-collapse-collapsed])]:text-primary-400 dark:[&:not([data-te-collapse-collapsed])]:[box-shadow:inset_0_-1px_0_rgba(75,85,99)]" type="button" data-te-collapse-init data-te-collapse-collapsed data-te-target="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
                        <span class="text-1xl sm:text-2xl">Absent:s</span>
                    <span class="-mr-1 ml-auto h-5 w-5 shrink-0 rotate-[-180deg] fill-[#336dec] transition-transform duration-200 ease-in-out group-[[data-te-collapse-collapsed]]:mr-0 group-[[data-te-collapse-collapsed]]:rotate-0 group-[[data-te-collapse-collapsed]]:fill-[#212529] motion-reduce:transition-none dark:fill-blue-300 dark:group-[[data-te-collapse-collapsed]]:fill-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /> </svg>
                    </span>
                    </button>
                </h2>
                <div id="collapseTwo5" class="!visible hidden" data-te-collapse-item aria-labelledby="headingTwo5">
                    <div class="px-5 py-4">
                        <div>
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                <span class="relative inline-block">
                                <span class="relative">Present absent:s</span>
                                </span>
                            </h2>
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                <span class="relative inline-block">
                                <span class="relative">Retirements: s</span>
                                </span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2" id="accordionExampleAdvanced{{$grade->id}}">
        <div>
            <h2 class="mb-0" id="headingOneAdvanced{{$grade->id}}">
                <button class="group relative flex w-full items-center rounded-t-[15px] rounded-b-[15px] border-0 bg-white px-5 py-4 text-left text-base text-neutral-800 transition [overflow-anchor:none] hover:z-[2] focus:z-[3] focus:outline-none dark:bg-neutral-800 dark:text-white [&:not([data-te-collapse-collapsed])]:bg-white [&:not([data-te-collapse-collapsed])]:text-primary [&:not([data-te-collapse-collapsed])]:[box-shadow:inset_0_-1px_0_rgba(229,231,235)] dark:[&:not([data-te-collapse-collapsed])]:bg-neutral-800 dark:[&:not([data-te-collapse-collapsed])]:text-primary-400 dark:[&:not([data-te-collapse-collapsed])]:[box-shadow:inset_0_-1px_0_rgba(75,85,99)]" type="button" data-te-collapse-init data-te-target="#collapseOneAdvanced{{$grade->id}}" aria-expanded="false" aria-controls="collapseOneAdvanced{{$grade->id}}">
                <span class="text-1xl sm:text-2xl">Advanced stadistics</span>
                <span class="-mr-1 ml-auto h-5 w-5 shrink-0 rotate-[-180deg] fill-[#336dec] transition-transform duration-200 ease-in-out group-[[data-te-collapse-collapsed]]:mr-0 group-[[data-te-collapse-collapsed]]:rotate-0 group-[[data-te-collapse-collapsed]]:fill-[#212529] motion-reduce:transition-none dark:fill-blue-300 dark:group-[[data-te-collapse-collapsed]]:fill-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /> </svg>
                </span>
                </button>
            </h2>
            <div id="collapseOneAdvanced{{$grade->id}}" class="!visible hidden" data-te-collapse-item data-te-collapse-show aria-labelledby="headingOneAdvanced{{$grade->id}}">
                <div class="bg-white p-4 text-center">

                    <div class="grid justify-center mt-4 gap-8 row-gap-10 grid-cols-2">
                        <div class="mx-auto w-3/5 overflow-hidden">
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                Absents by day week
                            </h2>
                            <canvas
                              data-te-chart="line"
                              data-te-dataset-label="Traffic"
                              data-te-labels="['Monday', 'Tuesday' , 'Wednesday' , 'Thursday' , 'Friday' , 'Saturday' , 'Sunday ']"
                              data-te-dataset-data="[2112, 2343, 2545, 3423, 2365, 1985, 987]">
                            </canvas>
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                95% close to the average distribution
                            </h2>
                        </div>
                        <div class="mx-auto w-3/5 overflow-hidden">
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                Late-PresentAbsent time by day week
                            </h2>
                            <canvas
                                data-te-chart="bar"
                                data-te-dataset-label="Traffic"
                                data-te-labels="['Monday', 'Tuesday' , 'Wednesday' , 'Thursday' , 'Friday' , 'Saturday' , 'Sunday ']"
                                data-te-dataset-data="[2112, 2343, 2545, 3423, 2365, 1985, 987]">
                            </canvas>
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                95% close to the average distribution
                            </h2>
                        </div>
                        <div class="mx-auto w-3/5 overflow-hidden">
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                Retirements by day week
                            </h2>
                            <canvas
                              data-te-chart="line"
                              data-te-dataset-label="Traffic"
                              data-te-labels="['Monday', 'Tuesday' , 'Wednesday' , 'Thursday' , 'Friday' , 'Saturday' , 'Sunday ']"
                              data-te-dataset-data="[2112, 2343, 2545, 3423, 2365, 1985, 987]">
                            </canvas>
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                95% close to the average distribution
                            </h2>
                        </div>
                        <div class="mx-auto w-3/5 overflow-hidden">
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                Absents by month
                            </h2>
                            <canvas
                              data-te-chart="line"
                              data-te-dataset-label="Traffic"
                              data-te-labels="['January', 'February' , 'March' , 'April' , 'May' , 'June' , 'July ', 'August' , 'September' , 'October ', 'November' , 'December' ]"
                              data-te-dataset-data="[2112, 2343, 2545, 3423, 2365, 1985, 0, 0, 0, 0, 0, 0]">
                            </canvas>
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                95% close to the average distribution
                            </h2>
                        </div>
                        <div class="mx-auto w-3/5 overflow-hidden">
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                Retirements by month
                            </h2>
                            <canvas
                              data-te-chart="line"
                              data-te-dataset-label="Traffic"
                              data-te-labels="['January', 'February' , 'March' , 'April' , 'May' , 'June' , 'July ', 'August' , 'September' , 'October ', 'November' , 'December' ]"
                              data-te-dataset-data="[2112, 2343, 2545, 3423, 2365, 1985, 0, 0, 0, 0, 0, 0]">
                            </canvas>
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                95% close to the average distribution
                            </h2>
                        </div>
                        <div class="mx-auto w-3/5 overflow-hidden">
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                Late-PresentAbsent time by month
                            </h2>
                            <canvas
                                data-te-chart="bar"
                                data-te-dataset-label="Traffic"
                                data-te-labels="['January', 'February' , 'March' , 'April' , 'May' , 'June' , 'July ', 'August' , 'September' , 'October ', 'November' , 'December' ]"
                                data-te-dataset-data="[2112, 2343, 2545, 3423, 2365, 1985, 0, 0, 0, 0, 0, 0]">
                            </canvas>
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                95% close to the average distribution
                            </h2>
                        </div>
                        <div class="mx-auto w-3/5 overflow-hidden">
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                Absent type distribution
                            </h2>
                            <canvas
                              data-te-chart="doughnut"
                              data-te-dataset-label="Absent type distribution"
                              data-te-labels="['Non Justified', 'Justified' , 'Absent present', 'Retired']"
                              data-te-dataset-data="[2112, 2343, 2545, 980]"
                              data-te-dataset-background-color="['rgba(63, 81, 181, 0.5)', 'rgba(77, 182, 172, 0.5)', 'rgba(66, 133, 244, 0.5)', 'rgba(20, 90, 190, 0.5)']">
                            </canvas>
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                95% close to the average distribution
                            </h2>
                        </div>
                        <div class="mx-auto w-3/5 overflow-hidden">
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                Attendance time distribution
                            </h2>
                            <canvas
                              data-te-chart="doughnut"
                              data-te-dataset-label="Attendance time distribution"
                              data-te-labels="['In time', 'Late' , 'Absent present' ]"
                              data-te-dataset-data="[2112, 2343, 2545]"
                              data-te-dataset-background-color="['rgba(63, 81, 181, 0.5)', 'rgba(77, 182, 172, 0.5)', 'rgba(66, 133, 244, 0.5)']">
                            </canvas>
                            <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                                89% close to the average distribution
                            </h2>
                        </div>
                    </div>

                    <div class="mx-auto w-3/5 mt-4 mb-4 overflow-hidden">
                        <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                            Absents by student
                        </h2>
                        <canvas
                          data-te-chart="bar"
                          data-te-dataset-label="Students"
                          data-te-labels="['Student 1', 'Student 2' , 'Student 3' , 'Student 4' , 'Student 5' , 'Student 6' , 'Student 7','Student 8', 'Student 9' , 'Student 10' , 'Student 11' , 'Student 12' , 'Student 13' , 'Student 14','Student 15', 'Student 16' , 'Student 17' , 'Student 18' , 'Student 19' , 'Student 20' , 'Student 21', 'Student 22' , 'Student 23' , 'Student 24']"
                          data-te-dataset-data="[2112, 2343, 2545, 3423, 2365, 1985, 987,2112, 2343, 2545, 3423, 2365, 1985, 987,2112, 2343, 2545, 3423, 2365, 1985, 987,2112, 2343, 2545]">
                        </canvas>
                        <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                            89% close to the average distribution
                        </h2>
                    </div>

                    <div class="mx-auto w-3/5 mt-4 mb-4 overflow-hidden">
                        <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                            Late by student
                        </h2>
                        <canvas
                          data-te-chart="bar"
                          data-te-dataset-label="Students"
                          data-te-labels="['Student 1', 'Student 2' , 'Student 3' , 'Student 4' , 'Student 5' , 'Student 6' , 'Student 7','Student 8', 'Student 9' , 'Student 10' , 'Student 11' , 'Student 12' , 'Student 13' , 'Student 14','Student 15', 'Student 16' , 'Student 17' , 'Student 18' , 'Student 19' , 'Student 20' , 'Student 21', 'Student 22' , 'Student 23' , 'Student 24']"
                          data-te-dataset-data="[2112, 2343, 2545, 3423, 2365, 1985, 987,2112, 2343, 2545, 3423, 2365, 1985, 987,2112, 2343, 2545, 3423, 2365, 1985, 987,2112, 2343, 2545]">
                        </canvas>
                        <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                            89% close to the average distribution
                        </h2>
                    </div>

                    <div class="mx-auto w-3/5 mt-4 mb-4 overflow-hidden">
                        <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                            Absent Present by student
                        </h2>
                        <canvas
                          data-te-chart="bar"
                          data-te-dataset-label="Students"
                          data-te-labels="['Student 1', 'Student 2' , 'Student 3' , 'Student 4' , 'Student 5' , 'Student 6' , 'Student 7','Student 8', 'Student 9' , 'Student 10' , 'Student 11' , 'Student 12' , 'Student 13' , 'Student 14','Student 15', 'Student 16' , 'Student 17' , 'Student 18' , 'Student 19' , 'Student 20' , 'Student 21', 'Student 22' , 'Student 23' , 'Student 24']"
                          data-te-dataset-data="[2112, 2343, 2545, 3423, 2365, 1985, 987,2112, 2343, 2545, 3423, 2365, 1985, 987,2112, 2343, 2545, 3423, 2365, 1985, 987,2112, 2343, 2545]">
                        </canvas>
                        <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                            89% close to the average distribution
                        </h2>
                    </div>

                    <div class="mx-auto w-3/5 mt-4 mb-4 overflow-hidden">
                        <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                            Retirements by student
                        </h2>
                        <canvas
                          data-te-chart="bar"
                          data-te-dataset-label="Students"
                          data-te-labels="['Student 1', 'Student 2' , 'Student 3' , 'Student 4' , 'Student 5' , 'Student 6' , 'Student 7','Student 8', 'Student 9' , 'Student 10' , 'Student 11' , 'Student 12' , 'Student 13' , 'Student 14','Student 15', 'Student 16' , 'Student 17' , 'Student 18' , 'Student 19' , 'Student 20' , 'Student 21', 'Student 22' , 'Student 23' , 'Student 24']"
                          data-te-dataset-data="[2112, 2343, 2545, 3423, 2365, 1985, 987,2112, 2343, 2545, 3423, 2365, 1985, 987,2112, 2343, 2545, 3423, 2365, 1985, 987,2112, 2343, 2545]">
                        </canvas>
                        <h2 class="max-w-lg font-sans text-xl mt-4 font-bold leading-none tracking-tight dark:text-gray-200 text-gray-400 sm:text-1xl md:mx-auto">
                            89% close to the average distribution
                        </h2>
                    </div>

                    <script>

                        // Chart
                        const dataBar{{$grade->id}} = {
                        type: 'bar',
                        data: {
                            labels: ['January', 'February' , 'March' , 'April' , 'May' , 'June' , 'July ', 'August' , 'September' , 'October ', 'November' , 'December' ],
                            datasets: [
                            {
                                label: 'In time',
                                data: [1, 2, 3, 3, 4, 3, 5, 1, 2, 4, 4, 3],
                            },
                            {
                                label: 'Late',
                                data: [1, 2, 3, 3, 4, 3, 5, 1, 2, 4, 4, 3],
                            },
                            {
                                label: 'Absent Present',
                                data: [1, 2, 3, 3, 4, 3, 5, 1, 2, 4, 4, 3],
                            },
                            ],
                        },
                        };
                        const dataBarWeek{{$grade->id}} = {
                        type: 'bar',
                        data: {
                            labels: ['Monday', 'Tuesday' , 'Wednesday' , 'Thursday' , 'Friday' , 'Saturday' , 'Sunday '],
                            datasets: [
                            {
                                label: 'In time',
                                data: [2, 5, 3, 6, 2, 1, 5],
                            },
                            {
                                label: 'Late',
                                data: [2, 5, 3, 6, 2, 1, 5],
                            },
                            {
                                label: 'Absent Present',
                                data: [2, 5, 3, 6, 2, 1, 5],
                            },
                            ],
                        },
                        };

                        new te.Chart(document.getElementById('bar-chart-{{$grade->id}}'), dataBar{{$grade->id}});

                        new te.Chart(document.getElementById('bar-chart-week-{{$grade->id}}'), dataBarWeek{{$grade->id}});
                    </script>


                </div>
            </div>
        </div>
    </div>
</div>
