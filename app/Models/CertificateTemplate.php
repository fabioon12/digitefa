<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CertificateTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'nomor_surat_format',
        'background_image',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function indicators()
    {
        return $this->hasMany(TemplateIndicator::class, 'certificate_template_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'certificate_template_id');
    }
}
