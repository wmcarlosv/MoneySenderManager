@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        @if(Auth::user()->role == 'admin')
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
        @endif

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
@stop