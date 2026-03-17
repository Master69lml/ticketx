@extends('admin.layouts.master')

@section('title', 'Gestionar Empresas')

@section('content')
<div class="content-wrapper">
    <div class="container">
        
        <section class="content-header">
            <h1>
                Empresas
                <small>Gestionar empresas del sistema</small>
            </h1>
        </section>
        
        <section class="content">

            @include('admin.layouts.partials.alerts')

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-building"></i> Listado de Empresas
                    </h3>
                    <div class="box-tools pull-right">
                        <a href="{{ route('companies.create') }}" class="btn btn-success btn-sm">
                            <i class="fa fa-plus"></i> Nueva Empresa
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    @if ($companies->isEmpty())
                        <p class="text-center text-muted">No hay empresas registradas. <a href="{{ route('companies.create') }}">Crear una</a></p>
                    @else
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Usuarios</th>
                                    <th>Creada</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies as $company)
                                    <tr>
                                        <td>{{ $company->id }}</td>
                                        <td>
                                            <strong>{{ $company->name }}</strong>
                                        </td>
                                        <td>
                                            @if ($company->active)
                                                <span class="label label-success">Activa</span>
                                            @else
                                                <span class="label label-danger">Inactiva</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-blue">{{ $company->users->count() }}</span>
                                        </td>
                                        <td>
                                            {{ $company->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-xs btn-info">
                                                <i class="fa fa-edit"></i> Editar
                                            </a>
                                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display: inline;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Estás seguro?');">
                                                    <i class="fa fa-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="text-center">
                            {{ $companies->render() }}
                        </div>
                    @endif
                </div>
            </div>

        </section>

    </div>
</div>
@endsection
