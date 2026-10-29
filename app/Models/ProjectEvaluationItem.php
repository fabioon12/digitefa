<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectEvaluationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_evaluation_id',
        'indikator',
        'is_achieved'
    ];

    protected $casts = [
        'is_achieved' => 'boolean',
    ];

    public function evaluation()
    {
        return $this->belongsTo(ProjectEvaluation::class, 'project_evaluation_id');
    }
}
