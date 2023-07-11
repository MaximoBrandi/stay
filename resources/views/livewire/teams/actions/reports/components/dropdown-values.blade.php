<div>
    @foreach ($selectedInput as $team)
        @foreach (\App\Models\User::where('current_team_id', '=', $team->id)->whereHas('privilege', function ($query) {
            $query->where('privilege_grade', '=', 1);
        })->get() as $student)

            <h2 value="{{$student->id}}">{{$student->name}}</h2>

        @endforeach
    @endforeach
</div>
