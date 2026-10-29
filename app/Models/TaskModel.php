<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskModel extends Model
{
    use HasFactory;

    
    protected $table = 'task_models';

    protected $fillable = [
        'task_id',
        'user_id',
        'catatan',
        'link_lampiran',
        'file_berkas',
        'catatan_guru',
    ];

    protected $casts = [
        'catatan_guru' => 'array',
    ];
    /**
     * Relasi ke model ProjectTask (Tugas Utama)
     */
    public function task()
    {
        return $this->belongsTo(ProjectTask::class, 'task_id');
    }

    /**
     * Relasi ke model User (Siswa Pengunggah Progres)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
