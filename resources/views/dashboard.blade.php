<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="vendor/hystModal/hystmodal.min.css">
    <script src="vendor/hystModal/hystmodal.min.js"></script>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (Auth::user()->privilege->privilege_id > 2)
            <div class="bg-white dark:bg-gray-800 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="hystmodal" id="disengageModal2" aria-hidden="true">
                    <div class="hystmodal__wrap">
                        <div class="hystmodal__window" role="dialog" aria-modal="true">
                            <button data-hystclose class="hystmodal__close">Закрыть</button>
                            <div class="bg-white dark:bg-gray-800 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
                                <livewire:disengage-students-component />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hystmodal" id="absentDay2" aria-hidden="true">
                    <div class="hystmodal__wrap">
                        <div class="hystmodal__window" role="dialog" aria-modal="true">
                            <button data-hystclose class="hystmodal__close">Закрыть</button>
                            <div class="bg-white dark:bg-gray-800 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
                                <livewire:absent-day-component />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hystmodal" id="retirementAverage2" aria-hidden="true">
                    <div class="hystmodal__wrap">
                        <div class="hystmodal__window" role="dialog" aria-modal="true">
                            <button data-hystclose class="hystmodal__close">Закрыть</button>
                            <div class="bg-white dark:bg-gray-800 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
                                <livewire:retirement-average-component />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hystmodal" id="absentAverage2" aria-hidden="true">
                    <div class="hystmodal__wrap">
                        <div class="hystmodal__window" role="dialog" aria-modal="true">
                            <button data-hystclose class="hystmodal__close">Закрыть</button>
                            <div class="bg-white dark:bg-gray-800 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
                                <livewire:absent-average-component />
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    const absentDay2 = new HystModal({
                        linkAttributeName: "data-hystmodal",
                        //settings (optional). see API
                    });
                </script>
                <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
                    <div class="mb-8 max-w-xl md:mx-auto sm:text-center lg:max-w-2xl">
                        <h2 class="max-w-lg font-sans dark:text-gray-200 text-3xl font-bold leading-none tracking-tight text-gray-900 sm:text-4xl md:mx-auto">
                          <span class="relative inline-block">
                            <svg viewBox="0 0 52 24" fill="currentColor" class="absolute top-0 left-0 z-0 hidden w-32 -mt-8 -ml-20 dark:text-indigo-800 text-blue-gray-100 lg:w-32 lg:-ml-28 lg:-mt-10 sm:block">
                              <defs>
                                <pattern id="ea469ae8-e6ec-4aca-8875-fc402da4d16e" x="0" y="0" width=".135" height=".30">
                                  <circle cx="1" cy="1" r=".7"></circle>
                                </pattern>
                              </defs>
                              <rect fill="url(#ea469ae8-e6ec-4aca-8875-fc402da4d16e)" width="52" height="24"></rect>
                            </svg>
                            <span class="relative">Course</span>
                          </span>
                          {{Auth::user()->current_team_id}}
                        </h2>
                    </div>
                    <livewire:course-resume-milestones :course=" Auth::user()->currentTeam->id " />
                </div>
            </div>
            @endif
            @if (Auth::user()->privilege->privilege_grade == 1)
                <div class="bg-white dark:bg-gray-200 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
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
