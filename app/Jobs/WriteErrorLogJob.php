<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Schema;

class WriteErrorLogJob implements ShouldQueue
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
        $tableName = 'error_log_' . now()->format('Ymd');
        if( !Redis::get( $tableName, $tableName ) )
        {
            if ( !Schema::hasTable( $tableName ) )
            {
                Schema::create( $tableName, function ($table) {
                    $table->id();
                    $table->string('error_code',25);
                    $table->text('error_message');
                    $table->timestamps();
                });
            }
            Redis::set( $tableName, $tableName);
            Redis::expire($tableName, 86400);
        }

        DB::table($tableName)->insert($this->data);
    }
}
