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
        Schema::create('artist_favorites', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("url", 128);
            $table->json("image")->commment("json array of images");
            $table->json("bio")->nullable();
            $table->string("mbid", 64)->nullable();
            $table->json("similar");
            $table->json("stats");
            $table->json("tags")->nullable();
            $table->boolean("streamable")->default(0);
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
        Schema::dropIfExists('artist_favorites');
    }
};
