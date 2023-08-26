<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Schema;

class WriteRequestLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data = [];

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tableName = 'system_log_' . now()->format('Ymd');

        if (!Redis::get($tableName)) {
            if (!Schema::hasTable($tableName)) {
                Schema::create($tableName, function ($table) {
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
            Redis::set($tableName, $tableName);
            Redis::expire($tableName, 86400);
        }
        //将请求信息存储到数据库
        DB::table($tableName)->insert($this->data);
    }
}
