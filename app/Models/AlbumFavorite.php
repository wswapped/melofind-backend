<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlbumFavorite extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'artist',
        'url',
        'image',
        'mbid',
        'listeners',
        'playcount',
        'tags',
        'tracks',
        'created_by'
    ];

    protected $casts = [
        'image' => 'array',
        'tags' => 'array',
        'tracks' => 'array',
    ];
}
