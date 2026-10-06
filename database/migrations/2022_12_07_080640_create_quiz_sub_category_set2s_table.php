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
        Schema::create('quiz_sub_category_set2s', function (Blueprint $table) {
            $table->id();
            $table->string('sub_category_name');
            $table->text('sub_category_description');
            $table->string('sub_category_image');
            $table->string('image_type');
            $table->string('category_id');
            $table->boolean('is_active')->default(0);
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
        Schema::dropIfExists('quiz_sub_category_set2s');
    }
};
