<?php

// app/Models/KpiBehavior.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiBehavior extends Model
{
    protected $primaryKey = 'perilaku_id';
    protected $fillable = ['kpi_id', 'kategori', 'score', 'deskripsi'];

    protected $casts = [
        'score' => 'integer',
    ];

    public function kpi()
    {
        return $this->belongsTo(Kpi::class, 'kpi_id', 'kpi_id');
    }
}