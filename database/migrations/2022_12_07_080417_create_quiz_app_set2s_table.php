<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_app_set2s', function (Blueprint $table) {
            $table->id();
            $table->string('app_name');
            $table->text('app_description');
            $table->string('app_image');
            $table->string('image_type')->default(0);
            $table->boolean('is_active')->default(0);
            $table->string('deleted_at')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_app_set2s');
    }
};
