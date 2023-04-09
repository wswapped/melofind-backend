<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('album_favorites', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("artist", 512);
            $table->string("url", 128);
            $table->json("image")->commment("json array of images");
            $table->string("mbid", 64)->nullable();
            $table->integer("listeners");
            $table->integer("playcount");
            $table->json("tags")->nullable();
            $table->json("tracks")->nullable();
            $table->foreignId("created_by")->constrained("users");
            // $table->unique(["created_by", "mbid", "name", "artist", "deleted_at"], 'unique_album_per_user');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_favorites');
    }
};
