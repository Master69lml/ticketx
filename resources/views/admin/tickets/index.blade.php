@extends('admin.layouts.master')

@section('content')

  <div class="content-wrapper">

    <section class="content-header">
      <h1>
        Admin
        <small>Tickets</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Tickets</li>
      </ol>
    </section>


    <section class="content">
        
        @include('admin.layouts.partials.alerts')
        
        @include('admin.tickets.buttons')

          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Tickets</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="box-body table-responsive">
  <div class="col-md-12">              
                  @if ($tickets->isEmpty())
                        <p>There is no tickets here.</p>
                    @else
                        <table class="table table-hover" id="tickettable">
                            <thead>
                                <tr>
                                    <th>ID Ticket</th>
                                    <th>Título</th>
                                    <th>Usuario</th>
                                    <th>Empresa</th>
                                    <th>Comentarios</th>
                                    <th>Categoría</th>
                                    <th>Estado</th>
                                    <th>Prioridad</th>
                                    <th>Técnico</th>
                                    <th>Tiempo</th>
                                    <th>Creado</th>
                                    <th>Última Actualización</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td><span class="label label-default">#{{ $ticket->ticket_id }}</span></td>
                                    <td>
                                        <a href="{{ url('admin/tickets/'. $ticket->ticket_id) }}">
                                            {{ $ticket->title }}
                                        </a>
                                    </td>  
                                    <td>{{ $ticket->user->fullname }}</td>
                                    <td>{{ $ticket->company ? $ticket->company->name : '-' }}</td>
                                    <td><span class="badge">{{ count($ticket->comments) }}</span></td>
                                    <td>
                                    @foreach ($categories as $category)
                                        @if ($category->id === $ticket->category_id)
                                            {{ $category->name }}
                                        @endif
                                    @endforeach
                                    </td>
                                    <td>
                                    @foreach ($statuses as $status)
                                        @if ($status->id === $ticket->status_id)
                                            @if ($status->id === 1)
                                            <span class="label label-info"> {{ $status->name }}</span>
                                            @elseif ($status->id === 2)
                                            <span class="label label-warning"> {{ $status->name }}</span>
                                            @elseif ($status->id === 3)
                                            <span class="label label-success"> {{ $status->name }}</span>
                                            @else
                                            <span class="label label-danger"> {{ $status->name }}</span>
                                            @endif                                    
                                        @endif
                                    @endforeach
                                    </td>
                                    <td>
                                    @foreach ($prioritys as $priority)
                                        @if ($priority->id === $ticket->priority_id)
                                            @if ($priority->id === 1)
                                            <p class="bg-danger"> {{ $priority->name }}</p>
                                            @elseif ($priority->id === 2)
                                            <p class="bg-success"> {{ $priority->name }}</p>
                                            @else 
                                            <p class="bg-info"> {{ $priority->name }}</p>
                                            @endif                                        
                                        @endif
                                    @endforeach
                                    </td>
                                    <td>{{ $ticket->technicalStaff ? $ticket->technicalStaff->name : '-' }}</td>
                                    <td>{{ $ticket->getFormattedWorkTime() }}</td>
                                    <td>{{ $ticket->created_at->diffForHumans() }}</td>
                                    <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
        </div>
    </div>
    </section>
  </div>
  
 @push('scripts') 
 <script>
   $(function () {
     $("#tickettable").DataTable({
         "order": [[ 0, "asc" ]],
         "language": {
             "lengthMenu": "Mostrar _MENU_ entradas",
             "zeroRecords": "No se encontraron resultados",
             "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
             "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
             "infoFiltered": "(filtrado de _MAX_ entradas totales)",
             "search": "Buscar:",
             "paginate": {
                 "first": "Primero",
                 "last": "Último",
                 "next": "Siguiente",
                 "previous": "Anterior"
             },
             "emptyTable": "No hay datos disponibles en la tabla"
         }
     });
   });
 </script>  
 @endpush  
  
@endsection