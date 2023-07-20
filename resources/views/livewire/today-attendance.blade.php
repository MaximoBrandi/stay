<div>
    <div class="flex mt-8 mb-6 justify-center">
        <h1>{{Auth::user()->currentTeam->name}} today's attencance</h1>
    </div>
    <div class="flex mt-8 -mb-6 justify-center">
        <h1>Retired</h1>
    </div>
    <livewire:retirement-status :course="Auth::user()->currentTeam" />
    <div class="flex mt-8 -mb-6 justify-center">
        <h1>Present</h1>
    </div>
    <livewire:attendance-present :course="Auth::user()->currentTeam" />
    <div class="flex mt-8 -mb-6 justify-center">
        <h1>Absent</h1>
    </div>
    <livewire:attendance-absent :course="Auth::user()->currentTeam" />
</div>
