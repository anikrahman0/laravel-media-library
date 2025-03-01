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
        Schema::create('image_archives', function (Blueprint $table) {
            $table->bigIncrements('ImgArchiveID');
            $table->string('ImageFileName')->nullable();
            $table->string('ImagePath')->nullable();
            $table->string('ImageSmPath')->nullable();
            $table->string('ImageThumbPath')->nullable();
            $table->text('HeadCaption')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('image_archives');
    }
};
