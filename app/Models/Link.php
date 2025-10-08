<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_id',
        'custom_link',
        'expiration_date',
        'access_count',
        'is_active',
    ];

    protected $casts = [
        'expiration_date' => 'datetime',
        'is_active' => 'boolean',
        'access_count' => 'integer',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function isExpired()
    {
        return $this->expiration_date && $this->expiration_date->isPast();
    }

    public function isAccessible()
    {
        return $this->is_active && !$this->isExpired();
    }
}
