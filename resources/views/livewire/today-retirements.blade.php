<div>
    <div class="flex mt-8 mb-6 justify-center">
        <h1>{{Auth::user()->currentTeam->name}} today's retirements</h1>
    </div>
    <livewire:retirement-status :course="Auth::user()->currentTeam"/>
</div>
