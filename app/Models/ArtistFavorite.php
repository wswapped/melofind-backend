<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArtistFavorite extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'url',
        'bio',
        'image',
        'mbid',
        'similar',
        'stats',
        'tags',
        'streamable',
        'created_by'
    ];
    protected $casts = [
        'image' => 'array',
        'bio' => 'array',
        'similar' => 'array',
        'stats' => 'array',
        'tags' => 'array',
    ];
}
