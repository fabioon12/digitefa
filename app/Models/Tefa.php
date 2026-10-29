<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tefa extends Model
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
        return $this->hasMany(TefaMember::class, 'tefa_id');
    }
    public function mentors()
    {
        return $this->belongsToMany(User::class, 'tefa_mentors', 'tefa_id', 'user_id')
                    ->withPivot('tipe', 'status', 'catatan_revisi')
                    ->withTimestamps();
    }
        public function leader()
    {
        return $this->hasOne(TefaMember::class, 'tefa_id')->where('is_leader', true);
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
    public function mentorRecords()
    {
        return $this->hasMany(TefaMentor::class, 'tefa_id');
    }

}
