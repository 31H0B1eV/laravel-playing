@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                    <hr>
                    @if(isset($user))
                        <ul>
                            <li>Full name: {{ $user->name }}</li>
                            <li>Email: {{ $user->email }}</li>
                            <li>
                                <ul>
                                    <li>{{ $user->social->first()->user_id }}</li>
                                    <li>{{ $user->social->first()->provider_name }}</li>
                                    <li>{{ $user->social->first()->provider_user_id }}</li>
                                    <li>{{ $user->social->first()->provider_token }}</li>
                                </ul>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
