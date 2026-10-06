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
        Schema::create('quiz_category_set3s', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->text('category_description');
            $table->string('category_image');
            $table->string('image_type');
            $table->boolean('is_active');
            $table->string('deleted_at')->default(0);
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
        Schema::dropIfExists('quiz_category_set3s');
    }
};
