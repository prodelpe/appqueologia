@extends('layouts.app')

@section('content')

@if ($errors->any())
<div class="alert alert-danger w-100">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-body">
        <form id="excavacio_create" method="post" action="{{ route('app.excavacio.store') }}">
            @include('app.excavacio.fields')
        </form>
        <button form="excavacio_create" type="submit" class="btn btn-outline-primary">{{ __('Desar') }}</button>
        <a href="{{ route('app.excavacio.all') }}" class="btn btn-outline-secondary">{{ __('Cancel·lar') }}</a>
    </div>
</div>

@endsection
