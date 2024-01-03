@extends('adminlte::page')

@section('title', $title)

@section('content')
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h2><i class="fas fa-store"></i> {{ $title }}</h2>
                </div>
                <form action="{{ route('store_info.post') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                    @method('post')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Name:</label>
                            <input type="text" class="form-control" name="name" value="{{@$data->name}}" />
                        </div>
                        <div class="form-group">
                            <label for="">Logo:</label>
                            <input type="file" class="form-control" name="logo" />
                            @if(@$data->logo)
                                <br>
                                <img src="{{ asset('storage/'.str_replace('public/','',@$data->logo)) }}" class="img-thumbnail" style="width:100px; height: 100px;" />
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Address:</label>
                            <textarea name="address" class="form-control">{{@$data->address}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Phone:</label>
                            <input type="text" class="form-control" name="phone" value="{{@$data->phone}}" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    @include('admin.partials.messages')
@stop