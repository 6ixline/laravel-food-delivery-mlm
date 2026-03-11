@extends("admin.layout.app")
@section('title')
    <title>{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Pincode</title>
@endsection
@section('content')


<!-- CONTAINER -->
@php
    error_reporting(0);
@endphp

<div class="main-container container">

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Pincode</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Pincode</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    <form name="dataform" method="post" class="form-group" action="{{ request()->get('mode') == "insert" ? route('pincodeMaster.store') : route('pincodeMaster.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="mode" value="{{ request()->get('mode') }}" />
        <input type="hidden" name="pinid" id="pinid" value="{{ request()->get('mode') == 'edit' ? $pincodeMasterRow['id'] : '' }}" />
        <div class="form-rows-custom mt-3">
          
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="pincode">Pincode *</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="pincode" id="pincode" class="form-control" value="{{ request()->get('mode') == 'edit' ? $pincodeMasterRow['pincode'] : old('pincode') }}" />
                </div>
            </div>

            
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="area">Area </label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="area" id="area" class="form-control" value="{{ request()->get('mode') == 'edit' ? $pincodeMasterRow['area'] : old('area') }}" />
                </div>
            </div>
           
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="city">City </label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="city" id="city" class="form-control" value="{{ request()->get('mode') == 'edit' ? $pincodeMasterRow['city'] : old('city') }}" />
                </div>
            </div>
           
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="state">State </label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="state" id="state" class="form-control" value="{{ request()->get('mode') == 'edit' ? $pincodeMasterRow['state'] : old('state') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="country">Country </label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="country" id="country" class="form-control" value="{{ request()->get('mode') == 'edit' ? $pincodeMasterRow['country'] : old('country') }}" />
                </div>
            </div>
            

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="remarks">Remarks</label>
                </div>
                <div class="col-sm-9">
                    <textarea name="remarks" id="remarks" class="form-control">{{ $pincodeMasterRow['remarks'] ? $pincodeMasterRow['remarks'] : old('remarks') }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="status">Status *</label>
                </div>
                <div class="col-sm-9">
                    <select name="status" id="status" class="form-control" required>
                        <option value="active" @if (request()->get('mode') == 'edit') 
                                                    @if (($pincodeMasterRow['status']) == "active") 
                                                     {{"selected"}}
                                                    @endif
                                                @endif>Active</option>
                        <option value="inactive" @if (request()->get('mode') == 'edit') 
                            @if (($pincodeMasterRow['status']) == "inactive") 
                             {{"selected"}}
                            @endif
                        @endif>Inactive</option>
                    </select>
                </div>
            </div>

            @if ((request()->get('mode') == 'edit'))
                @if ($pincodeMasterRow['userid'] != "" and $pincodeMasterRow['userid'] != "0") 
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label>Author</label>
                        </div>
                        <div class="col-sm-9">
                            <p class="text"><a href="#">{{ ($userRow['display_name']) }}</a></p>
                        </div>
                    </div>
                @endif

                @if ($pincodeMasterRow['userid_updt'] != "" and $pincodeMasterRow['userid_updt'] != "0")
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label>Author (Modified By)</label>
                        </div>
                        <div class="col-sm-9">
                            <p class="text"><a href="#">{{ ($userupdtRow['display_name']) }}</a></p>
                        </div>
                    </div>
                @endif

                {{-- <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>User's IP Address</label>
                    </div>
                    <div class="col-sm-9">
                        <p class="text">{{ ($pincodeMasterRow['user_ip']) }}</p>
                        <input type="hidden" name="user_ip" value="{{ (request()->get('mode') == 'edit') ? ($pincodeMasterRow['user_ip']) : "" }}" />
                    </div>
                </div> --}}

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>Modification Date & Time</label>
                    </div>
                    <div class="col-sm-9">
                        @if ($pincodeMasterRow['updated_at'] != "")
                            <p class="text">{{ \Carbon\Carbon::parse($pincodeMasterRow['updated_at'])->format('F d,Y \a\t H:i A') }}</p>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>Creation Date & Time</label>
                    </div>
                    <div class="col-sm-9">
                        @if ($pincodeMasterRow['created_at'] != "")
                            <p class="text">{{ \Carbon\Carbon::parse($pincodeMasterRow['created_at'])->format('F d,Y \a\t H:i A') }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <div class="row mt-4 mb-4">
                <div class="col-sm-12">
                    @if(request()->get('mode') == "insert")
                        <button type="submit" id='btnSubmit' class="btn btn-primary btn-sm"><i class="fa fa-arrow-circle-right"></i>&nbsp;&nbsp;Add</button>
                        <button type="reset" class="btn btn-sm btn-danger mx-1"><i class="fas fa-sync-alt"></i>&nbsp;&nbsp;Reset</button>
                    @elseif(request()->get('mode') == "edit")
                        <button type="submit" name="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i>&nbsp;&nbsp;Update</button>
                        {{-- <a href="register_actions.php?q=del&pid={{ $pincodeMasterRow['pid'] }}" class="btn btn-sm btn-danger mx-1" onclick="return del();"><i class="fas fa-trash"></i>&nbsp;&nbsp;Delete</a> --}}
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
<!--app-content close-->
@endsection
