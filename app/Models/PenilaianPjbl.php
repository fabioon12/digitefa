<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianPjbl extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'guru_id',
        'status',
        'nilai',
        'catatan',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function penilaianPjbl()
    {
        return $this->hasOne(PenilaianPjbl::class, 'project_id');
    }
    public function mentor()
    {
        return $this->belongsTo(ProjectMentor::class, 'project_mentor_id');
    }
}
