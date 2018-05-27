<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->text('body')->comment('内容');
            $table->integer('user_id')->comment('用户ID')->unsigned();
            $table->integer('comments_count')->comment('评论数')->default(0);
            $table->integer('followers_count')->comment('关注数')->default(1);
            $table->integer('anwers_count')->comment('回答数')->default(0);
            $table->string('close_comment',8)->comment('是否关闭评论')->default('F');
            $table->string('is_hidden',8)->comment('是否隐藏')->default('F');
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
        Schema::dropIfExists('questions');
    }
}
