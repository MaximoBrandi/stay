<div>
    <div class="flex mt-8 mb-6 justify-center">
        <h1>Course {{Auth::user()->currentTeam->id}} today's retirements</h1>
    </div>
    <livewire:retirement-status />
</div>
