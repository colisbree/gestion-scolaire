<?php

namespace App\Http\Controllers;

use App\Models\NiveauScolaire;
use Illuminate\Http\Request;

class NiveauScolaireController extends Controller
{
    public function index() {
        $niveauScolaires = NiveauScolaire::latest()->paginate(5); //paginate renvoie une collection/objet
        return inertia("NiveauScolaire/IndexNiveauScolaire", [
            "niveauScolaires" => $niveauScolaires
        ]);
    }

    public function store(Request $request) {
        $request->validate(["nom"=>"required|unique:App\\Models\NiveauScolaire"]);

        NiveauScolaire::create(["nom"=>$request->nom]);
        
        return redirect()->back();
    }

    public function edit(NiveauScolaire $niveauScolaire){
        return response()->json(["niveauScolaire" => $niveauScolaire]);
    }
}
