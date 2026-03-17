<?php

namespace App\Mailers;

use App\Status;
use App\Ticket;
use Illuminate\Contracts\Mail\Mailer;

class AppMailer
{
    protected $mailer;

    /**
     * email to send to.
     *
     * @var [type]
     */
    protected $to;

    /**
     * Subject of the email.
     *
     * @var [type]
     */
    protected $subject;

    /**
     * view template for email.
     *
     * @var [type]
     */
    protected $view;

    /**
     * data to be sent alone email.
     *
     * @var array
     */
    protected $data = [];

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send Ticket information to user.
     *
     * @param User   $user
     * @param Ticket $ticket
     *
     * @return method deliver()
     */
    public function sendTicketInformation($user, Ticket $ticket)
    {
        $statuses = Status::all();
        $this->to = $user->email;
        $this->subject = "[Ticket ID: $ticket->ticket_id] $ticket->title";
        $this->view = 'emails.ticket_info';
        $this->data = compact('user', 'ticket', 'statuses');

        $this->deliver();

        // Notify support team
        return $this->sendTicketToSupportTeam($user, $ticket);
    }

    /**
     * Send Ticket notification to support team.
     *
     * @param User   $user
     * @param Ticket $ticket
     *
     * @return method deliver()
     */
    public function sendTicketToSupportTeam($user, Ticket $ticket)
    {
        $statuses = Status::all();
        
        // Obtener los correos del equipo de soporte desde .env
        $supportEmails = $this->getSupportTeamEmails();
        
        if (empty($supportEmails)) {
            return false;
        }
        
        $this->subject = "[Nuevo Ticket ID: $ticket->ticket_id] $ticket->title";
        $this->view = 'emails.ticket_support';
        $this->data = compact('user', 'ticket', 'statuses');

        // Enviar UN solo correo con todos los destinatarios
        try {
            $this->mailer->send($this->view, $this->data, function ($message) use ($supportEmails) {
                $message->from(email_from(), site_name())
                        ->to($supportEmails)
                        ->subject($this->subject);
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }

    /**
     * Get support team emails from .env configuration.
     *
     * @return array
     */
    protected function getSupportTeamEmails()
    {
        $emails = env('SUPPORT_TEAM_EMAILS', '');
        
        if (empty($emails)) {
            return [];
        }
        
        // Convertir string separado por comas en array y limpiar espacios
        return array_map('trim', explode(',', $emails));
    }

    /**
     * Send Ticket Comments/Replies to Ticket Owner.
     *
     * @param User    $ticketOwner
     * @param User    $user
     * @param Ticket  $ticket
     * @param Comment $comment
     *
     * @return method deliver()
     */
    public function sendTicketComments($ticketOwner, $user, Ticket $ticket, $comment)
    {
        $this->to = $ticketOwner->email;
        $this->subject = "RE:[Ticket ID: $ticket->ticket_id] $ticket->title";
        $this->view = 'emails.ticket_comments';
        $this->data = compact('ticketOwner', 'user', 'ticket', 'comment');

        return $this->deliver();
    }

    /**
     * Send ticket status notification.
     *
     * @param User   $ticketOwner
     * @param Ticket $ticket
     *
     * @return method deliver()
     */
    public function sendTicketStatusNotification($ticketOwner, Ticket $ticket)
    {
        $this->to = $ticketOwner->email;
        $this->subject = "RE:[Ticket ID: $ticket->ticket_id] $ticket->title";
        $this->view = 'emails.ticket_status';
        $this->data = compact('ticketOwner', 'ticket');

        return $this->deliver();
    }

    /**
     * Do the actual sending of the mail.
     */
    public function deliver()
    {
        $this->mailer->send($this->view, $this->data, function ($message) {
            $message->from(email_from(), site_name())
                    ->to($this->to)->subject($this->subject);
        });
    }
}
