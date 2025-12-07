<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Excel;
use PDF;

class ReportsController extends Controller
{
    /**
     * Mostrar listado de reportes
     */
    public function index(Request $request)
    {
        $query = Ticket::query();
        
        // Filtrar por fecha de creación
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $tickets = $query->with('user', 'category', 'status')->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.reports.index', compact('tickets'));
    }

    /**
     * Exportar a Excel
     */
    public function exportExcel(Request $request)
    {
        $query = Ticket::query();
        
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $tickets = $query->with('user', 'category', 'status', 'priority')->get();
        
        return Excel::create('Reportes_' . date('Y-m-d_His'), function($excel) use ($tickets) {
            $excel->sheet('Reportes', function($sheet) use ($tickets) {
                // Encabezados
                $sheet->row(1, [
                    'ID',
                    'ID Ticket',
                    'Título',
                    'Usuario',
                    'Categoría',
                    'Estado',
                    'Prioridad',
                    'Fecha Creación',
                    'Fecha Actualización'
                ]);
                
                // Datos
                $row = 2;
                foreach ($tickets as $ticket) {
                    $statusName = $ticket->status ? (string)$ticket->status->name : 'N/A';
                    $priorityName = $ticket->priority ? (string)$ticket->priority->name : 'N/A';
                    $categoryName = $ticket->category ? (string)$ticket->category->name : 'N/A';
                    $userName = $ticket->user ? (string)$ticket->user->fullname : 'N/A';
                    
                    $sheet->row($row, [
                        (string)$ticket->id,
                        (string)$ticket->ticket_id,
                        (string)$ticket->title,
                        $userName,
                        $categoryName,
                        $statusName,
                        $priorityName,
                        $ticket->created_at->format('d/m/Y H:i'),
                        $ticket->updated_at->format('d/m/Y H:i')
                    ]);
                    $row++;
                }
            });
        })->download('xlsx');
    }

    /**
     * Exportar a PDF
     */
    public function exportPdf(Request $request)
    {
        $query = Ticket::query();
        
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $tickets = $query->with('user', 'category', 'status')->orderBy('created_at', 'desc')->get();
        
        $pdf = PDF::loadView('admin.reports.pdf', compact('tickets'));
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('Reportes_' . date('Y-m-d_His') . '.pdf');
    }
}
