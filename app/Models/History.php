<?php

// app/Models/History.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $primaryKey = 'history_id';
    protected $fillable = ['user_id', 'action', 'model_type', 'model_id', 'details'];
    public $timestamps = false; 

    protected $casts = [
        'details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}