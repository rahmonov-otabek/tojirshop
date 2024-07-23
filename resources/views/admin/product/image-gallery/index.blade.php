@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Image Gallery</h1> 
    </div>

    <div class="section-body"> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Product: {{ $product->name }}</h4> 
            </div>
            <div class="card-body"> 
              <form action="{{ route('admin.product-image-gallery.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Image <code>(Multiple image supported!)</code></label>
                    <input type="file" class="form-control" name="image[]" multiple>
                    <input type="hidden" name="product" value="{{ $product->id }}">
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
              </form> 
            </div> 
          </div>
        </div> 
      </div> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>All Image</h4> 
            </div>
            <div class="card-body"> 
              {{ $dataTable->table() }}
            </div> 
          </div>
        </div> 
      </div> 
    </div>
  </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush