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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->string('event_description');
            $table->string('event_short_description');
            $table->string('event_time');
            $table->string('event_date');
            $table->text('event_address');
            $table->string('event_landmark');
            $table->string('event_district');
            $table->string('event_country');
            $table->string('event_state');
            $table->string('event_pincode');
            $table->double('longitude');
            $table->double('latitude');
            $table->string('event_url');
            $table->string('event_image');
            $table->boolean('image_type')->default(0);
            $table->string('event_video');
            $table->string('video_upload_type');
            $table->string('thumb_image');
            $table->boolean('thumb_upload_type');
            $table->string('category_id');
            $table->string('sub_category_id');
            $table->string('admin_id');
            $table->string('deleted_at')->default('0');
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
        Schema::dropIfExists('events');
    }
};
