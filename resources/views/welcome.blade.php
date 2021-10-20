@extends('layouts.app')

@section('content')
<div id="app">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <dashboard></dashboard>
            </div>
        </div>
    </div>
</div>
@endsection
