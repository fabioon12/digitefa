<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'nama_siswa',
        'peran',
        'is_leader',
        'status'
    ];

/*     public function project()
    {
        return $this->belongsTo(Project::class);
    } */
       /**
     * Reverse the migrations.
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function leader()
    {
        return $this->hasOne(ProjectMember::class, 'project_id', 'project_id')
                    ->where('is_leader', 1);
    }
    protected $casts = [
        'is_leader' => 'boolean',
    ];



}
