@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h6 class="text-gray-800 leading-tight mb-0">
                {{ __('Excavacions disponibles') }}
            </h6>
            <a href="{{ route('app.excavacio.create') }}" class="btn btn-outline-success ml-auto" alt="{{ __('Crear') }}">
                {{ __('Crear nova excavació') }}
            </a>
        </div>
        <div class="card-body">
            @if (count($excavacions) == 0)
            {{ __('No hi ha cap excavació') }}
            @else
            <table id="datatable" class="table table-striped display responsive nowrap" width="100%">
                <thead>
                    <tr>
                        <th scope="col" data-priority="1"></th>
                        <th scope="col" data-priority="1">{{ __('Codi') }}</th>
                        <th scope="col" data-priority="2">{{ __('Nom') }}</th>
                        <th scope="col" data-priority="3">{{ __('Creada') }}</th>
                        <th scope="col" data-priority="3">{{ __('Editada') }}</th>
                        <th scope="col" data-priority="1"></th>
                        <th scope="col" data-priority="1"></th>
                        <th scope="col" data-priority="1"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($excavacions as $excavacio)
                    <tr>
                        <td style="text-align:center">
                            <a href="{{ route('app.excavacio.pdf', $excavacio->id) }}" class="btn btn-outline-dark" alt="{{ __('PDF') }}" target="_blank">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        </td>
                        <td>
                            {{ $excavacio->codi }}<br>
                            <small class="text-xs">{{ $excavacio->numberOfUes() }} UEs</small>
                        </td>
                        <td>{{ $excavacio->nom }}<br>
                            <small>{{ $excavacio->poblacio }}</small></td>
                        <td>{{ $excavacio->created_at ? date('d-m-Y', strtotime($excavacio->created_at)) : '' }}</td>
                        <td>{{ $excavacio->created_at ? date('d-m-Y', strtotime($excavacio->updated_at)) : '' }}</td>
                        <td>
                            <a href="{{ route('app.ue.all', $excavacio->id) }}" class="btn btn-outline-primary" alt="{{ __('Veure') }}">
                                <i class="far fa-eye"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('app.excavacio.edit', $excavacio->id) }}" class="btn btn-outline-success" alt="{{ __('Editar') }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{-- route('app.excavacio.destroy', $excavacio->id) --}" onclick="return confirm('{{ __("ATENCIÓ!! Això esborrarà aquesta excavació i tota la seva informació!!! Continuar?") }}')" class="btn btn-outline-danger" alt="{{ __('Esborrar') }}">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
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