@extends('layouts.master')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Reportes
      <small>Listado de tickets</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Reportes</li>
    </ol>
  </section>

  <section class="content">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> ¡Éxito!</h4>
        {{ session('success') }}
      </div>
    @endif

    <!-- Filtros -->
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Filtros</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>

          <div class="box-body">
            <form method="GET" action="{{ route('reports.index') }}" class="form-inline">
              <div class="form-group" style="margin-right: 15px;">
                <label for="date_from">Desde:</label>
                <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}" style="margin-left: 10px; width: 150px;">
              </div>

              <div class="form-group" style="margin-right: 15px;">
                <label for="date_to">Hasta:</label>
                <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}" style="margin-left: 10px; width: 150px;">
              </div>

              <button type="submit" class="btn btn-primary">
                <i class="fa fa-search"></i> Filtrar
              </button>

              <a href="{{ route('reports.index') }}" class="btn btn-default" style="margin-left: 10px;">
                <i class="fa fa-refresh"></i> Limpiar
              </a>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Botones de Exportación -->
    <div class="row">
      <div class="col-md-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Exportar Reporte</h3>
          </div>

          <div class="box-body">
            <a href="{{ route('reports.exportExcel', ['date_from' => request('date_from'), 'date_to' => request('date_to')]) }}" class="btn btn-success" target="_blank">
              <i class="fa fa-file-excel-o"></i> Descargar Excel
            </a>
            <a href="{{ route('reports.exportPdf', ['date_from' => request('date_from'), 'date_to' => request('date_to')]) }}" class="btn btn-danger" target="_blank" style="margin-left: 5px;">
              <i class="fa fa-file-pdf-o"></i> Descargar PDF
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabla de Reportes -->
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Reportes ({{ $tickets->total() }} total)</h3>
          </div>

          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover" id="reportsTable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Ticket ID</th>
                    <th>Título</th>
                    <th>Usuario</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Fecha Creación</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($tickets as $ticket)
                    <tr>
                      <td>{{ $ticket->id }}</td>
                      <td>
                        <a href="{{ route('managetickets.show', $ticket->ticket_id) }}" target="_blank">
                          {{ $ticket->ticket_id }}
                        </a>
                      </td>
                      <td>{{ $ticket->title }}</td>
                      <td>{{ $ticket->user->fullname ?? 'N/A' }}</td>
                      <td>
                        @if($ticket->category)
                          <span class="label label-info">{{ $ticket->category->name }}</span>
                        @else
                          <span class="label label-default">N/A</span>
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
                            <span class="label label-default">{{ $ticket->status->name }}</span>
                          @endif
                        @else
                          <span class="label label-default">N/A</span>
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
                            <span class="label label-default">{{ $ticket->priority->name }}</span>
                          @endif
                        @else
                          <span class="label label-default">N/A</span>
                        @endif
                      </td>
                      <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="8" class="text-center">No hay reportes disponibles</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          <div class="box-footer">
            <div class="pagination-wrapper">
              {{ $tickets->appends(request()->query())->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

<script>
  $(document).ready(function() {
    $('#reportsTable').DataTable({
      "paging": false,
      "ordering": true,
      "info": true,
      "searching": true,
      "language": {
        "search": "Buscar:",
        "zeroRecords": "No se encontraron resultados",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
        "paginate": {
          "first": "Primera",
          "last": "Última",
          "next": "Siguiente",
          "previous": "Anterior"
        }
      }
    });
  });
</script>
@endsection
