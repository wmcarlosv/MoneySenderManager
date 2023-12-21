@extends('adminlte::page')

@section('title', $title)

@section('content')
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h2><i class="fas fa-user"></i> {{ $title }}</h2>
                </div>
                @include('admin.partials.form', ['element'=>'users', 'type'=>$type, 'id'=>@$data->id])
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Name:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ @$data->name }}" name="name" />
                            @error('name')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Email:</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ @$data->email }}" name="email" />
                            @error('email')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Role:</label>
                            <select class="form-control @error('role') is-invalid @enderror" name="role">
                                <option value="admin">Admin</option>
                                <option value="operator" @if(@$data->role == 'operator') selected='selected' @endif>Operator</option>
                            </select>
                            @error('role')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        @if($type=='new')
                            <div class="form-group">
                                <label for="">Password:</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" value="{{ @$data->password }}" name="password" />
                                @error('password')
                                   <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                    </div>
                    <div class="card-footer">
                        @include('admin.partials.buttons',['cancelRoute'=>'users.index'])
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop