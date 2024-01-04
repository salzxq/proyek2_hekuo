@extends('user.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
<h5 class="card-header">penitipan     <a href="{{route('penitipan.pdf',$penitipan->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a>
  </h5>
  <div class="card-body">
    @if($penitipan)
    <table class="table table-striped table-hover">
      <thead>
        <tr>
            <th>S.N.</th>
            <th>penitipan No.</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Quantity</th>
            <th>Charge</th>
            <th>Jumlah Total</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <td>{{$penitipan->id}}</td>
            <td>{{$penitipan->penitipan_number}}</td>
            <td>{{$penitipan->first_name}} {{$penitipan->last_name}}</td>
            <td>{{$penitipan->email}}</td>
            <td>{{$penitipan->quantity}}</td>
            {{--<td>${{$order->shipping->price}}</td>--}}
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
              <h4 class="text-center pb-4">penitipan INFORMATION</h4>
              <table class="table">
                    <tr class="">
                        <td>Nomor penitipan</td>
                        <td> : {{$penitipan->penitipan_number}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal penitipan</td>
                        <td> : {{$penitipan->created_at->format('D d M, Y')}} at {{$penitipan->created_at->format('g : i a')}} </td>
                    </tr>
                    <tr>
                        <td>Quantity</td>
                        <td> : {{$penitipan->quantity}}</td>
                    </tr>
                    <tr>
                        <td>Status penitipan</td>
                        <td> : {{$penitipan->status}}</td>
                    </tr>
                    <tr>
                      @php
                          $shipping_charge=DB::table('shippings')->where('id',$penitipan->shipping_id)->pluck('price');
                      @endphp
                        {{--<td>Shipping Charge</td>
                        <td> :${{$order->shipping->price}}</td>--}}
                    </tr>
                    <tr>
                        <td>Jumlah Total</td>
                        <td> : $ {{number_format($penitipan->total_amount,2)}}</td>
                    </tr>
                    <tr>
                      <td>Metode Pembayaran</td>
                      <td> : @if($penitipan->payment_method=='cod') Cash on Delivery @else Paypal @endif</td>
                    </tr>
                    <tr>
                        <td>Status Pembayaran</td>
                        <td> : {{$penitipan->payment_status}}</td>
                    </tr>
              </table>
            </div>
          </div>

          <div class="col-lg-6 col-lx-4">
            <div class="shipping-info">
              <h4 class="text-center pb-4">INFORMASI PENGIRIMAN</h4>
              <table class="table">
                    <tr class="">
                        <td>Nama Lengkap</td>
                        <td> : {{$penitipan->first_name}} {{$penitipan->last_name}}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td> : {{$penitipan->email}}</td>
                    </tr>
                    <tr>
                        <td>No.Handphone.</td>
                        <td> : {{$penitipan->phone}}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td> : {{$penitipan->address1}}</td>
                    </tr>
                    <tr>
                        <td>Kode Post</td>
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
