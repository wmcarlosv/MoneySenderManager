@extends('adminlte::page')

@section('title', $title)

@section('content')
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h2><i class="fas fa-users"></i> {{ $title }}</h2>
                </div>
                @include('admin.partials.form', ['element'=>'persons', 'type'=>$type, 'id'=>@$data->id])
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">First Name:</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" value="{{ @$data->first_name }}" name="first_name" />
                            @error('first_name')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Last Name:</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" value="{{ @$data->last_name }}" name="last_name" />
                            @error('last_name')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Dni:</label>
                            <input type="file" class="form-control @error('dni') is-invalid @enderror" name="dni" />
                            @error('dni')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                            @if(@$data->dni)
                            <br />
                            <p>
                                <a target="_blank" href="{{ asset('storage/'.str_replace('public/','',@$data->dni)) }}" class="btn btn-info">View</a>
                            </p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="">Other Documents:</label>
                            <input type="file" class="form-control @error('other_documents') is-invalid @enderror" name="other_documents" />
                            @error('other_documents')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                            @if(@$data->other_documents)
                            <br />
                            <p>
                                <a target="_blank" href="{{ asset('storage/'.str_replace('public/','',@$data->other_documents)) }}" class="btn btn-info">View</a>
                            </p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="">Email:</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ @$data->email }}" name="email" />
                            @error('email')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Phone:</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ @$data->phone }}" name="phone" />
                            @error('phone')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Address:</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" >
                                {{ @$data->address }}
                            </textarea>
                            @error('address')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        @include('admin.partials.buttons',['cancelRoute'=>'persons.index'])
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop