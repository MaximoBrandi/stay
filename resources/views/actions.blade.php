<x-app-layout>
    <x-slot name="header">
        <div class="shrink-0 flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Actions') }}
            </h2>
        </div>
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link href="{{ route('actions').'/import' }}" :active="$selected == 'import'">
                {{ __('Import') }}
            </x-nav-link>
        </div>
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link href="{{ route('actions').'/export' }}" :active="$selected == 'export'">
                {{ __('Export') }}
            </x-nav-link>
        </div>
        @if (config('app.debug') == true)
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link href="{{ route('actions').'/reports' }}" :active="$selected == 'reports'">
                {{ __('Reports') }}
            </x-nav-link>
        </div>
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link href="{{ route('actions').'/scan-points' }}" :active="$selected == 'scan-points'">
                {{ __('Scan Points') }}
            </x-nav-link>
        </div>
        @endif
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if ($selected == 'export')
                <!-- Add Course Member -->
                <div class="mt-10 sm:mt-0">
                    <livewire:teams.actions.exports.download-course />
                </div>

                <x-section-border />
                <!-- Add Course Member -->
                <div class="mt-10 sm:mt-0">
                    <livewire:teams.actions.exports.download-students />
                </div>

                <x-section-border />
                <!-- Add Course Member -->
                <div class="mt-10 sm:mt-0">
                    <livewire:teams.actions.exports.download-preceptor />
                </div>

                <x-section-border />
                <!-- Add Course Member -->
                <div class="mt-10 sm:mt-0">
                    <livewire:teams.actions.exports.download-presentism />
                </div>

                <x-section-border />

                <!-- Add Course Member -->
                <div class="mt-10 sm:mt-0">
                    <livewire:teams.actions.exports.download-retirements />
                </div>
            @elseif($selected == 'import')
                <!-- Add Course Member -->
                <div class="mt-10 sm:mt-0">
                    <livewire:teams.actions.imports.upload-course />
                </div>

                <x-section-border />
                <!-- Add Course Member -->
                <div class="mt-10 sm:mt-0">
                    <livewire:teams.actions.imports.upload-presentism />
                </div>

                <x-section-border />

                <!-- Add Course Member -->
                <div class="mt-10 sm:mt-0">
                    <livewire:teams.actions.imports.upload-absentism />
                </div>
            @elseif($selected == 'reports' && config('app.debug') == true)
                <!-- Add Course Member -->
                <div class="mt-10 sm:mt-0">
                    <livewire:teams.actions.reports.course-report />
                </div>

                <x-section-border />
                <!-- Add Course Member -->
                <div class="mt-10 sm:mt-0">
                    <livewire:teams.actions.reports.student-report />
                </div>

                <x-section-border />

                <!-- Add Course Member -->
                <div class="mt-10 sm:mt-0">
                    <livewire:teams.actions.reports.preceptor-report />
                </div>
            @elseif($selected == 'scan-points' && config('app.debug') == true)
                <!-- Add Course Member -->
                <div class="mt-10 sm:mt-0">
                    <livewire:teams.actions.scan.scan-points-list />
                </div>

                <x-section-border />

                <!-- Add Course Member -->
                <div class="mt-10 sm:mt-0">
                    <livewire:teams.actions.scan.add-scan-point />
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
