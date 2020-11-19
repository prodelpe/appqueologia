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
        <form id="form_excavacio_update" method="post" action="{{ route('app.excavacio.update', $excavacio->id) }}">
            @include('app.excavacio.fields')
        </form>
        <button type="submit"form="form_excavacio_update"  class="btn btn-outline-primary">{{ __('Editar') }}</button>
        <a href="{{ route('app.excavacio.all') }}" class="btn btn-outline-secondary">{{ __('Cancel·lar') }}</a>
    </div>
</div>

@endsection
