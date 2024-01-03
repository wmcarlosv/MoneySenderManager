@extends('adminlte::page')

@section('title', $title)

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@stop

@section('content')
    <div class="row" style="margin-top:20px;">
       <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h2><i class="fas fa-file-pdf"></i> {{$title}}</h2>
            </div>
            <div class="card-body">
                <form method="GET">
                    <input type="hidden" name="filter" value="yes">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Date From:</label>
                                <input type="date" value="{{@$from}}" class="form-control" name="from">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form group">
                                <label for="">Date To:</label>
                                <input type="date" value="{{@$to}}" class="form-control" name="to">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Sender:</label>
                                <select name="sender" class="form-control">
                                    <option value="">-</option>
                                    @foreach($data['persons'] as $person)
                                        <option value="{{$person->id}}" @if(@$sender == $person->id) selected='selected' @endif>{{$person->full_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Service:</label>
                                <select name="service" class="form-control">
                                   <option value="">-</option>
                                   @foreach($data['services'] as $serv)
                                    <option value="{{$serv->id}}" @if(@$service == $serv->id) selected='selected' @endif>{{$serv->name}}</option>
                                   @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                                <button class="btn btn-success" style="margin-top: 31px;">Filter</button>
                        </div>
                    </div>
                </form>
                <table class="table table-striped table-bordered">
                   <thead>
                       <th>Date</th>
                       <th>Sender Name</th>
                       <th>Receiver Name</th>
                       <th>Country</th>
                       <th>Service</th>
                       <th>Amount</th>
                   </thead>
                   <tbody>
                      @php
                        $total = 0;
                       @endphp

                       @foreach($result as $r)
                           @php
                            $total+=floatval($r->amount);
                           @endphp
                            <tr>
                                <td>{{date('m-d-Y',strtotime($r->shipment_date))}}</td>
                                <td>{{$r->sender->full_name}}</td>
                                <td>{{$r->receiver_person_id}}</td>
                                <td>{{$r->country->name}}</td>
                                <td>{{$r->service->name}}</td>
                                <td>${{number_format($r->amount, 2, '.',',')}}</td>
                            </tr>
                       @endforeach
                       <tr>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td align="right"><b>Total:</b></td>
                           <td>${{number_format($total, 2, '.',',')}}</td>
                       </tr>
                   </tbody>
               </table>  
            </div>
        </div>
       </div>
    </div>  
@stop

@section('js')
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function(){
            $("table").DataTable({
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                iDisplayLength: -1,
                paging:false,
                searching:false,
                order: [[0, 'desc']],
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
            $("select").select2();
        });
    </script>
@stop