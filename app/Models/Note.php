<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['eleve_id', 'evaluation_id', 'contenu', 'reponses', 'valeur'];

    protected $casts = [
        'reponses' => 'array',
    ];

    
    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
}
