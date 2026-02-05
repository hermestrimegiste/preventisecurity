<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    protected $fillable = [
        'assessment_id',
        'domain',
        'score_0_100',
        'maturity_0_5',
        'weights_version',
    ];

   // Relationships
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    // Helpers
    public function getMaturityLabel(): string
    {
        return match($this->maturity_0_5) {
            0 => 'Non défini',
            1 => 'Initial',
            2 => 'Géré',
            3 => 'Défini',
            4 => 'Quantitatif',
            5 => 'Optimisé',
            default => 'Inconnu',
        };
    }

    public function getRiskLevel(): string
    {
        return match(true) {
            $this->score_0_100 < 40 => 'Faible',
            $this->score_0_100 < 70 => 'Moyen',
            $this->score_0_100 < 85 => 'Bon',
            default => 'Avancé',
        };
    }

    public function getRiskColor(): string
    {
        return match(true) {
            $this->score_0_100 < 40 => 'red',
            $this->score_0_100 < 70 => 'orange',
            $this->score_0_100 < 85 => 'yellow',
            default => 'green',
        };
    }
}
