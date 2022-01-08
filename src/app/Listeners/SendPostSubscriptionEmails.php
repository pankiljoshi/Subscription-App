<?php

namespace App\Listeners;

use App\Models\Website;
use App\Events\PostPublished;
use App\Models\PostEmailNotification;
use App\Jobs\ProcessSendingSubscriptionPostEmails;

class SendPostSubscriptionEmails
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PostPublished $event)
    {
        $website_subscribers = Website::find($event->post->website_id)->subscribers;
        if (!empty($website_subscribers)) {
            foreach ($website_subscribers as $subscriber) {
                PostEmailNotification::create(
                    [
                        'post_id' => $event->post->id,
                        'user_id' => $subscriber->id,
                        'sent' => false
                    ]
                );
                ProcessSendingSubscriptionPostEmails::dispatch($event->post->id, $subscriber->id)->onQueue('subscription_emails');;
            }
        }
    }
}
