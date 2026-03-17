@extends('layouts.master')

@section('title', trans('texts.my_profile'))

@section('content')

  <div class="content-wrapper">
    <div class="container">

      <section class="content-header">
        <h1>
          {{ site_name() }}
          <small>{{ trans('texts.my_profile') }}</small>
        </h1>
      </section>

      <section class="content">

        @include('layouts.partials.alerts')

      <div class="row">
        <div class="col-md-3">

          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="{{ Auth::user()->getAvatarUrl() }}" alt="{{ trans('texts.user_profile_picture') }}">

              <h3 class="profile-username text-center">{{ $account->fullname }}</h3>

              <p class="text-muted text-center">{{ $account->email }}</p>

              {{-- Información oculta: Ubicación y Sitio Web --}}
              {{--
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>{{ trans('texts.location') }}</b> <a class="pull-right">{{ $account->location }}</a>
                </li>
                <li class="list-group-item">
                  <b>{{ trans('texts.website') }}</b> <a class="pull-right" href="{{ $account->website }}">{{ $account->website }}</a>
                </li>
              </ul>
              --}}
            </div>
          </div>
        </div>
        
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#profile" data-toggle="tab">{{ trans('texts.profile_information') }}</a></li>
              <li><a href="#avatar" data-toggle="tab">{{ trans('texts.manage_your_avatar') }}</a></li>
              <li><a href="#password" data-toggle="tab">{{ trans('texts.change_password') }}</a></li>
              {{-- <li><a href="#deleteaccount" data-toggle="tab">{{ trans('texts.delete_account') }}</a></li> --}}
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="profile">

    <form role="form" method="POST" action="{{ route('account.profile') }}" class="form-horizontal">
        {!! csrf_field() !!}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="name" class="col-sm-2 control-label">{{ trans('texts.email') }}</label>
            <div class="col-sm-4">
                <input type="text" name="email" id="email" value="{{ $account->email ?: old('email') }}" autofocus="" class="form-control">
                @if ($errors->has('email'))
                    <span class="help-block">{{ $errors->first('email') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="fullname" class="col-sm-2 control-label">{{ trans('texts.name') }}</label>
            <div class="col-sm-4">
                <input type="text" name="fullname" id="name" value="{{ $account->fullname ?: old('fullname') }}" class="form-control">
                @if ($errors->has('fullname'))
                    <span class="help-block">{{ $errors->first('fullname') }}</span>
                @endif
            </div>
        </div>
        {{-- Campo Género oculto --}}
        {{--
        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
            <label for="name" class="col-sm-2 control-label">{{ trans('texts.gender') }}</label>
            <div class="col-sm-4">
                <label class="radio col-sm-4">
                    <input type="radio"
                        @if ($account->gender == "M")
                            {{ 'checked="checked"' }}
                        @endif

                    name="gender" value="M" data-toggle="radio"><span>{{ trans('texts.male') }}</span>
                </label>
                <label class="radio col-sm-4">
                    <input type="radio"
                        @if ($account->gender == "F")
                            {{ 'checked="checked"' }}
                        @endif
                     name="gender" value="F" data-toggle="radio"><span>{{ trans('texts.female') }}</span>
                </label>
                @if ($errors->has('gender'))
                    <span class="help-block">{{ $errors->first('gender') }}</span>
                @endif
            </div>
        </div>
        --}}
        {{-- Campo Ubicación oculto --}}
        {{--
        <div class="form-group">
            <label for="location" class="col-sm-2 control-label">{{ trans('texts.location') }}</label>
            <div class="col-sm-4">
                <input type="text" name="location" id="location" value="{{ $account->location ?: old('location') }}" class="form-control" placeholder="Lagos, Nigeria">
            </div>
        </div>
        --}}
        {{-- Campo Sitio Web oculto --}}
        {{--
        <div class="form-group">
            <label for="website" class="col-sm-2 control-label">{{ trans('texts.website') }}</label>
            <div class="col-sm-4">
                <input type="text" name="website" id="website" value="{{ $account->website ?: old('website') }}" class="form-control" placeholder="http://goodheads.io">
            </div>
        </div>
        --}}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
                <button type="submit" class="btn bg-purple"><i class="fa fa-pencil"></i> {{ trans('texts.update_profile') }}</button>
            </div>
        </div>
    </form>

              </div>

              <div class="tab-pane" id="avatar">

    <form role="form" method="POST" action="{{ route('account.avatar') }}"  enctype="multipart/form-data" class="form-horizontal">
        <div class="form-group">
            <label for="gravatar" class="col-sm-2 control-label">{{ trans('texts.gravatar') }}</label>
            <div class="col-sm-4">
                <img src="{{ Auth::user()->getAvatarUrl() }}" width="100" height="100" class="profile">
            </div>
        </div>
        <div class="form-group{{ $errors->has('file_name') ? ' has-error' : '' }}">
            <label for="gravatar" class="col-sm-2 control-label"></label>
            <div class="col-sm-4">
                <input type="file" name="file_name" id="file_name">
                @if ($errors->has('file_name'))
                    <span class="help-block">{{ $errors->first('file_name') }}</span>
                @endif
            </div>
        </div>
         <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
                <button type="submit" class="btn bg-purple"><i class="fa fa-pencil"></i> {{ trans('texts.change_avatar') }}</button>
            </div>
        </div>
        {!! csrf_field() !!}
    </form>

              </div>

              <div class="tab-pane" id="password">

    <form role="form" method="POST" action="{{ route('account.password') }}" class="form-horizontal">
        {!! csrf_field() !!}
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-sm-3 control-label">{{ trans('texts.new_password') }}</label>
            <div class="col-sm-4">
                <input type="password" name="password" id="password" class="form-control">
                @if ($errors->has('password'))
                    <span class="help-block">{{ $errors->first('password') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label for="password" class="col-sm-3 control-label">{{ trans('texts.confirm_password') }}</label>
            <div class="col-sm-4">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-4">
                <button type="submit" class="btn bg-purple"><i class="fa fa-lock"></i> {{ trans('texts.change_password') }}</button>
            </div>
        </div>
    </form>

              </div>
              
                    <div class="tab-pane" id="deleteaccount">              
              
    <p>{{ trans('texts.delete_account_warning') }}</p>

    <a href="{{ route('account.confirm.delete') }}">
        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> {{ trans('texts.delete_my_account') }}</button>
    </a>              
              
              </div>
            </div>
          </div>
        </div>
    </div>

        </section> 
    </div>
  </div>
@stop