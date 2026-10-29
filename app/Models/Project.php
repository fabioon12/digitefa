<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Project extends Model
{
use HasFactory;

    protected $fillable = [
        'user_id',
        'tipe',
        'judul',
        'deskripsi',
        'kategori',
        'tanggal_mulai',   
        'tanggal_selesai',
        'proposal_path',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'pembimbing'      => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members()
    {
        return $this->hasMany(ProjectMember::class, 'project_id');
    }
    public function mentors()
    {
        return $this->belongsToMany(User::class, 'project_mentors', 'project_id', 'user_id')
                    ->withPivot('tipe', 'status', 'catatan_revisi')
                    ->withTimestamps();
    }

    public function scopeReadyForGuru($query)
    {
        $guruId = Auth::id();

        // Mengambil proyek di mana ID guru logged-in tercatat di tabel pivot
        return $query->whereHas('mentors', function ($q) use ($guruId) {
            $q->where('user_id', $guruId);
        });
    }
    
    public function milestones()
    {
        return $this->hasMany(ProjectMilestone::class, 'project_id');
    }

    public function leader()
    {
        return $this->hasOne(ProjectMember::class, 'project_id')->where('is_leader', true);
    }
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
    /* Project Task */
    public function tasks(): HasMany
    {
        return $this->hasMany(ProjectTask::class, 'project_id');
    }

    // Relasi direct ke User mentor
    public function mentorUsers()
    {
        return $this->belongsToMany(User::class, 'project_mentors')
                    ->withPivot('tipe', 'status', 'catatan_revisi')
                    ->withTimestamps();
    }
    public function evaluations()
    {
        return $this->hasMany(ProjectEvaluation::class, 'project_id');
    }

}
