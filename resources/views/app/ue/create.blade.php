@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <form id="ue_create" method="post" action="{{ route('app.ue.store', $excavacio->id) }}">
                @include('app.ue.fields')
                <button @click="addRelation" type="submit" class="btn btn-outline-primary">{{ __('Desar') }}</button>
                <a href="{{ route('app.ue.all', [$excavacio->id]) }}" class="btn btn-outline-secondary">{{ __('Cancel·lar') }}</a>
            </form>
        </div>
    </div>
    
@endsection
