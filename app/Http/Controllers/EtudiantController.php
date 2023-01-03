<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\NiveauScolaire;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function index(Request $request) {
        // récupération des paramètres de la page indexEtudiant via inertia et via GET
        $search = $request->search;
        $filter = $request->filter;
        $per_page = $request->per_page;
        // fin récupération

        $etudiants = Etudiant::with("niveau_scolaire")
            ->when($search !="", function($query) use($search){
                $query->where("nom", "like", "%{$search}%");
                $query->orWhere("prenom", "like", "%{$search}%");
            })
            ->when($filter !="", function($query) use($filter){
                $query->where("niveau_scolaire_id", $filter);
            })
            ->latest()
            ->paginate($per_page ?? 5); // si per_page = "" alors on pagine à 5

        $niveauScolaires = NiveauScolaire::all();

        return inertia("Etudiant/IndexEtudiant", [
            "etudiants"=> $etudiants,
            "niveauScolaires"=> $niveauScolaires,
            "filters"=> $request->all("search", "filter", "per_page")  // envoi un objet
        ]);
    }

    public function create() {
        return inertia("Etudiant/CreateEtudiant");
    }

    public function edit() {
        return inertia("Etudiant/EditEtudiant");
    }
}
