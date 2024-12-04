@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Task Management System</h1>
        <p>This is a test project by JC Taylo.</p>

        <p>Today: {{ now()->toFormattedDateString() }}</p>
    </div>
@endsection