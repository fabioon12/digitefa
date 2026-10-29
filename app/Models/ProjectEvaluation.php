<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'student_id',
        'evaluator_id',
        'status_kompetensi',
        'nilai_akhir',
        'catatan_guru'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    public function items()
    {
        return $this->hasMany(ProjectEvaluationItem::class, 'project_evaluation_id');
    }
}
