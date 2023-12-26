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
                            <label for="">Name:</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" value="{{ @$data->first_name }}" name="first_name" />
                            @error('first_name')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">ID:</label>
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
                            <input type="file" class="form-control @error('other_documents') is-invalid @enderror" name="other_documents[]" multiple />
                            @error('other_documents')
                               <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                            @if(@$data->other_documents)
                            <br />
                            @foreach(json_decode($data->other_documents) as $od)
                                <p style="display:inline;">
                                    <a target="_blank" data-original-url="{{$od}}" href="{{ asset('storage/'.str_replace('public/','',$od)) }}" class="btn btn-info document-viewer">View Document {{$loop->index +1 }}</a>
                                </p>
                            @endforeach
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email:</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ @$data->email }}" name="email" />
                                    @error('email')
                                       <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="">Phone:</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ @$data->phone }}" name="phone" />
                                @error('phone')
                                   <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            </div>
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
    @if($type == 'edit')
       <!-- Modal -->
        <div class="modal fade" id="document_viewer_modal" tabindex="-1" aria-labelledby="document_viewer_modal" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Document Viewer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route('deleteImage') }}" method="POST">
                @method('POST')
                @csrf
                <input type="hidden" name="delete_image" id="input_delete_image">
                <input type="hidden" name="person_id" value="{{@$data->id}}" />
                  <div class="modal-body">
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete Document</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
    @endif

@stop

@if($type == 'edit')
    @section('js')
        <script>
            $(document).ready(function(){
                $("a.document-viewer").click(function(){
                    let url = $(this).attr("href");
                    let oi = $(this).attr("data-original-url");
                    $("#input_delete_image").val(oi);
                    $(".modal-body").html("<img src='"+url+"' class='img-thumbnail img-fluid' />");
                    $("#document_viewer_modal").modal("show");
                    return false;
                });
            });
        </script>
        @include('admin.partials.messages')
    @stop
    
@endif