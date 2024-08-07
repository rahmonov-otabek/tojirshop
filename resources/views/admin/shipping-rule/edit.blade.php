@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Shipping rule</h1> 
    </div>

    <div class="section-body"> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Update Shipping rule</h4> 
            </div>
            <div class="card-body"> 
                <form action="{{ route('admin.shipping-rule.update', $shippingRule->id)}}" method="POST" enctype="multipart/form-data">
                  @csrf 
                  @method('PUT')
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $shippingRule->name }}">
                    </div>   
                    <div class="form-group">
                        <label for="inputState">Type</label>
                        <select id="" class="form-control shipping-type" name="type">
                          <option {{ $shippingRule->type == 'min_cost' ? 'selected' : ''}} value="min_cost">Minumum Order Amount</option>
                            <option {{ $shippingRule->type == 'float_cost' ? 'selected' : ''}} value="float_cost">Flat Cost</option>
                        </select> 
                    </div>
                    <div class="form-group min_cost {{ $shippingRule->type == 'min_cost' ? '' : 'd-none'}} ">
                        <label>Minimum Amount</label>
                        <input type="text" class="form-control min_cost" name="min_cost" value="{{ $shippingRule->min_cost }}">
                    </div>  
                    <div class="form-group">
                        <label>Cost</label>
                        <input type="text" class="form-control" name="cost" value="{{ $shippingRule->cost }}">
                    </div>  
                    <div class="form-group">
                        <label for="inputState">Status</label>
                        <select id="inputState" class="form-control" name="status">
                            <option {{ $shippingRule->status == 1 ? 'selected' : ''}}  value="1">Active</option>
                            <option {{ $shippingRule->status == 0 ? 'selected' : ''}}  value="0">Inactive</option>
                        </select> 
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div> 
          </div>
        </div> 
      </div> 
    </div>
  </section>
@endsection 

@push('scripts')
    <script>
        $(document).ready(function(){
            $('body').on('change', '.shipping-type', function(){
                let value = $(this).val(); 
                
                if(value != 'min_cost'){
                    $('.min_cost').addClass('d-none')
                }else{
                    $('.min_cost').removeClass('d-none')
                }
            })
        })
    </script>
@endpush
