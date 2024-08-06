@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Seller Products</h1> 
    </div>

    <div class="section-body"> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>All Seller Products</h4> 
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

    <script>
      $('body').on('change', '.is_approve', function(){
          let value = $(this).val();
          let id = $(this).data('id');

          $.ajax({
              url: "{{ route('admin.change-approve-status') }}",
              method: 'PUT',
              data: {
                  value: value,
                  id: id,
              },
              success: function(data){
                  console.log(data.message)
                  // toastr.success(data.message)
                  window.location.reload();
              },
              error: function(xhr, status, error){
                  console.log(error)
              }
          })
      })
  </script>
@endpush