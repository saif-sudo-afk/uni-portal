<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'semester',
        'major',
        'title',
        'original_name',
        'file_path',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
