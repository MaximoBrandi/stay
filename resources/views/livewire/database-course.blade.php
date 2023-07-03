<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
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
              {{$course}}
            </h2>
        </div>
        <livewire:course-resume-milestones :course="$course" />

        <livewire:course-resume-database :course="$course" />
        <div class="flex mt-8 dark:text-gray-200 -mb-8 justify-center">
            <h1>Course 2 attendance</h1>
        </div>
        <livewire:database-attendance :course="$course"/>
        <div class="flex mt-8 dark:text-gray-200 -mb-8 justify-center">
            <h1>Course 2 retirements</h1>
        </div>
        <livewire:database-retirements :course="$course"/>
    </div>
</div>
