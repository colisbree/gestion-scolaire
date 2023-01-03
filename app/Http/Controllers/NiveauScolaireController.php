<?php

namespace App\Http\Controllers;

use App\Models\NiveauScolaire;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;

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

    public function update(Request $request, NiveauScolaire $niveauScolaire){
        $request->validate([
            "nom"=>[
                "required",
                Rule::unique((new NiveauScolaire)->getTable(), "nom")->ignore($niveauScolaire->id)
                
            ]
        ]);
        if($request->nom != $niveauScolaire->nom){
            $niveauScolaire->nom = $request->nom;
            $niveauScolaire->save();
        }
        return redirect()->back();
    }

    public function delete(NiveauScolaire $niveauScolaire) {
        if(count($niveauScolaire->etudiants)>0){
            return redirect()->back()->withErrors([
                "message" => "Ce niveau scolaire ne peut être supprimé car il existe des étudiants qui dépendent de ce dernier."
            ]);
        }
        $niveauScolaire->delete();
        return redirect()->back();
    }
}
