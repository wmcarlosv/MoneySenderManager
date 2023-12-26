@extends('adminlte::page')

@section('title', $title)

@section('content')
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h2><i class="fas fa-money-bill"></i> {{ $title }}</h2>
                </div>
                @include('admin.partials.form', ['element'=>'shipments', 'type'=>$type, 'id'=>@$data->id])
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Sender:</label>
                            <select name="sender_person_id" class="form-control @error('sender_person_id') is-invalid @enderror select-tag">
                                <option>-</option>
                                @foreach($options['persons'] as $person)
                                    <option value="{{intval($person->id)}}" @if(@$data->sender_person_id == $person->id) selected='selected' @endif>{{$person->full_name}}</option>
                                @endforeach
                            </select>
                            @error('sender_person_id')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Receiver:</label>
                            <input name="receiver_person_id" type="text" value="{{@$data->receiver_person_id}}" class="form-control @error('receiver_person_id') is-invalid @enderror" />
                            @error('receiver_person_id')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Country:</label>
                            <select name="country_id" class="form-control @error('country_id') is-invalid @enderror select">
                                <option>-</option>
                                @foreach($options['countries'] as $country)
                                    <option value="{{$country->id}}" @if(@$data->country_id == $country->id) selected='selected' @endif>{{$country->name}}</option>
                                @endforeach
                            </select>
                            @error('country_id')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Service:</label>
                            <select name="service_id" class="form-control @error('service_id') is-invalid @enderror select">
                                <option>-</option>
                                @foreach($options['services'] as $service)
                                    <option value="{{$service->id}}" @if(@$data->service_id == $service->id) selected='selected' @endif>{{$service->name}}</option>
                                @endforeach
                            </select>
                            @error('service_id')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Amount:</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{@$data->amount}}" />
                            @error('amount')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        @include('admin.partials.buttons',['cancelRoute'=>'shipments.index'])
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function(){
            $(".select").select2();
        });

        $(document).ready(function(){
            $(".select-tag").select2({
                tags: true
            });
        });
    </script>
@stop