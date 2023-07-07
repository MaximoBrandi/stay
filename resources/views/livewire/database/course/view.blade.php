<div>
    <livewire:course-resume-milestones :course="$course" />

    <livewire:course-resume-database :course="$course" />
    <div class="flex mt-8 dark:text-gray-200 -mb-8 justify-center">
        <h1>{{$course->name}} attendance</h1>
    </div>
    <livewire:database-attendance :course="$course"/>
    <div class="flex mt-8 dark:text-gray-200 -mb-8 justify-center">
        <h1>{{$course->name}} retirements</h1>
    </div>
    <livewire:database-retirements :course="$course"/>
</div>
