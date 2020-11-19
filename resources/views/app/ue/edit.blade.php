@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-body">
        <form id="ue_edit" method="post" action="{{ route('app.ue.update', ['excavacio_id' => $excavacio->id, 'id' => $ue->id]) }}">
            <input type="hidden" id="ue_id" name="ue_id" value="{{ isset($ue) ? $ue->id : '' }}"/>
            <input type="hidden" id="excavacio_id" name="excavacio_id" value="{{ isset($excavacio) ? $excavacio->id : '' }}"/>
            
            @include('app.ue.fields')
            
            <button type="submit" class="btn btn-outline-primary">{{ __('Editar') }}</button>
            <a href="{{ route('app.ue.all', [$excavacio->id]) }}" class="btn btn-outline-secondary">{{ __('Cancel·lar') }}</a>
        </form>
    </div>
</div>

@endsection