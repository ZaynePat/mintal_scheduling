@extends('layouts.app')

@section('content')
<div class="text-center">
    <h1>
        Activity Logs
    </h1>
</div>
<div class="container pt-5">
    <table class="table" id="datatablesDefault" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Activity Type</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->created_at->format('Y-m-d') }}</td>
                <td>{{ $log->created_at->format('H:i:s') }}</td>
                <td>{{ $log->activity_type }}</td>
                <td>{{ $log->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
