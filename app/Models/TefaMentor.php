<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TefaMentor extends Model
{
    protected $fillable = [
        'tefa_id',
        'user_id',
        'tipe',
        'status',
        'catatan_revisi',
    ];

    public function tefa()
    {
        return $this->belongsTo(tefa::class, 'tefa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
