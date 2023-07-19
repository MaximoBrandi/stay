<div>
    @if (Auth::user()->privilege->privilege_grade == 1)
        <livewire:retirements-table :course="Auth::user()->currentTeam"/>
    @elseif (App\Models\retirement::find(1))
        <livewire:datatable model="App\Models\retirement" name="all-users"/>
    @endif
</div>
