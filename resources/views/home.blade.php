@extends('layouts.app')
@section('format')
<p>Follow the format below:</p>
<pre>#swangame Outcome 1: 50%; Outcome 2: 50%; put it on page 50.</pre>
@endsection
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
                        <em>{{ $g['created_at'] }}</em><br>
                        @foreach($g->options as $o)
                        <strong>{{ $o->outcome }}</strong> {{ $o->value }}%; 
                        @endforeach
                        <strong>Put it on page...</strong> {{ $g['page'] }}
                    </p>
                    <hr>
                    @yield('format')
                    @endforeach
                    @else
                    <div class="alert alert-info">
                        You haven't made any entries.
                    </div>
                    @yield('format')
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
