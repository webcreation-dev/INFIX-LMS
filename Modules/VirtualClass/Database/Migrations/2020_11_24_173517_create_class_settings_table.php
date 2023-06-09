<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\VirtualClass\Entities\ClassSetting;

class CreateClassSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('default_class')->default(0)->comment('0 => Zoom 1 => BBB');
            $table->timestamps();
        });

        ClassSetting::create([
            'default_class' => 0
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_settings');
    }
}
