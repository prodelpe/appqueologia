<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Models\Excavacio;
use App\Models\Sector;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ExcavacioController extends Controller {

    public function index() {
        $excavacions = Excavacio::all();
        return view('app.excavacio.all', compact('excavacions'));
    }

    public function create() {
        return view('app.excavacio.create');
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
                    'codi' => 'required|unique:excavacions|max:255',
                    'nom' => 'required|max:255',
                    'poblacio' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                            ->route('app.excavacio.create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $excavacio_afegida = Excavacio::create($request->all());

        return redirect()
                        ->route('app.excavacio.all', $excavacio_afegida->id)
                        ->with('message', __('Excavació afegida'));
    }

    public function show($id) {
//        $excavacio = Excavacio::find($id);
//        $sectors = Sector::all()->where('excavacio_id', $id);
//        return view('app.excavacio.show', compact('id', 'excavacio', 'sectors'));
        return $id;
    }

    public function edit($id) {
        $excavacio = Excavacio::find($id);
        return view('app.excavacio.edit', compact('id', 'excavacio'));
    }

    public function update(Request $request, $id) {

        $validator = Validator::make($request->all(), [
                    'codi' => [
                        'required',
                        'max:20',
                        Rule::unique('excavacions')->ignore($id),
                    ],
                    'nom' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                            ->route('excavacio.edit', [$id])
                            ->withErrors($validator)
                            ->withInput();
        }

        $excavacio = Excavacio::findOrFail($id);
        $excavacio->update($request->all());

        return redirect()
                        ->route('app.excavacio.all')
                        ->with('message', __('Excavació editada'));
    }

    public function destroy($id) {
        $excavacio = Excavacio::findOrFail($id);
        $excavacio->delete();

        return redirect()
                        ->route('app.excavacio.all', $excavacio->id)
                        ->with('message', __('Excavació esborrada'));
    }

}
