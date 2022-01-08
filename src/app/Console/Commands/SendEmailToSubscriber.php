<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Post;
use App\Models\User;
use App\Mail\PostPublished;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\PostEmailNotification;

class SendEmailToSubscriber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send {user} {post}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send post email to website subscriber';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::find($this->argument('user'));
        $post = Post::find($this->argument('post'));
        $email_notification = PostEmailNotification::where(
            [
                'post_id' => $post->id,
                'user_id' => $user->id
            ]
        )->first();

        if (!empty($user) && !empty($post) && !$email_notification->sent) {
            try {
                Mail::to($user->email)->send(new PostPublished($post));
                $email_notification->sent = true;
                $email_notification->save();
            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
            }
        }
    }
}
