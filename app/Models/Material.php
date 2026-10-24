<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    public function getVideoMimeTypeAttribute(): string
    {
        return match (strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION))) {
            'webm' => 'video/webm',
            'ogv' => 'video/ogg',
            default => 'video/mp4',
        };
    }

    protected $fillable = [
        'title',
        'department',
        'type',
        'description',
        'file_path',
    ];
}