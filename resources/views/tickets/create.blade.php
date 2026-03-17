@extends('layouts.master')

@section('title', 'Mis tickets')

@section('content')
  <div class="content-wrapper">
    <div class="container">
        
      <section class="content-header">
        <h1>
         {{ site_name() }}
          <small>Abrir nuevo ticket</small>
        </h1>
      </section>
      
      <section class="content">

        @include('layouts.partials.alerts')

          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-ticket"> Abrir nuevo ticket</i></h3>
            </div>
            <div class="box-body">

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/tickets/store') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Título</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" placeholder="Ingresa un título" value="{{ old('title') }}">

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Campo de categoría oculto --}}
                        {{--
                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="category" class="col-md-4 control-label">Categoría</label>

                            <div class="col-md-6">
                                <select id="category" type="category" class="form-control" name="category">
                                    <option value="">Seleccionar Categoría</option>
                                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('category'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        --}}

                        @if ($companies->count() > 1)
                        <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                            <label for="company" class="col-md-4 control-label">Empresa</label>

                            <div class="col-md-6">
                                <select id="company" class="form-control" name="company" required>
                                    <option value="">Seleccionar Empresa</option>
                                    @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('company'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                            <label for="priority" class="col-md-4 control-label">Prioridad</label>

                            <div class="col-md-6">
                                <select id="priority" type="priority" class="form-control" name="priority">
                                    <option value="">Seleccionar Prioridad</option>
                                    @foreach ($prioritys as $priority)
                        <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('priority'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                            <label for="message" class="col-md-4 control-label">Descripción del Problema</label>

                            <div class="col-md-6">
                                <textarea rows="10" id="summernote" class="form-control" placeholder="Describe el problema" name="message"></textarea>

                                @if ($errors->has('message'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn bg-purple">
                                    <i class="fa fa-btn fa-ticket"></i> Abrir Ticket
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
      </section> 
    </div>
  </div>
@endsection