@extends('layouts.app')

@section('content')
<?php
    function base64UrlEncode($inputStr)
    {
        return strtr(base64_encode($inputStr),'+/=','-_,');
    }
	if(isset($_GET['url'])){
		$url=$_GET['url']; 
		$statesString = base64UrlEncode('{"url":$url}');
	}else{
		$statesString=base64UrlEncode('http://localhost:8000');
	}
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordarme
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Iniciar Sesión
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Olvide Mi Contraseña
                                </a>
								
                                <!--<a href="{{ action('Auth\LoginGoogleController@redirectToProvider') }}" class="btn btn-primary">Iniciar Sesión con Google y SSO</a>
								@csrf-->
								<a href="{{ route('login.google' ) }}" class="btn btn-primary">Iniciar Sesión con Google</a>
				
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
