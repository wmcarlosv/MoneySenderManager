@extends('adminlte::page')

@section('title', $title)

@section('content')
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h2><i class="fas fa-check"></i> {{ $title }}</h2>
                </div>
                @include('admin.partials.form', ['element'=>'services', 'type'=>$type, 'id'=>@$data->id])
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Name:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ @$data->name }}" name="name" />
                            @error('name')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Monthly Limit Amount:</label>
                            <input type="text" class="form-control @error('monthly_limit_amount') is-invalid @enderror" value="{{ @$data->monthly_limit_amount }}" name="monthly_limit_amount" />
                            @error('monthly_limit_amount')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        @include('admin.partials.buttons',['cancelRoute'=>'services.index'])
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop