<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\NiveauScolaire;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $niveauScolaires = NiveauScolaire::all();

        return inertia("Etudiant/CreateEtudiant", [
            "niveauScolaires"=> $niveauScolaires,
        ]);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            "nom"=> "required",
            "prenom"=> "required",
            "age"=> "required",
            "sexe"=> "required",
            "niveauScolaire"=> "required|exists:niveau_scolaires,id",
        ]);

        try{
            DB::beginTransaction(); // permet d'exécuter les requêtes sans envoi à la BDD
            $etudiant = Etudiant::create([...$validatedData, "niveau_scolaire_id" => $request->niveauScolaire]);

            if ($request->hasFile("photo")){
                $photo = $request->photo;
                $name = $etudiant->nom." ".$etudiant->prenom;
                $fileName = str_replace(" ", "-", $name);
                $filePath = $photo->storeAs("photos", $fileName, "public"); 
                // ici public fait appel au fichier 'app/config/filesystems.php' puis au disk > public
                // le fichier est donc enregistré dans le dossier 'app/public/photos'
                $etudiant->photo = $filePath;
                $etudiant->save();
            }
            DB::commit(); // Envoi le résultat des requêtes à la BDD s'il n'y a pas eu d'erreur
        }
        catch(Exception $e){
            DB::rollBack(); // fonction exécutée en cas d'erreur (annulation des requêtes précédentes)
        }

        return redirect()->back();
    }

    public function edit(Etudiant $etudiant) {
        $niveauScolaires = NiveauScolaire::all();
       
        return inertia("Etudiant/EditEtudiant", [
            "niveauScolaires"=> $niveauScolaires,
            "etudiant"=> $etudiant,
        ]);
    }

    public function update(Request $request, Etudiant $etudiant) {
        
        $validatedData = $request->validate([
            "nom"=> "required",
            "prenom"=> "required",
            "age"=> "required",
            "sexe"=> "required",
            "niveauScolaire"=> "required|exists:niveau_scolaires,id",
        ]);

        try{
            DB::beginTransaction(); // permet d'exécuter les requêtes sans envoi à la BDD
            $etudiant->update([...$validatedData, "niveau_scolaire_id" => $request->niveauScolaire]);

            if ($request->hasFile("photo")){
                // suppression de l'ancienne photo
                if(Storage::exists($etudiant->photo)){
                    Storage::delete($etudiant->photo);
                }

                // nouvelle photo
                $photo = $request->photo;
                $name = $etudiant->nom." ".$etudiant->prenom;
                $fileName = str_replace(" ", "-", $name);
                $filePath = $photo->storeAs("photos", $fileName, "public"); 
                // ici public fait appel au fichier 'app/config/filesystems.php' puis au disk > public
                // le fichier est donc enregistré dans le dossier 'app/public/photos'
                $etudiant->photo = $filePath;
                $etudiant->save();
            }
            DB::commit(); // Envoi le résultat des requêtes à la BDD s'il n'y a pas eu d'erreur
        }
        catch(Exception $e){
            DB::rollBack(); // fonction exécutée en cas d'erreur (annulation des requêtes précédentes)
        }

        return redirect()->back();        
    }

    public function delete(Etudiant $etudiant){

        if($etudiant->photo){
            if(Storage::exists($etudiant->photo)){
                Storage::delete($etudiant->photo);
            }
        }

        $etudiant->delete();
        return redirect()->back();  
    }
}
