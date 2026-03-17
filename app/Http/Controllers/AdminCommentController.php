<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminCommentController extends Controller
{
    public function postComment(Request $request)
    {
        $this->validate($request, [
                'comment'   => 'required',
            ]);

        $comment = Comment::create([
                    'ticket_id' => $request->input('ticket_id'),
                    'user_id'   => Auth::user()->id,
                    'comment'   => $request->input('comment'),
                ]);

        // Enviar correos en background sin bloquear la respuesta
        if ($comment->ticket->user->id !== Auth::user()->id) {
            $userId = Auth::user()->id;
            $ticketId = $comment->ticket->id;
            $commentId = $comment->id;

            $phpBin = defined('PHP_BINARY') ? PHP_BINARY : 'php7.4';
            $artisan = base_path() . '/artisan';
            $cmd = escapeshellcmd($phpBin) . ' ' . escapeshellarg($artisan) . " send:comment-email $userId $ticketId $commentId > /dev/null 2>&1 &";

            if (!function_exists('exec')) {
                Log::error('exec() no está disponible en este entorno. Comando pendiente: ' . $cmd);
            } else {
                exec($cmd, $output, $returnVar);
                Log::info('send:comment-email ejecutado', ['cmd' => $cmd, 'return' => $returnVar, 'output' => $output]);
            }
        }

        return redirect()->back()->with('success', 'Your comment has be submitted.');
    }
}
