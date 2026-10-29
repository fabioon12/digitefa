<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMentor extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'tipe',
        'status',
        'catatan_revisi',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function penilaians()
    {
        return $this->hasMany(PenilaianPjbl::class, 'project_mentor_id');
    }

}
