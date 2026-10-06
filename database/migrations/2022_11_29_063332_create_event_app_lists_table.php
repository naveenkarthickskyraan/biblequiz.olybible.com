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
        Schema::create('event_app_lists', function (Blueprint $table) {
            $table->id();
            $table->string('app_name');
            $table->text('app_description');
            $table->string('app_image');
            $table->string('image_type');
            $table->boolean('is_active');
            $table->string('deleted_at')->default(0);
            // $table->softDeletes();
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
        Schema::dropIfExists('event_app_lists');
    }
};
