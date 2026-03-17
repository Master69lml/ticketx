<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comments;
use App\Mailers\AppMailer;
use App\Priority;
use App\Status;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $categories = Category::all();
        $prioritys = Priority::all();
        $statuses = Status::all();
        $companies = Auth::user()->companies;

        return view('tickets.create', compact('categories', 'statuses', 'prioritys', 'companies'));
    }

    public function store(Request $request, AppMailer $mailer)
    {
        try {
            $user = Auth::user();
            $userCompanies = $user->companies;
            
            // Validar que el usuario tenga al menos una empresa asignada
            if ($userCompanies->count() == 0) {
                return redirect()->back()->with('error', 'No tienes ninguna empresa asignada. Por favor, contacta al administrador para que te asigne una empresa antes de crear tickets.');
            }
            
            $validationRules = [
                'title'     => 'required',
                'priority'  => 'required',
                'message'   => 'required',
            ];
            
            // Si el usuario tiene más de una empresa, el campo company es obligatorio
            if ($userCompanies->count() > 1) {
                $validationRules['company'] = 'required';
            }
            
            $validator = \Validator::make($request->all(), $validationRules);
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Si no se proporciona categoría, usar la primera disponible
            $categoryId = $request->input('category');
            if (empty($categoryId)) {
                $firstCategory = Category::first();
                $categoryId = $firstCategory ? $firstCategory->id : 1;
            }
            
            $ticket = new Ticket([
                        'title'        => $request->input('title'),
                        'user_id'      => $user->id,
                        'ticket_id'    => strtoupper(str_random(10)),
                        'category_id'  => $categoryId,
                        'priority_id'  => $request->input('priority'),
                        'message'      => $request->input('message'),
                    ]);

            $ticket->status_id = '1';
            
            // Asignar empresa: si tiene varias, usar la seleccionada; si tiene una, usar esa
            if ($userCompanies->count() > 1) {
                $ticket->company_id = $request->input('company');
            } elseif ($userCompanies->count() == 1) {
                $ticket->company_id = $userCompanies->first()->id;
            }

            $ticket->save();

            // Enviar correos en background sin bloquear la respuesta
            // Usar exec para ejecutar en background
            $ticketId = $ticket->id;
            $userId = $user->id;
            exec("php7.4 " . base_path() . "/artisan send:ticket-email $userId $ticketId > /dev/null 2>&1 &");

            return redirect()->route('tickets.index')->with('success', "A ticket with ID: #$ticket->ticket_id has been opened.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el ticket: ' . $e->getMessage());
        }
    }

    public function reopen($ticket_id, AppMailer $mailer)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->status_id = '4';

        $ticket->save();

        $ticketOwner = $ticket->user;

        $mailer->sendTicketStatusNotification($ticketOwner, $ticket);

        return redirect()->back()->with('info', "Your ticket with ID: #$ticket->ticket_id has been reopened.");
    }

    public function userTickets()
    {
        $tickets = Ticket::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->paginate(10);
        $categories = Category::all();
        $prioritys = Priority::all();
        $statuses = Status::all();

        return view('tickets.index', compact('tickets', 'categories', 'statuses', 'prioritys'));
    }

    public function show($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->where('user_id', Auth::user()->id)->firstOrFail();

        $category = $ticket->category;

        $comments = $ticket->comments;

        $status = $ticket->status;

        $priority = $ticket->priority;

        return view('tickets.show', compact('ticket', 'category', 'status', 'priority', 'comments'));
    }

    public function publicShow($ticket_id)
    {
        // Si no está autenticado, redirigir al login
        if (Auth::guest()) {
            return redirect()->route('auth.login')->with('warning', 'Por favor inicia sesión para ver el ticket');
        }

        // Si está autenticado, verificar que sea el dueño del ticket
        $ticket = Ticket::where('ticket_id', $ticket_id)->where('user_id', Auth::user()->id)->firstOrFail();

        $category = $ticket->category;

        $comments = $ticket->comments;

        $status = $ticket->status;

        $priority = $ticket->priority;

        return view('tickets.show', compact('ticket', 'category', 'status', 'priority', 'comments'));
    }

    /**
     * Maneja la carga de imágenes desde Summernote
     */
    public function uploadSummernoteImage(Request $request)
    {
        try {
            Log::info('Summernote upload request received');
            
            // Validar que se ha enviado un archivo
            if (!$request->hasFile('file')) {
                Log::error('No file in request');
                return response()->json(['error' => 'No file uploaded'], 400);
            }

            $file = $request->file('file');
            Log::info('File received: ' . $file->getClientOriginalName());
            
            // Validar que sea una imagen
            if (!$file->isValid()) {
                Log::error('Invalid file');
                return response()->json(['error' => 'Invalid file'], 400);
            }

            // Validar el tipo MIME
            $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $mimeType = $file->getMimeType();
            Log::info('File MIME type: ' . $mimeType);
            
            if (!in_array($mimeType, $allowedMimes)) {
                Log::error('Invalid MIME type: ' . $mimeType);
                return response()->json(['error' => 'Invalid file type. Only images are allowed.'], 400);
            }

            // Crear el directorio si no existe
            $uploadDir = public_path('uploads/summernote');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
                chmod($uploadDir, 0777);
            }

            // Generar un nombre único para el archivo
            $filename = time() . '_' . str_random(10) . '.' . $file->getClientOriginalExtension();
            
            // Guardar el archivo
            $file->move($uploadDir, $filename);
            Log::info('File saved: ' . $filename);

            // Retornar la URL de la imagen
            $imageUrl = url('uploads/summernote/' . $filename);
            Log::info('Returning image URL: ' . $imageUrl);

            return response()->json(['link' => $imageUrl]);
        } catch (\Exception $e) {
            Log::error('Upload error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}