<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTask extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     */
    protected $table = 'project_tasks';
    

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignable).
     */
    protected $fillable = [
        'project_id',
        'judul_tugas',
        'deskripsi',
        'assigned_to',
        'status',
        'priority',
        'deadline',
    ];

    /**
     * Casting tipe data otomatis.
     */
    protected $casts = [
        'deadline' => 'date',
    ];

    /**
     * Relasi ke Proyek induknya.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Relasi ke User / Siswa yang ditugaskan.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function progresses()
    {
        return $this->hasMany(TaskModel::class, 'task_id')->latest();
    }
    public function submissions()
    {
        return $this->hasMany(TaskModel::class, 'task_id');
    }

    // Relasi helper untuk mengambil pengumpulan/progres terakhir
    public function latestSubmission()
    {
        return $this->hasOne(TaskModel::class, 'task_id')->latestOfMany();
    }


}
