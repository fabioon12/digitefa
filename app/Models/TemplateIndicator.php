<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemplateIndicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_template_id',
        'indikator',
    ];


    public function template()
    {
        return $this->belongsTo(CertificateTemplate::class, 'certificate_template_id');
    }
}
