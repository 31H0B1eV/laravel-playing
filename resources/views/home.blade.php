@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if(\Auth::check() && isset($user))
                        <profile
                            :user="{{ $user }}"
                            :social="{{ json_encode($providers) }}" ></profile>
                    @else
                        <h3>You really need this user info?</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
