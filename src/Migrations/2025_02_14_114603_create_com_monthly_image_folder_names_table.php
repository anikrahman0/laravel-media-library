<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComMonthlyImageFolderNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('com_monthly_image_folder_names', function (Blueprint $table) {
            $table->bigIncrements('FolderId');
            $table->string('FolderName',30)->unique();
            $table->string('ImageFolderName',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('com_monthly_image_folder_names');
    }
}
