<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Mailers\AppMailer;
use App\Ticket;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTicketEmails extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $ticket;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Ticket $ticket)
    {
        $this->user = $user;
        $this->ticket = $ticket;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(AppMailer $mailer)
    {
        $mailer->sendTicketInformation($this->user, $this->ticket);
    }
}
