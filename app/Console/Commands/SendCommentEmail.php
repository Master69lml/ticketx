<?php

namespace App\Console\Commands;

use App\Comment;
use App\Mailers\AppMailer;
use App\Ticket;
use App\User;
use Illuminate\Console\Command;

class SendCommentEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:comment-email {userId} {ticketId} {commentId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send comment email notification';

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
            $commentId = $this->argument('commentId');

            $user = User::find($userId);
            $ticket = Ticket::find($ticketId);
            $comment = Comment::find($commentId);

            if (!$user || !$ticket || !$comment) {
                $this->error('Usuario, ticket o comentario no encontrado');
                return false;
            }

            // Solo enviar si el comentario no es del propietario del ticket
            if ($ticket->user->id !== $user->id) {
                $mailer->sendTicketComments($ticket->user, $user, $ticket, $comment);
            }

            $this->info('Correo de comentario enviado correctamente para ticket #' . $ticket->ticket_id);

            return true;
        } catch (\Exception $e) {
            $this->error('Error al enviar correo de comentario: ' . $e->getMessage());
            return false;
        }
    }
}
