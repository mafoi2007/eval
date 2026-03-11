<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_id',
        'position',
        'type',
        'intitule',
        'choix_a',
        'choix_b',
        'choix_c',
        'choix_d',
        'bonne_reponse',
        'points',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
}