<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
			$table->text('academy');					/* 开课院系 */
            $table->string('course_number', 10);		/* 课程号 */
			$table->unsignedTinyInteger('course_id');	/* 课序号 */
			$table->text('course_name');				/* 课程名 */
			$table->decimal('credits', 2, 1);			/* 学分 */
			$table->unsignedTinyInteger('period');		/* 学时 */
			$table->text('type');						/* 选课属性 */
			
			$table->primary(array('course_number', 'course_id'));	/* 以课程号与课序号作为复合主键 */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
