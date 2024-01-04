@extends('user.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('user.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">penitipan Lists</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($penitipans)>0)
        <table class="table table-bpenitipaned" id="penitipan-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.N.</th>
              <th>penitipan No.</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Quantity</th>
              <th>Jumlah Total</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>S.N.</th>
              <th>penitipan No.</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Quantity</th>
              <th>Jumlah Total</th>
              <th>Status</th>
              <th>Action</th>
              </tr>
          </tfoot>
          <tbody>
            @foreach($penitipans as $penitipan)
                <tr>
                    <td>{{$penitipan->id}}</td>
                    <td>{{$penitipan->penitipan_number}}</td>
                    <td>{{$penitipan->first_name}} {{$penitipan->last_name}}</td>
                    <td>{{$penitipan->email}}</td>
                    <td>{{$penitipan->quantity}}</td>
                    {{--<td>${{$penitipan->shipping->price}}</td>--}}
                    <td>${{number_format($penitipan->total_amount,2)}}</td>
                    <td>
                        @if($penitipan->status=='new')
                          <span class="badge badge-primary">{{$penitipan->status}}</span>
                        @elseif($penitipan->status=='process')
                          <span class="badge badge-warning">{{$penitipan->status}}</span>
                        @elseif($penitipan->status=='delivered')
                          <span class="badge badge-success">{{$penitipan->status}}</span>
                        @else
                          <span class="badge badge-danger">{{$penitipan->status}}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('user.penitipan.show',$penitipan->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;bpenitipan-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                        <form method="POST" action="{{route('user.penitipan.delete',[$penitipan->id])}}">
                          @csrf
                          @method('delete')
                              <button class="btn btn-danger btn-sm dltBtn" data-id={{$penitipan->id}} style="height:30px; width:30px;bpenitipan-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$penitipans->links()}}</span>
        @else
          <h6 class="text-center">Tidak ada penitipan yang ditemukan!!! Silakan melakukan penitipan terlebih dahulu</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>

      $('#penitipan-dataTable').DataTable( {
            "columnDefs":[
                {
                    "penitipanable":false,
                    "targets":[8]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){

        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush
