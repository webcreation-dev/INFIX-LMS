<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAboutTableTranslateable extends Migration
{

    public function up()
    {

        Schema::table('about_pages', function($table){
            $table->longText("who_we_are")->nullable()->change();
            $table->longText("banner_title")->nullable()->change();
            $table->longText("story_title")->nullable()->change();
            $table->longText("story_description")->nullable()->change();
            $table->longText("total_teacher")->nullable()->change();
            $table->longText("teacher_title")->nullable()->change();
            $table->longText("teacher_details")->nullable()->change();
            $table->longText("total_student")->nullable()->change();
            $table->longText("student_title")->nullable()->change();
            $table->longText("student_details")->nullable()->change();
            $table->longText("total_courses")->nullable()->change();
            $table->longText("course_title")->nullable()->change();
            $table->longText("course_details")->nullable()->change();
            $table->longText("about_page_content_title")->nullable()->change();
            $table->longText("about_page_content_details")->nullable()->change();
            $table->longText("live_class_title")->nullable()->change();
            $table->longText("live_class_details")->nullable()->change();
            $table->longText("sponsor_title")->nullable()->change();
            $table->longText("sponsor_sub_title")->nullable()->change();
        });

//        DB::statement('ALTER TABLE `about_pages`
//    CHANGE `who_we_are` `who_we_are` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `banner_title` `banner_title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `story_title` `story_title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `story_description` `story_description` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `total_teacher` `total_teacher` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `teacher_title` `teacher_title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `teacher_details` `teacher_details` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `total_student` `total_student` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `student_title` `student_title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `student_details` `student_details` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `total_courses` `total_courses` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `course_title` `course_title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `course_details` `course_details` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `about_page_content_title` `about_page_content_title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `about_page_content_details` `about_page_content_details` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `live_class_title` `live_class_title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `live_class_details` `live_class_details` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `sponsor_title` `sponsor_title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `sponsor_sub_title` `sponsor_sub_title` LONGTEXT  NULL DEFAULT NULL;
//
//    ');

        $lang_code = 'en';
        $table_name = 'about_pages';


        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {

            $columns = [
                'who_we_are',
                'banner_title',
                'story_title',
                'story_description',
                'total_teacher',
                'teacher_title',
                'teacher_details',
                'total_student',
                'student_title',
                'student_details',
                'total_courses',
                'course_title',
                'course_details',
                'about_page_content_title',
                'about_page_content_details',
                'live_class_title',
                'live_class_details',
                'sponsor_title',
                'sponsor_sub_title',
            ];

            foreach ($columns as $column) {
                $pos = strpos($row->$column, '{"');
                if ($pos === false) {
                    DB::table($table_name)->where('id', $row->id)->update([
                        $column => '{"' . $lang_code . '":"' . $row->$column . '"}',
                    ]);
                }
            }



        }
    }


    public function down()
    {
        //
    }
}
