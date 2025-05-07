<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\IssueReported;
use App\Mail\SendIssueReported;
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
    public function handle(IssueReported $issueReported): void
    {
        Mail::to($issueReported->email)->send(new SendIssueReported($issueReported->emailData));
    }
}
