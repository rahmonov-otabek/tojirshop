@extends('vendor.layouts.master')

@section('title')
    {{ $settings->site_name }} | Product Variant Item
@endsection

@section('content')
    <!--=============================
    DASHBOARD START
  ==============================-->
  <section id="wsus__dashboard">
    <div class="container-fluid">
      @include('vendor.layouts.sidebar')

      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <a href="{{ route('vendor.product-variant.index', ['product' => $product->id ])}}" class="btn btn-warning mb-4"> 
            <i class="fas fa-long-arrow-left"></i> Back</a>
          <div class="dashboard_content mt-2 mt-md-0">
            <h3><i class="far fa-user"></i>Product Variant Item</h3>
            <div class="create_button">
                <a href="{{ route('vendor.product-variant-item.create', ['productId' => $product->id, 'variantId' => $variant->id ])}}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New</a> 
            </div>
            <div class="wsus__dashboard_profile">
              <div class="wsus__dash_pro_area">
                {{ $dataTable->table() }} 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--=============================
    DASHBOARD START
  ==============================-->
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush