<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
			$table->year('year');							/* 学年 */
			$table->enum('term', ['春', '夏', '秋', '冬']);	/* 学期 */
            $table->string('student_number', 12)->nullable(false);			/* 学号 */
			$table->string('course_number', 10)->nullable(false);			/* 课程号 */
			$table->unsignedTinyInteger('course_id')->nullable(false);		/* 课序号 */
			$table->decimal('class_performance', 5, 2);		/* 平时分 */
			$table->decimal('middle_exam', 5, 2);			/* 期中 */
			$table->decimal('final_exam', 5, 2);			/* 期末 */
			$table->decimal('total_score', 5, 2);			/* 总评 */
			$table->decimal('gpa', 3, 2);					/* 绩点 */
			$table->boolean('passed');						/* 及格标志 */
			
			$table->primary(array('student_number', 'course_number', 'course_id'));	/* 以学号、课程号与课序号作为复合主键 */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scores');
    }
}
