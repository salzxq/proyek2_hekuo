@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Harga Penitipan</h5>
    <div class="card-body">
      <form method="post" action="{{route('hargapenitipan.update',$hargapenitipan->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="waktu" class="col-form-label">Waktu <span class="text-danger">*</span></label>
          <select name="waktu" class="form-control">
            <option value="harian" {{(($hargapenitipan->waktu=='harian') ? 'selected' : '')}}>harian</option>
            <option value="bulanan" {{(($hargapenitipan->waktu=='bulanan') ? 'selected' : '')}}>bulanan</option>
            <option value="tahunan" {{(($hargapenitipan->waktu=='tahunan') ? 'selected' : '')}}>tahunan</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>     
        <div class="form-group">
          <label for="price" class="col-form-label">Price <span class="text-danger">*</span></label>
        <input id="price" type="number" name="price" placeholder="Enter price"  value="{{$hargapenitipan->price}}" class="form-control">
        @error('price')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>        
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active" {{(($hargapenitipan->status=='active') ? 'selected' : '')}}>Active</option>
            <option value="inactive" {{(($hargapenitipan->status=='inactive') ? 'selected' : '')}}>Inactive</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });
</script>
@endpush