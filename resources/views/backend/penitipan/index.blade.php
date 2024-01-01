@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Penitipan</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($penitipans)>0)
        <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.N.</th>
              <th>No.Pesanan</th>
              <th>Nama</th>
              <th>Jumlah</th>
              <th>Ongkir</th>
              <th>Harga Penitipan</th>
              <th>Total Keseluruhan</th>
              <th>Deskripsi</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($penitipans as $penitipan)  
            @php
                $shipping_charge=DB::table('shippings')->where('id',$penitipan->shipping_id)->pluck('price');
                $board_charge=DB::table('harga_penitipans')->where('id',$penitipan->board_id)->pluck('price');
            @endphp 
                <tr>
                    <td>{{$penitipan->id}}</td>
                    <td>{{$penitipan->penitipan_number}}</td>
                    <td>{{$penitipan->nama_depan}} {{$penitipan->nama_belakang}}</td>
                    <td>{{$penitipan->quantity}}</td>
                    <td>@foreach($shipping_charge as $data) Rp. {{number_format($data,2)}} @endforeach</td>
                    <td>@foreach($board_charge as $data) Rp. {{number_format($data,2)}} @endforeach</td>
                    <td>Rp.{{number_format($penitipan->total_amount,2)}}</td>
                    <td>{{$penitipan->description}}</td>
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
                        <a href="{{route('penitipan.show',$penitipan->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                        <a href="{{route('penitipan.edit',$penitipan->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{route('penitipan.destroy',[$penitipan->id])}}">
                          @csrf 
                          @method('delete')
                              <button class="btn btn-danger btn-sm dltBtn" data-id={{$penitipan->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$penitipans->links()}}</span>
        @else
          <h6 class="text-center">TIDAK ADA PENITIPAN HEWAN</h6>
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
      
      $('#order-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
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