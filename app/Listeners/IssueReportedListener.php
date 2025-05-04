<?php

namespace App\Listeners;

use App\Events\IssueReported;
use App\Mail\SendIssueReported;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class IssueReportedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(IssueReported $event): void
    {
        Mail::to($event->email)->send(new SendIssueReported($event->emailData));
    }
}
