@csrf

<div class="row d-none d-md-flex">
    <div class="col-md-5">
        <div class="form-group">
            <label>{{ __('Població / Municipi / Comarca') }}</label>
            <input type="text" class="form-control" id="poblacio" disabled value="{{ $excavacio->poblacio }}"/>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label>{{ __('Lloc / Jaciment') }}</label>
            <input type="text" class="form-control" id="nom" disabled value="{{ $excavacio->nom }}"/>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>{{ __('Codi') }}</label>
            <input type="text" class="form-control" id="codi_excavacio" disabled value="{{ $excavacio->codi }}"/>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label>{{ __('UE') }}</label>
            <input type="text" class="form-control" id="codi" name="codi" value="{{ isset($ue) ? $ue->codi : '' }}"/>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group d-none d-md-block">
            <label>{{ __('Zona / Sector / Àmbit') }}</label>
            <input type="text" class="form-control" id="sector_codi" value="{{ isset($ue) ? $ue->sector : '' }}"/>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label>{{ __('Definició') }}</label>
            <select type="text" class="form-control" id="definicio" name="definicio" value="{{ isset($ue) ? $ue->definicio : '' }}">
                <option>Estructura</option>
                <option>Estrat</option>
                <option>Negativa</option>
            </select>        
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label>{{ __('Descripció') }}</label>
            <textarea class="form-control" id="descripcio" name="descripcio">{{ isset($ue) ? $ue->descripcio : '' }}</textarea>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <p>{{ __('Relacions estratigràfiques') }}</p> 
    </div>
</div>


<div id="relacions">

    <div v-for="(input,k) in inputs" v-bind:key="k">

        <div class="form-group" v-show="input.show">

            <div class="row">

                <input type="hidden" name="estat[]" v-model="input.estat"/>
                <input type="hidden" name="relacio_id[]" v-model="input.relacio_id"/>

                <div class="col-md-2 col-4">
                    <select class="form-control" name="tipus_relacio_id[]" v-model="input.tipus_relacio_id">>
                        <option value=""></option>
                        @foreach($tipus_relacions as $tipus_relacio)
                        <option value="{{ $tipus_relacio->id }}">{{ $tipus_relacio->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-8 col-4">
                    <select class="form-control" name="ue_desti_id[]" v-model="input.ue_desti_id">
                        <option value=""></option>
                        @foreach($ues as $ue)
                        <option value="{{ $ue->id }}">{{ $ue->codi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 col-4">
                    <div @click="remove(k)" v-show="k || ( !k && inputs.length > 1)" class="btn btn-outline-danger w-100">{{ __('Eliminar') }}</div>
                </div>
            </div>
        </div>
        
                    <div class="row">
                <div class="col-md-2 col-4">
                    <div @click="add(k)" v-show="k == inputs.length-1" class="btn btn-outline-success w-100 mb-3">{{ __('Afegir') }}</div>
                </div>
            </div>

    </div>

</div><!-- end relacions -->


<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label>{{ __('Interpretació') }}</label>
            <textarea class="form-control" id="interpretacio" name="interpretacio">{{ isset($ue) ? $ue->interpretacio : '' }}</textarea>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('Cronologia') }}</label>
            <input type="text" class="form-control" id="cronologia" name="cronologia" value="{{ isset($ue) ? $ue->cronologia : '' }}"/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('Criteris de datació') }}</label>
            <input type="text" class="form-control" id="criteris_datacio" name="criteris_datacio" value="{{ isset($ue) ? $ue->criteris_datacio : '' }}"/>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label>{{ __('Observacions') }}</label>
            <textarea class="form-control" id="observacions" name="observacions">{{ isset($ue) ? $ue->observacions : '' }}</textarea>
        </div>
    </div>
</div>

@push('footer-scripts')

<script type="text/javascript">
    //https://stackoverflow.com/questions/57061964/how-to-dynamically-create-input-fields-in-vuejs

    const relacions = new Vue({
        el: '#relacions',
        data() {
            return {
                inputs: [
                        @if (isset($relacions) && count($relacions) > 0)
                            @foreach($relacions as $relacio){
                                show: true,
                                estat: 'editar',
                                relacio_id: '{{ $relacio->id }}',
                                tipus_relacio_id: '{{ $relacio->tipus_relacio_id }}',
                                ue_desti_id: '{{ $relacio->ue_desti_id }}'
                            },
                            @endforeach
                        @else 
                        {
                            show: true,
                            estat: 'crear',
                            relacio_id: '',
                            tipus_relacio_id: '',
                            ue_desti_id: ''
                        },
                        @endif

                    ]

                }
            },
            methods: {
                add() {
                    this.inputs.push({
                        show: true,
                        estat: 'crear',
                        relacio_id: '',
                        tipus_relacio_id: '',
                        ue_desti_id: '',
                    });
                },

                remove(index) {
                    //Si esborrem una fila acabada de crear, la elimina
                    //Si era una relació que ja existia (i per tant tenia tipus_relacio_id)
                    //la ocultem per eliminar-la amb el controlador
                    if (this.inputs[index].tipus_relacio_id != ''){
                        this.inputs[index].estat = 'esborrar';
                        this.inputs[index].show = false;
                    } else {
                        this.inputs.splice(index, 1);
                    }
                },
            }
    });
    
    </script>
    
        <script>
            /* 
             * Autocomplete
             * https://xdsoft.net/jqplugins/autocomplete/#local
             */
            
            var sectors = [
                @foreach($sectors as $sector)
                '{{ $sector }}',
                @endforeach
            ];

            $( document ).ready(function() {
              $("#sector_codi").autocomplete ({
                source:[sectors]
              }); 
            });
        </script>
   
@endpush