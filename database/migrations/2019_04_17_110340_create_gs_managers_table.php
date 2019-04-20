<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGsManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_managers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname')
                ->nullable(false)
                ->default('')
                ->comment('管理员名称');
            $table->string('account')
                ->nullable(false)
                ->default('')
                ->comment('账号')
                ->unique();
            $table->string('password')
                ->nullable(false)
                ->default('')
                ->comment('密码');
            $table->char('phone', 20)
                ->nullable(false)
                ->default('')
                ->comment('手机号')
                ->index();
            $table->string('email', 100)
                ->nullable(false)
                ->default('')
                ->comment('邮箱')
                ->index();
            $table->string('login_ip')
                ->nullable(true)
                ->default('')
                ->comment('登录IP');
            $table->timestamp('login_time')
                ->nullable(true)
                ->comment('登录时间');
            $table->unsignedTinyInteger('is_del')
                ->nullable(false)
                ->default(0)
                ->comment('0:正常,1:删除');
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
        Schema::dropIfExists('gs_managers');
    }
}
