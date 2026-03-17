@extends('admin.layouts.master')

@section('title', 'Editar Empresa')

@section('content')
<div class="content-wrapper">
    <div class="container">
        
        <section class="content-header">
            <h1>
                Editar Empresa
                <small>{{ $company->name }}</small>
            </h1>
        </section>
        
        <section class="content">

            @include('admin.layouts.partials.alerts')

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-edit"></i> Editar Empresa</h3>
                </div>
                <div class="box-body">

                    {!! Form::model($company, ['method' => 'PATCH', 'route' => ['companies.update', $company->id], 'class' => 'form-horizontal']) !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nombre de la Empresa</label>

                            <div class="col-md-6">
                                {!! Form::text('name', null, array('placeholder' => 'Ej: Acme Corporation', 'class' => 'form-control')) !!}

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                            <label for="active" class="col-md-4 control-label">Estado</label>

                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('active', 1, null) !!}
                                        <strong>Empresa Activa</strong>
                                    </label>
                                </div>

                                @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('active') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Usuarios Asignados</label>
                            <div class="col-md-6">
                                <p class="form-control-static">
                                    @if ($company->users->count() > 0)
                                        <span class="badge bg-blue">{{ $company->users->count() }} usuario(s)</span>
                                        @foreach ($company->users as $user)
                                            <br><small>• {{ $user->fullname }} ({{ $user->email }})</small>
                                        @endforeach
                                    @else
                                        <span class="text-muted">Sin usuarios asignados</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn bg-purple">
                                    <i class="fa fa-btn fa-save"></i> Actualizar Empresa
                                </button>
                                <a href="{{ route('companies.index') }}" class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </section>

    </div>
</div>
@endsection
