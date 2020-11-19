@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center">
        <h6 class="text-gray-800 leading-tight mb-0">
            {{ __('Unitats estratigràfiques disponibles') }}
        </h6>
        <a href="{{ route('app.ue.create', ['excavacio_id' => $excavacio->id]) }}" class="btn btn-outline-success ml-auto" alt="{{ __('Crear') }}">
            {{ __('Crear una nova UE') }}
        </a>
    </div>
    <div class="card-body">
        @if(count($ues) == 0)
        {{ __('Aquest sector no te cap unitat estratigràfica') }}
        @else
        <table id="datatable" class="table table-striped display responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <!--<th scope="col" data-priority="1">{{ __('Id') }}</th>-->
                    <th scope="col" data-priority="1"></th>
                    <th scope="col" data-priority="2">{{ __('UE') }}</th>
                    <th scope="col" data-priority="3">{{ __('Definició') }}</th>
                    <th scope="col" data-priority="3">{{ __('Creada') }}</th>
                    <th scope="col" data-priority="3">{{ __('Editada') }}</th>
                    <th scope="col" data-priority="1"></th>
                    <th scope="col" data-priority="1"></th>
                    <th scope="col" data-priority="1"></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($ues as $ue)       
                <tr>
                    <!--<td>{{ $ue->id }}</td>-->
                    <td style="text-align:center">
                        <a href="{{ route('app.ue.pdf', ['excavacio_id' => $excavacio->id, 'id' => $ue->id]) }}" class="btn btn-outline-dark" alt="{{ __('PDF') }}" target="_blank">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </td>
                    <td>{{ $ue->codi }}</td>
                    <td>{{ $ue->definicio }}</td>
                    <td>{{ $ue->created_at }}</td>
                    <td>{{ $ue->updated_at }}</td>
                    <td>
                        <a href="{{ route('app.ue.show', ['excavacio_id' => $excavacio->id, 'id' => $ue->id]) }}" class="btn btn-outline-primary" alt="{{ __('Veure') }}">
                            <i class="far fa-eye"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('app.ue.edit', ['excavacio_id' => $excavacio->id, 'id' => $ue->id]) }}" class="btn btn-outline-success" alt="{{ __('Editar') }}">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('app.ue.delete', ['excavacio_id' => $excavacio->id, 'id' => $ue->id]) }}"  onclick="return confirm('{{ __("ATENCIÓ!! Això esborrarà aquesta UE i totes les seves relacions!!! Continuar?") }}')" class="btn btn-outline-danger" alt="{{ __('Esborrar') }}">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        <div class="row">
            <div class="col-md-3">
                <a href="{{ route('app.excavacio.all', [$excavacio->id]) }}" class="btn btn-outline-secondary">{{ __('Tornar') }}</a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('footer-scripts')
<script type="text/javascript">
    $('#datatable').DataTable({
    responsive: true
    });
</script>
@endpush