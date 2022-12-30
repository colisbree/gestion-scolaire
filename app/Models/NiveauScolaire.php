<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NiveauScolaire extends Model
{
    use HasFactory;

    protected $fillable = ["nom"];
    
    //relation
    public function etudiants() {
        return $this->HasMany(Etudiant::class);
    } 
}
