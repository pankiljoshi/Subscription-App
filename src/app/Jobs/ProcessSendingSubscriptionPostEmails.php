<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessSendingSubscriptionPostEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post_id;

    protected $user_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $post_id, int $user_id)
    {
        $this->post_id = $post_id;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('mail:send', [
            'user' => $this->user_id,
            'post' => $this->post_id
        ]);
    }
}
