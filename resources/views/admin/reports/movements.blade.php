@extends('adminlte::page')

@section('title', $title)

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

                <div class="row" style="padding-left: 9px;">
                    <a href="{{route('reports.export_report_movements')}}?from={{@$from}}&to={{@$to}}&sender={{@$sender}}&service={{@$service}}" class="btn btn-info"><i class="fas fa-arrow-down"></i> Exportar Excel</a> 

                    &nbsp;<a href="{{route('reports.export_report_movements_pdf')}}?from={{@$from}}&to={{@$to}}&sender={{@$sender}}&service={{@$service}}" class="btn btn-success"><i class="fas fa-arrow-down"></i> Exportar Pdf</a>
                </div>

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
                                <td><span data-value="{{$r->shipment_date}}" id="date_container_{{$r->id}}">{{date('m-d-Y',strtotime($r->shipment_date))}}</span> <a href="#" class="btn btn-info date_edit" data-parent="{{$r->id}}" data-is-edit="0"><i class="fas fa-edit"></i></a></td>
                                <td>{{$r->sender->full_name}}</td>
                                <td>{{$r->receiver_person_id}}</td>
                                <td>{{$r->country->name}}</td>
                                <td>{{$r->service->name}}</td>
                                <td>${{number_format($r->amount, 2, '.',',')}}</td>
                            </tr>
                       @endforeach
                       <!--<tr>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td align="right"><b>Total:</b></td>
                           <td>${{number_format($total, 2, '.',',')}}</td>
                       </tr>-->
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
            $("table").DataTable({
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                iDisplayLength: -1,
                paging:false,
                searching:false,
                order: [[0, 'desc']]
            });
            $("select").select2();

            $("body").on('click','a.date_edit', function(){
                let parent = $(this).attr("data-parent");
                let span = $("#date_container_"+parent);
                let text = span.attr("data-value");
                let isEdit = $(this).attr("data-is-edit");


                if(parseInt(isEdit) == 0){
                    span.html("<input type='date' style='width:200px; display:inline;' class='form-control' id='input_container_"+parent+"' value='"+text+"'>");
                    $(this).attr("data-is-edit", 1).html('<i class="fas fa-save"></i></a>').removeClass("btn-info").addClass('btn-success');
                }else{
                    let input = $("#input_container_"+parent);
                    $.get('update-date-shipment/'+parent+'/'+input.val(), function(response){
                        if(response.success){
                            span.text(response.data);
                            span.attr("data-value",response.normal_date);
                        }
                    });
                    
                    $(this).attr("data-is-edit", 0).html('<i class="fas fa-edit"></i>').removeClass("btn-success").addClass('btn-info');
                }

                return false;
            });
        });
    </script>
@stop