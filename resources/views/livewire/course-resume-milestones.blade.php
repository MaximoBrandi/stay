<div class="grid gap-8 row-gap-10 grid-cols-4">
    <div class="hystmodal" id="disengageModal{{$course}}" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">Закрыть</button>
                <div class="bg-white dark:bg-gray-800 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
                    <livewire:disengage-students-component :course="$course"/>
                </div>
            </div>
        </div>
    </div>
    <div class="hystmodal" id="absentDay{{$course}}" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">Закрыть</button>
                <div class="bg-white dark:bg-gray-800 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
                    <livewire:absent-day-component :course="$course"/>
                </div>
            </div>
        </div>
    </div>
    <div class="hystmodal" id="retirementAverage{{$course}}" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">Закрыть</button>
                <div class="bg-white dark:bg-gray-800 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
                    <livewire:retirement-average-component :course="$course"/>
                </div>
            </div>
        </div>
    </div>
    <div class="hystmodal" id="absentAverage{{$course}}" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">Закрыть</button>
                <div class="bg-white dark:bg-gray-800 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
                    <livewire:absent-average-component :course="$course"/>
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
    <div class="max-w-md sm:mx-auto sm:text-center">
      <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full dark:bg-indigo-800 bg-indigo-50 sm:mx-auto sm:w-24 sm:h-24">
        <svg class="w-12 h-12 text-deep-purple-accent-400 sm:w-16 sm:h-16" stroke="currentColor" viewBox="0 0 52 52">
          <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
        </svg>
      </div>
      <h6 class="mb-3 text-xl dark:text-white font-bold leading-5">{{$PromedioAusentes}}</h6>
      <p class="mb-3 text-sm dark:text-gray-200 text-gray-900">
          Absent average per class
      </p>
      <a href="javascript:void(0)" aria-label="" data-hystmodal="#absentAverage{{$course}}"  class="inline-flex items-center font-semibold transition-colors duration-200 dark:text-gray-400 text-deep-purple-accent-400 hover:text-deep-purple-800">Learn more</a>
    </div>
    <div class="max-w-md sm:mx-auto sm:text-center">
      <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full dark:bg-indigo-800 bg-indigo-50 sm:mx-auto sm:w-24 sm:h-24">
        <svg class="w-12 h-12 text-deep-purple-accent-400 sm:w-16 sm:h-16" stroke="currentColor" viewBox="0 0 52 52">
          <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
        </svg>
      </div>
      <h6 class="mb-3 text-xl dark:text-white font-bold leading-5">{{$PromedioRetiros}}</h6>
      <p class="mb-3 text-sm dark:text-gray-200 text-gray-900">
          Retirement average per week
      </p>
      <a href="javascript:void(0)" aria-label="" data-hystmodal="#retirementAverage{{$course}}"  class="inline-flex items-center font-semibold transition-colors duration-200 dark:text-gray-400 text-deep-purple-accent-400 hover:text-deep-purple-800">Learn more</a>
    </div>
    <div class="max-w-md sm:mx-auto sm:text-center">
      <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full dark:bg-indigo-800 bg-indigo-50 sm:mx-auto sm:w-24 sm:h-24">
        <svg class="w-12 h-12 text-deep-purple-accent-400 sm:w-16 sm:h-16" stroke="currentColor" viewBox="0 0 52 52">
          <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
        </svg>
      </div>
      <h6 class="mb-3 text-xl dark:text-white font-bold leading-5">{{$diaMasAusentes}}</h6>
      <p class="mb-3 text-sm dark:text-gray-200 text-gray-900">
          Most absent day
      </p>
      <a href="javascript:void(0)" aria-label="" data-hystmodal="#absentDay{{$course}}"  class="inline-flex items-center font-semibold transition-colors duration-200 dark:text-gray-400 text-deep-purple-accent-400 hover:text-deep-purple-800">Learn more</a>
    </div>
    <div class="max-w-md sm:mx-auto sm:text-center">
      <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full dark:bg-indigo-800 bg-indigo-50 sm:mx-auto sm:w-24 sm:h-24">
        <svg class="w-12 h-12 text-deep-purple-accent-400 sm:w-16 sm:h-16" stroke="currentColor" viewBox="0 0 52 52">
          <polygon stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none" points="29 13 14 29 25 29 23 39 38 23 27 23"></polygon>
        </svg>
      </div>
      <h6 class="mb-3 text-xl dark:text-white font-bold leading-5">{{$disengage}}</h6>
      <p class="mb-3 text-sm dark:text-gray-200 text-gray-900">
          Student's close to disengage
      </p>
      <a href="javascript:void(0)" aria-label="" data-hystmodal="#disengageModal{{$course}}" class="inline-flex items-center font-semibold transition-colors duration-200 dark:text-gray-400 text-deep-purple-accent-400 hover:text-deep-purple-800">Learn more</a>
    </div>
  </div>
