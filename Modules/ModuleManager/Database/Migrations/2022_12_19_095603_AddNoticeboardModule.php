<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\ModuleManager\Entities\Module;

class AddNoticeboardModule extends Migration
{
    public function up()
    {
        $totalCount = DB::table('modules')->count();

        $newModule = new Module();
        $newModule->name = 'Noticeboard';
        $newModule->details = 'Noticeboard Module For InfixLMS.';
        $newModule->status = 0;
        $newModule->order = $totalCount;
        $newModule->save();
    }

    public function down()
    {
        //
    }
}
