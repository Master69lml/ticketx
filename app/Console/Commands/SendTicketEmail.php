<?php

namespace App\Console\Commands;

use App\Mailers\AppMailer;
use App\Ticket;
use App\User;
use Illuminate\Console\Command;

class SendTicketEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:ticket-email {userId} {ticketId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send ticket email confirmation';

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
     * @return mixed
     */
    public function handle(AppMailer $mailer)
    {
        try {
            $userId = $this->argument('userId');
            $ticketId = $this->argument('ticketId');

            $user = User::find($userId);
            $ticket = Ticket::find($ticketId);

            if (!$user || !$ticket) {
                $this->error('Usuario o ticket no encontrado');
                return false;
            }

            $mailer->sendTicketInformation($user, $ticket);
            $this->info('Correo enviado correctamente para ticket #' . $ticket->ticket_id);

            return true;
        } catch (\Exception $e) {
            $this->error('Error al enviar correo: ' . $e->getMessage());
            return false;
        }
    }
}
