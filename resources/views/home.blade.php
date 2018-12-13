@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (Auth::user()->gameEntries->count() > 0)
                    <p>You've made some entries</p>
                    @foreach(Auth::user()->gameEntries as $g)
                    <p>
                        <strong>{{ $g['outcome_1'] }}</strong> {{ $g['outcome_1_value'] }}%<br>
                        <strong>{{ $g['outcome_2'] }}</strong> {{ $g['outcome_2_value'] }}%<br>
                        <strong>Put it on page...</strong> {{ $g['page'] }}
                    </p>
                    {{ $g }}
                    @endforeach
                    @else
                    <p>You haven't made any entries</p>
                    <pre>#swangame Outcome 1: 50%; Outcome 2: 50%; put it on page 50.</pre>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
