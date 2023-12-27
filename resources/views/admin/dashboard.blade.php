@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-check"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Services</span>
                <span class="info-box-number">{{$data->services}}</span>
              </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="fas fa-flag"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Countries</span>
                <span class="info-box-number">{{$data->countries}}</span>
              </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="info-box">
              <span class="info-box-icon bg-yellow"><i class="fas fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Profiles</span>
                <span class="info-box-number">{{$data->persons}}</span>
              </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="info-box">
              <span class="info-box-icon bg-red"><i class="fas fa-money-bill"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Activities</span>
                <span class="info-box-number">{{$data->shipments}}</span>
              </div>
            </div>
        </div>
    </div>  
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h2>Profiles That Execeed The Monthly Limit</h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>Profile Name</th>
                            <th>Service</th>
                            <th>Limit</th>
                            <th>Amount</th>
                            <th>Difference</th>
                        </thead>
                        <tbody>
                            @foreach($profiles as $profile)
                                <tr>
                                    <td>{{$profile->send}}</td>
                                    <td>{{$profile->serv}}</td>
                                    <td>{{number_format($profile->lmit,2,".",",")}} $</td>
                                    <td>{{number_format($profile->amount,2,".",",")}} $</td>
                                    <td>{{number_format($profile->difference,2,".",",")}} $</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function(){
            $("table").DataTable();
        });
    </script>
@stop