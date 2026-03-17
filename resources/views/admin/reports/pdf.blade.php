<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Tickets</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3c8dbc;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #3c8dbc;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 12px;
        }

        .info-section {
            margin-bottom: 20px;
            font-size: 12px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
        }

        thead {
            background-color: #3c8dbc;
            color: white;
        }

        th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #3c8dbc;
        }

        td {
            padding: 10px 12px;
            border: 1px solid #ddd;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f5f5f5;
        }

        .label {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
        }

        .label-primary {
            background-color: #0066cc;
            color: white;
        }

        .label-warning {
            background-color: #ff9800;
            color: white;
        }

        .label-success {
            background-color: #4caf50;
            color: white;
        }

        .label-info {
            background-color: #00bcd4;
            color: white;
        }

        .label-danger {
            background-color: #f44336;
            color: white;
        }

        .footer {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }

        .summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #f5f5f5;
            border-left: 4px solid #3c8dbc;
        }

        .summary p {
            margin: 5px 0;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Tickets - TeoTickets</h1>
        <p>Generado: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="info-section">
        <strong>Total de Registros:</strong> {{ count($tickets) }}<br>
        <strong>Período:</strong> 
        @if(request('date_from') && request('date_to'))
            {{ \Carbon\Carbon::createFromFormat('Y-m-d', request('date_from'))->format('d/m/Y') }} 
            al 
            {{ \Carbon\Carbon::createFromFormat('Y-m-d', request('date_to'))->format('d/m/Y') }}
        @else
            Todos los registros
        @endif
    </div>

    @if(count($tickets) > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 10%;">Ticket ID</th>
                    <th style="width: 20%;">Título</th>
                    <th style="width: 12%;">Usuario</th>
                    <th style="width: 10%;">Categoría</th>
                    <th style="width: 10%;">Estado</th>
                    <th style="width: 8%;">Prioridad</th>
                    <th style="width: 15%;">Fecha Creación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->ticket_id }}</td>
                        <td>{{ $ticket->title }}</td>
                        <td>{{ $ticket->user->fullname ?? 'N/A' }}</td>
                        <td>
                            @if($ticket->category)
                                <span class="label label-info">{{ $ticket->category->name }}</span>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($ticket->status)
                                @if($ticket->status->id == 1)
                                    <span class="label label-primary">Abierto</span>
                                @elseif($ticket->status->id == 2)
                                    <span class="label label-warning">En Progreso</span>
                                @elseif($ticket->status->id == 3)
                                    <span class="label label-success">Cerrado</span>
                                @elseif($ticket->status->id == 4)
                                    <span class="label label-info">Reabierto</span>
                                @else
                                    <span class="label">{{ $ticket->status->name }}</span>
                                @endif
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($ticket->priority)
                                @if($ticket->priority->id == 1)
                                    <span class="label label-success">Baja</span>
                                @elseif($ticket->priority->id == 2)
                                    <span class="label label-warning">Media</span>
                                @elseif($ticket->priority->id == 3)
                                    <span class="label label-danger">Alta</span>
                                @else
                                    <span class="label">{{ $ticket->priority->name }}</span>
                                @endif
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <p><strong>Total de Tickets:</strong> {{ count($tickets) }}</p>
            <p><strong>Por Estado:</strong></p>
            <ul style="margin-left: 20px; font-size: 12px;">
                <li>Abiertos: {{ $tickets->where('status_id', 1)->count() }}</li>
                <li>En Progreso: {{ $tickets->where('status_id', 2)->count() }}</li>
                <li>Cerrados: {{ $tickets->where('status_id', 3)->count() }}</li>
                <li>Reabiertos: {{ $tickets->where('status_id', 4)->count() }}</li>
            </ul>
        </div>
    @else
        <div class="info-section">
            <p style="color: #f44336;"><strong>No hay registros disponibles para los filtros seleccionados.</strong></p>
        </div>
    @endif

    <div class="footer">
        <p>Este documento fue generado automáticamente por el sistema de reportería de MV Aceros</p>
        <p>© {{ date('Y') }} - Todos los derechos reservados</p>
    </div>
</body>
</html>
