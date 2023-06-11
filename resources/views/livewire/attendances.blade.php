<div>
    @if (Auth::user()->privilege->privilege_grade == 1)
        <livewire:users-table />
    @elseif (App\Models\AttendanceModel::find(0))
        <livewire:datatable model="App\Models\AttendanceModel" name="all-users" />
    @endif
</div>
