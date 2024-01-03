@extends('backend.layouts.master')

@section('title','Detail Penitipan')

@section('main-content')
<div class="card">
<h5 class="card-header">Penitipan       <a href="{{route('penitipan.pdf',$penitipan->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a>
  </h5>
  <div class="card-body">
    @if($penitipan)
    <table class="table table-striped table-hover">
      <thead>
        <tr>
            <th>S.N.</th>
            <th>penitipan No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Jumlah</th>
            <th>Charge</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <td>{{$penitipan->id}}</td>
            <td>{{$penitipan->penitipan_number}}</td>
            <td>{{$penitipan->nama_depan}} {{$penitipan->nama_belakang}}</td>
            <td>{{$penitipan->email}}</td>
            <td>{{$penitipan->quantity}}</td>
            <td>Rp.{{$penitipan->shipping->price}}</td>
            <td>Rp.{{number_format($penitipan->total_amount,2)}}</td>
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
                <a href="{{route('penitipan.edit',$penitipan->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                <form method="POST" action="{{route('penitipan.destroy',[$penitipan->id])}}">
                  @csrf
                  @method('delete')
                      <button class="btn btn-danger btn-sm dltBtn" data-id={{$penitipan->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>

        </tr>
      </tbody>
    </table>

    <section class="confirmation_part section_padding">
      <div class="order_boxes">
        <div class="row">
          <div class="col-lg-6 col-lx-4">
            <div class="order-info">
              <h4 class="text-center pb-4">Informasi Penitipan</h4>
              <table class="table">
                    <tr class="">
                        <td>No. Penitipan</td>
                        <td> : {{$penitipan->penitipan_number}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Penitipan</td>
                        <td> : {{$penitipan->created_at->format('D d M, Y')}} at {{$penitipan->created_at->format('g : i a')}} </td>
                    </tr>
                    <tr>
                        <td>Quantity</td>
                        <td> : {{$penitipan->quantity}}</td>
                    </tr>
                    <tr>
                        <td>penitipan Status</td>
                        <td> : {{$penitipan->status}}</td>
                    </tr>
                    <tr>
                        <td>Shipping Charge</td>
                        <td> : Rp. {{$penitipan->shipping->price}}</td>
                    </tr>
                    <tr>
                      <td>Coupon</td>
                      <td> : Rp. {{number_format($penitipan->coupon,2)}}</td>
                    </tr>
                    <tr>
                        <td>Total Amount</td>
                        <td> : Rp. {{number_format($penitipan->total_amount,2)}}</td>
                    </tr>
                    <tr>
                        <td>Payment Method</td>
                        <td> : @if($penitipan->payment_method=='cod') Cash on Delivery @else Bayar @endif</td>
                    </tr>
                    <tr>
                        <td>Payment Status</td>
                        <td> : {{$penitipan->payment_status}}</td>
                    </tr>
              </table>
            </div>
          </div>

          <div class="col-lg-6 col-lx-4">
            <div class="shipping-info">
              <h4 class="text-center pb-4">SHIPPING INFORMATION</h4>
              <table class="table">
                    <tr class="">
                        <td>Full Name</td>
                        <td> : {{$penitipan->first_name}} {{$penitipan->last_name}}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td> : {{$penitipan->email}}</td>
                    </tr>
                    <tr>
                        <td>Phone No.</td>
                        <td> : {{$penitipan->phone}}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td> : {{$penitipan->address1}}, {{$penitipan->address2}}</td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td> : {{$penitipan->country}}</td>
                    </tr>
                    <tr>
                        <td>Post Code</td>
                        <td> : {{$penitipan->post_code}}</td>
                    </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
    @endif

  </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
