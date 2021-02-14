@extends('layouts.app')

@section('content')
<div class="row">
    @foreach($weeklyJobList as $weeklyJobsKey => $weeklyJobs)
        @php
            $weeklyJobKeyParts = explode('-', $weeklyJobsKey);
            $devName = config('dev_lists')[$weeklyJobKeyParts[0]][$weeklyJobKeyParts[1]];
        @endphp
        <div class="col">
            @if($weeklyJobs !== null)
                @foreach($weeklyJobs as $weeklyJobKey => $weeklyJob)
                    <div class="card mb-5">
                        <h5 class="card-header">
                            {{ $devName['name'] }} | {{ $weeklyJobKey }}. hafta
                        </h5>
                        <ul class="list-group list-group-flush">
                            @php $startDay = 0; @endphp
                            @foreach($weeklyJob as $weeklyJobHourKey => $weeklyJobHour)
                                @php $modDay = $weeklyJobHourKey%9; @endphp
                                @if($modDay == 0)
                                    @php $startDay++; @endphp
                                    <li class="list-group-item list-group-item-success">
                                        {{ $startDay }}. gün
                                    </li>
                                @endif
                                <li class="list-group-item">{{ isset($weeklyJobHour['title']) ? $weeklyJobHour['title'] : '-' }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @endif
        </div>
    @endforeach
</div>
@endsection
