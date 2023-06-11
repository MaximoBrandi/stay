<div>
    <div class="flex mt-8 mb-6 justify-center">
        <h1>Course {{Auth::user()->currentTeam->id}} today's attencance</h1>
    </div>
    <div class="flex mt-8 -mb-6 justify-center">
        <h1>Retired</h1>
    </div>
    <livewire:retirement-status />
    <div class="flex mt-8 -mb-6 justify-center">
        <h1>Present</h1>
    </div>
    <livewire:attendance-present />
    <div class="flex mt-8 -mb-6 justify-center">
        <h1>Absent</h1>
    </div>
    <livewire:attendance-absent />
</div>
