@extends('adminlte::page')

@section('title', $title)

@section('content')
<div class="row" style="margin-top: 20px;">
    <div class="col-md-12">
      <div class="card card-success">
            <div class="card-header">
                <h2><i class="fas fa-user"></i> {{$title}}</h2>
            </div>
            <form action="{{ route('update_profile') }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" required name="name" value="{{Auth::user()->name}}">
                        @error('name') 
                            <span class="error invalid-feedback">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Email:</label>
                        <input type="email" class="form-control @error('name') is-invalid @enderror" required name="email" value="{{Auth::user()->email}}">
                        @error('email') 
                            <span class="error invalid-feedback">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    @include('admin.partials.buttons',['cancelRoute'=>'dashboard'])
                </div>
            </form>
        </div> 

        <div class="card card-success">
            <div class="card-header">
                <h2><i class="fas fa-key"></i> Change Password</h2>
            </div>
            <form action="{{ route('change_password') }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Password:</label>
                        <input type="password" name="password" required class="form-control @error('password') is-invalid @enderror" />
                        @error('password')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Repeat Password:</label>
                        <input type="password" name="password_confirmation" required class="form-control @error('password_confirmation') is-invalid @enderror" />
                        @error('password_confirmation')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    @include('admin.partials.buttons',['cancelRoute'=>'dashboard'])
                </div>
            </form>
        </div>  
    </div>
</div>
@stop

@section('js')
    @include('admin.partials.messages')
@stop