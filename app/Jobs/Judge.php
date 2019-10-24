<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\StudentAnswer;

class Judge implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $s_id,$exam_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($s_id,$exam_id)
    {
        $this ->s_id = $s_id;
        $this ->exam_id = $exam_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        StudentAnswer::judgeask($this ->s_id,$this ->exam_id);
    }
}
