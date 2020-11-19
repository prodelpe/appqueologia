@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-body">

        <div class="row d-md-flex">
            <div class="col-md-5">
                <p class="mb-2">{{ __('Població / Municipi / Comarca') }}</p>
                <p class="p-2 border border-gray rounded" style="min-height:40px">{{ $excavacio->poblacio }}</p>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <p class="mb-2">{{ __('Lloc / Jaciment') }}</p>
                    <p class="p-2 border border-gray rounded" style="min-height:40px">{{ $excavacio->nom }}</p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <p class="mb-2">{{ __('Codi') }}</p>
                    <p class="p-2 border border-gray rounded" style="min-height:40px">{{ $excavacio->codi }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <p class="mb-2">{{ __('UE') }}</p>
                <p class="p-2 border border-gray rounded" style="min-height:40px">{{ isset($ue) ? $ue->codi : '' }}</p>
            </div>
            <div class="col-md-5">
                <div class="form-group d-none d-md-block">
                    <p class="mb-2">{{ __('Zona / Sector / Àmbit') }}</p>
                    <p class="p-2 border border-gray rounded" style="min-height:40px">{{ isset($ue) ? $ue->sector : '' }}</p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <p class="mb-2">{{ __('Definició') }}</p>
                    <p class="p-2 border border-gray rounded" style="min-height:40px">{{ isset($ue) ? $ue->definicio : '' }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p class="mb-2">{{ __('Descripció') }}</p>
                <p class="p-2 border border-gray rounded" style="min-height:80px">{{ isset($ue) ? $ue->descripcio : '' }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p class="mb-4">{{ __('Relacions estratogràfiques') }}</p>
            </div>
        </div>

        @foreach($tipus_relacions as $key => $tipus_relacio)
        <div class="row">
            <div class="col-2">
                <p class="p-1 small">{{ $tipus_relacio->nom }}</p>
            </div>
            <div class="col-10">
                <p class="small p-1 border border-gray rounded" style="min-height:30px">
                    <!-- {* Alternativa sense comes: $relacio->ue_desti->codi *} -->

                    {{ 
                        \App\Models\Relacio::join('ues', 'ues.id', '=', 'relacions.ue_desti_id')
                                ->where('relacions.excavacio_id', $excavacio->id)
                                ->where('relacions.ue_origen_id', $ue->id)
                                ->where('relacions.tipus_relacio_id', $key+1)
                                ->get('ues.codi')
                                ->pluck('codi')
                                ->implode(', ')
                    }}

                </p>
            </div>
        </div>
        @endforeach

        <div class="row">
            <div class="col-12">
                <p class="mb-2">{{ __('Interpretació') }}</p>
                <p class="p-2 border border-gray rounded" style="min-height:40px">{{ $ue->interpretacio }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <p class="mb-2">{{ __('Cronologia') }}</p>
                <p class="p-2 border border-gray rounded" style="min-height:40px">{{ $ue->cronologia }}</p>
            </div>
            <div class="col-md-6">
                <p class="mb-2">{{ __('Criteris de datació') }}</p>
                <p class="p-2 border border-gray rounded" style="min-height:40px">{{ $ue->criteris_datacio }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p class="mb-2">{{ __('Observacions') }}</p>
                <p class="p-2 border border-gray rounded" style="min-height:80px">{{ $ue->observacions }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 d-flex">
                <a href="{{ route('app.ue.pdf', ['excavacio_id' => $excavacio->id, 'id' => $ue->id]) }}" class="btn btn-outline-dark mr-1" alt="{{ __('PDF') }}" target="_blank">
                    {{ __('Veure PDF') }}
                </a>
                <a href="{{ route('app.ue.all', [$excavacio->id]) }}" class="btn btn-outline-secondary">
                    {{ __('Cancel·lar') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection