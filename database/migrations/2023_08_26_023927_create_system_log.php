<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_log', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id',false)->default(0)->comment('用户ID');
            $table->string('path',50)->comment('请求路由地址');
            $table->string('method',50)->comment('请求方式');
            $table->string('ip',100)->comment('用户IP地址');
            $table->text('content')->comment('请求内容');
            $table->decimal('response_time', 18, 15)->comment('响应时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_log');
    }
};
