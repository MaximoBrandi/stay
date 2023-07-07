<div>
    <livewire:database.course.course-milestones :course=" $course" />

    <livewire:database.course.course-resume :course="$course" />
    <div class="flex mt-8 dark:text-gray-200 -mb-8 justify-center">
        <h1>{{$course->name}} attendances</h1>
    </div>
    <livewire:database-attendance :course="$course"/>
    <div class="flex mt-8 dark:text-gray-200 -mb-8 justify-center">
        <h1>{{$course->name}} retirements</h1>
    </div>
    <livewire:database-retirements :course="$course"/>
        <div class="flex mt-8 dark:text-gray-200 -mb-8 justify-center">
            <h1>{{$course->name}} absents</h1>
        </div>
    <livewire:database-retirements :course="$course"/>
</div>
