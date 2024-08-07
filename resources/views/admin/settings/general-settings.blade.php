<div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.general-settings-update')}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Site Name</label>
                    <input type="text" class="form-control" name="site_name" value="{{ @$generalSettings->site_name}}">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="layout" id="">
                        <option {{ @$generalSettings->layout == 'LTR' ? 'selected' : ''}} value="LTR">LTR</option>
                        <option {{ @$generalSettings->layout == 'RTL' ? 'selected' : ''}} value="RTL">RTL</option>
                    </select> 
                </div>
                <div class="form-group">
                    <label>Contact Email</label>
                    <input type="text" class="form-control" name="contact_email" value="{{ @$generalSettings->contact_email}}">
                </div>
                <div class="form-group">
                    <label>Default Currency name</label>
                    <select class="form-control select2" name="currency_name" id="">
                        <option value="">Select</option> 
                        @foreach (config('settings.currency_list') as $currency)
                            <option {{ @$generalSettings->currency_name == $currency ? 'selected' : ''}} value="{{ $currency }}">{{ $currency }}</option>                             
                        @endforeach
                    </select> 
                </div>
                <div class="form-group">
                    <label>Currency Icon</label>
                    <input type="text" class="form-control" name="currency_icon" value="{{ @$generalSettings->currency_icon}}">
                </div>
                <div class="form-group">
                    <label>Time zone</label>
                    <select class="form-control select2" name="time_zone" id="">
                        <option value="">Select</option> 
                        @foreach (config('settings.time_zone') as $key => $timeZone)
                            <option {{ @$generalSettings->time_zone == $key ? 'selected' : ''}} value="{{ $key }}">{{ $key }}</option>                             
                        @endforeach
                    </select> 
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>     
</div>