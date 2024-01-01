@extends('backend.layouts.master')

@section('title','Detail_Penitipan')

@section('main-content')
<div class="card">
  <h5 class="card-header"> Edit Penitipan</h5>
  <div class="card-body">
    <form action="{{route('penitipan.update',$penitipan->id)}}" method="POST">
      @csrf
      @method('PATCH')
      <div class="form-group">
        <label for="status">Status :</label>
        <select name="status" id="" class="form-control">
          <option value="new" {{($penitipan->status=='delivered' || $penitipan->status=="process" || $penitipan->status=="cancel") ? 'disabled' : ''}}  {{(($penitipan->status=='new')? 'selected' : '')}}>New</option>
          <option value="process" {{($penitipan->status=='delivered'|| $penitipan->status=="cancel") ? 'disabled' : ''}}  {{(($penitipan->status=='process')? 'selected' : '')}}>process</option>
          <option value="delivered" {{($penitipan->status=="cancel") ? 'disabled' : ''}}  {{(($penitipan->status=='delivered')? 'selected' : '')}}>Delivered</option>
          <option value="cancel" {{($penitipan->status=='delivered') ? 'disabled' : ''}}  {{(($penitipan->status=='cancel')? 'selected' : '')}}>Cancel</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
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
