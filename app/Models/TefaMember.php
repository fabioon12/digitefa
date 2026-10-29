<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TefaMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'tefa_id',
        'user_id',
        'nama_siswa',
        'peran',
        'is_leader',
        'status'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function tefa()
    {
        return $this->belongsTo(Tefa::class, 'tefa_id', 'id');
    }
    public function leader()
    {
        return $this->hasOne(TefaMember::class, 'tefa_id', 'tefa_id')
                    ->where('is_leader', 1);
    }
    protected $casts = [
        'is_leader' => 'boolean',
    ];

}
