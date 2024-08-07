@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Coupon</h1> 
    </div>

    <div class="section-body"> 
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Create Coupon</h4> 
            </div>
            <div class="card-body"> 
                <form action="{{ route('admin.coupons.store')}}" method="POST" enctype="multipart/form-data">
                  @csrf 
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name')}}">
                    </div>  
                    <div class="form-group">
                        <label>Code</label>
                        <input type="text" class="form-control" name="code" value="{{ old('code')}}">
                    </div>  
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" class="form-control" name="quantity" value="{{ old('quantity')}}">
                    </div>  
                    <div class="form-group">
                        <label>Max Use Per Person</label>
                        <input type="text" class="form-control" name="max_use" value="{{ old('max_use')}}">
                    </div>  
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start date</label>
                                <input type="text" class="form-control datepicker" name="start_date" value="{{ old('start_date')}}">
                            </div>  
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End date</label>
                                <input type="text" class="form-control datepicker" name="end_date" value="{{ old('end_date')}}">
                            </div> 
                        </div>
                    </div>
                    
                     
                     
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputState">Discount type</label>
                                <select id="inputState" class="form-control" name="discount_type">
                                    <option value="percent">Percentage (%)</option>
                                    <option value="amont">Amount ({{$settings->currency_icon}})</option>
                                </select> 
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Discount value</label>
                                <input type="text" class="form-control" name="discount" value="{{ old('discount')}}">
                            </div>  
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputState">Status</label>
                        <select id="inputState" class="form-control" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select> 
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div> 
          </div>
        </div> 
      </div> 
    </div>
  </section>
@endsection 
