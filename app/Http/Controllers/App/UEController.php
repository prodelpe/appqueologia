<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Models\Excavacio;
use App\Models\Sector;
use App\Models\TipusRelacio;
use App\Models\UE;
use App\Models\Relacio;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;

class UEController extends Controller {

    /**
     * INDEX
     * @param type $excavacio_id
     * @return type
     */
    public function index($excavacio_id) {
        $excavacio = Excavacio::find($excavacio_id);
        $ues = UE::all()->where('excavacio_id', $excavacio_id);
        return view('app.ue.all', compact('excavacio', 'ues'));
    }

    /**
     * CREATE
     * @param type $excavacio_id
     * @return type
     */
    public function create($excavacio_id) {
        $excavacio = Excavacio::find($excavacio_id);
        $tipus_relacions = TipusRelacio::all();
        $ues = UE::all()->where('excavacio_id', $excavacio_id);
        $sectors = UE::all()->where('excavacio_id', $excavacio_id)->groupBy('sector')->keys();

        if (config('app.demo')) {
            if ($ues->count() >= 15) {
                $errors = new MessageBag();
                $errors->add('demo_error', __('El mode DEMO només permet 5 ues per excavació'));
                return redirect()
                                ->route('app.ue.all', $excavacio_id)
                                ->withErrors($errors);
            }
        }

        return view('app.ue.create', compact('excavacio', 'tipus_relacions', 'ues', 'sectors'));
    }

    /**
     * STORE
     * @param Request $request
     * @param type $excavacio_id
     * @return type
     */
    public function store(Request $request, $excavacio_id) {

        $validator = $this->custom_validate_store($request);

        if ($validator->fails()) {
            return redirect()
                            ->route('app.ue.create', $excavacio_id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $ue_creada = UE::create([
                    'codi' => $request->codi,
                    'excavacio_id' => $excavacio_id,
                    'sector' => $request->sector_codi,
                    'definicio' => $request->definicio,
                    'descripcio' => $request->descripcio,
                    'interpretacio' => $request->interpretacio,
                    'cronologia' => $request->cronologia,
                    'criteris_datacio' => $request->criteris_datacio,
                    'observacions' => $request->observacions,
        ]);

        // --- TAULA RELACIONS ---
        // Només aplica si s'han omplert els camps de la primera relació
        if (isset($request->tipus_relacio_id[0]) && isset($request->ue_desti_id[0])) {

            for ($i = 0; $i < count($request->relacio_id); $i++) {
                $this->storeRelacio(
                        $excavacio_id, (int) $ue_creada->id, //ue_origen
                        (int) $request->tipus_relacio_id[$i], (int) $request->ue_desti_id[$i]);
            }
        }

        return redirect()
                        ->route('app.ue.all', $excavacio_id)
                        ->with('message', __('Unitat afegida'));
    }

    /**
     * SHOW
     * @param type $excavacio_id
     * @param type $id
     * @return type
     */
    public function show($excavacio_id, $id) {

        $ue = UE::find($id);
        $excavacio = Excavacio::find($excavacio_id);
        $tipus_relacions = TipusRelacio::all();
        $relacions = Relacio::where('ue_origen_id', $id)->get();

        return view('app.ue.show', compact('excavacio', 'tipus_relacions', 'ue', 'relacions'));
    }

    /**
     * EDIT
     * @param type $excavacio_id
     * @param type $id
     * @return type
     */
    public function edit($excavacio_id, $id) {

        $excavacio = Excavacio::find($excavacio_id);
        $tipus_relacions = TipusRelacio::all();
        $ue = UE::find($id);
        $ues = UE::all()->where('excavacio_id', $excavacio_id)->except($ue->id);
        $sectors = UE::all()->where('excavacio_id', $excavacio_id)->groupBy('sector')->keys();
        $relacions = Relacio::where('ue_origen_id', $id)->orderBy('tipus_relacio_id', 'ASC')->get();

        return view('app.ue.edit', compact('excavacio', 'tipus_relacions', 'ue', 'ues', 'relacions', 'sectors'));
    }

    /**
     * UPDATE
     * @param Request $request
     * @param type $id
     * @return type
     */
    public function update(Request $request, $excavacio_id, $id) {

        $validator = $this->custom_validate_update($request, $id);

        if ($validator->fails()) {
            return back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $ue = UE::find($id);

        $ue->update([
            'codi' => $request->codi,
            'excavacio_id' => $excavacio_id,
            'sector' => $request->sector_codi,
            'definicio' => $request->definicio,
            'descripcio' => $request->descripcio,
            'interpretacio' => $request->interpretacio,
            'cronologia' => $request->cronologia,
            'criteris_datacio' => $request->criteris_datacio,
            'observacions' => $request->observacions,
        ]);

        // Taula relacions
        if (count($request->relacio_id) > 0) {
            for ($i = 0; $i < count($request->relacio_id); $i++) {

                if ($request->tipus_relacio_id[$i] && (int) $request->ue_desti_id[$i]) {

                    switch (true) {

                        case ($request->estat[$i] == 'editar'):
                            $this->updateRelacio(
                                    (int) $request->relacio_id[$i], (int) $request->excavacio_id, (int) $request->ue_id, (int) $request->tipus_relacio_id[$i], (int) $request->ue_desti_id[$i]);
                            break;

                        case ($request->estat[$i] == 'crear'):
                            $this->storeRelacio(
                                    (int) $request->excavacio_id, (int) $request->ue_id, (int) $request->tipus_relacio_id[$i], (int) $request->ue_desti_id[$i]);
                            break;

                        case ($request->estat[$i] == 'esborrar'):
                            $this->deleteRelacio(
                                    (int) $request->relacio_id[$i]);
                            break;
                    }
                }
            }
        }

        return redirect()
                        ->route('app.ue.all', $excavacio_id)
                        ->with('message', __('Unitat editada'));
    }

    /**
     * DELETE
     * @param type $id
     * @return type
     */
    public function delete($excavacio_id, $id) {
        $ue = UE::find($id);
        $ue->delete();

        return redirect()
                        ->route('app.ue.all', $excavacio_id)
                        ->with('message', __('Unitat esborradada'));
    }

    /**
     * Valida els camps del formulari CREAR
     * 
     * @param Request $request
     * @return type
     */
    public function custom_validate_store(Request $request) {

        $validator = Validator::make($request->all(), [
                    'codi' => 'required|max:80',
                    'definicio' => 'max:555',
                    'descripcio' => 'max:555',
                    'intrerpretacio' => 'max:555',
                    'cronologia' => 'max:40',
                    'criteris_datacio' => 'max:40',
                    'observacions' => 'max:555'
        ]);

        return $validator;
    }

    // ---------------------------------
    // --------- VALIDACIONS -----------
    // ---------------------------------
    /**
     * Valida els camps del formulari EDITAR
     * Te la diferència d'ignorar l'id
     * 
     * @param Request $request
     * @return type
     */
    public function custom_validate_update(Request $request) {

        if ($request->ue_id) {
            $ue = UE::find($request->ue_id);
        } else {
            
        }

        $validator = Validator::make($request->all(), [
                    'codi' => 'required|max:80|' . Rule::unique('ues', 'id')->where('excavacio_id', $request->excavacio_id)->ignore($ue->id),
                    'definicio' => 'max:555',
                    'descripcio' => 'max:555',
                    'intrerpretacio' => 'max:555',
                    'cronologia' => 'max:40',
                    'criteris_datacio' => 'max:40',
                    'observacions' => 'max:555'
        ]);

        return $validator;
    }

    // ---------------------------------
    // --------- CRUD RELACIÓ ----------
    // --- Relació no te controlador ---
    // ---------------------------------

    /**
     * Crea una relació
     * Quan es crea una relació també s'ha de crear la seva inversa
     * Un cop creada la inversa, extreiem el seu id i el guardem a la relació d'origen
     * 
     */
    public function storeRelacio($excavacio_id, $ue_origen_id, $tipus_relacio_id, $ue_desti_id) {
        $relacio_creada = Relacio::create([
                    'excavacio_id' => (int) $excavacio_id,
                    'ue_origen_id' => $ue_origen_id,
                    'tipus_relacio_id' => $tipus_relacio_id,
                    'ue_desti_id' => $ue_desti_id,
        ]);

        $relacio_inversa_creada = Relacio::create([
                    'excavacio_id' => (int) $excavacio_id,
                    'ue_origen_id' => $ue_desti_id,
                    'tipus_relacio_id' => TipusRelacio::find($tipus_relacio_id)->invers,
                    'ue_desti_id' => $ue_origen_id,
                    'inversa' => $relacio_creada->id,
        ]);

        $relacio_creada->update([
            'inversa' => $relacio_inversa_creada->id,
        ]);
    }

    /**
     * Edita relació amb el mateix sistema
     * 
     */
    public function updateRelacio($rel_id, $excavacio_id, $ue_id, $tipus_relacio_id, $ue_desti_id) {

        $relacio = Relacio::find($rel_id);

        $relacio->update([
            'excavacio_id' => (int) $excavacio_id,
            'ue_origen_id' => $ue_id,
            'tipus_relacio_id' => $tipus_relacio_id,
            'ue_desti_id' => $ue_desti_id,
        ]);

        $relacio_inversa = Relacio::find($relacio->inversa);

        $relacio_inversa->update([
            'excavacio_id' => (int) $excavacio_id,
            'ue_origen_id' => $ue_desti_id,
            'tipus_relacio_id' => TipusRelacio::find($tipus_relacio_id)->invers,
            'ue_desti_id' => $ue_id,
        ]);

        $relacio->update([
            'inversa' => $relacio_inversa->id,
        ]);
    }

    /**
     * Esborra la relació en qüestió
     * 
     * @param type $rel_id
     * @param type $excavacio_id
     * @param type $ue_id
     * @param type $ue_desti_id
     */
    public function deleteRelacio($rel_id) {
        $relacio = Relacio::find($rel_id);
        $relacio_inversa = Relacio::find($relacio->inversa);
        $relacio->delete();
        $relacio_inversa->delete();
    }

}
