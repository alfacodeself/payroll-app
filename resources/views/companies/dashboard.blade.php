@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('partials.alert')
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    {{ __('You are logged in Dashboard Company!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection