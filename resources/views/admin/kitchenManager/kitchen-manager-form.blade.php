@extends("admin.layout.app")
@section('title')
    <title>{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Kitchen Manager</title>
@endsection
@section('content')


<!-- CONTAINER -->
@php
    error_reporting(0);
@endphp

<div class="main-container container">

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Kitchen Manager</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Kitchen Manager</li>
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



    <form name="dataform" method="post" class="form-group" action="{{ request()->get('mode') == "insert" ? route('kitchenManager.store') : route('kitchenManager.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="mode" value="{{ request()->get('mode') }}" />
        <input type="hidden" name="managerid" id="managerid" value="{{ request()->get('mode') == 'edit' ? $kitchenManagerRow['id'] : '' }}" />
        <div class="form-rows-custom mt-3">
          
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="name">Name *</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" required name="name" id="name" class="form-control" value="{{ request()->get('mode') == 'edit' ? $kitchenManagerRow['name'] : old('name') }}" />
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="mobile">Mobile *</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" minlength="10" maxlength="10" required name="mobile" id="mobile" class="form-control" value="{{ request()->get('mode') == 'edit' ? $kitchenManagerRow['mobile'] : old('mobile') }}" />
                </div>
            </div>
           
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="email">Email </label>
                </div>
                <div class="col-sm-9">
                    <input type="email" name="email" id="email" class="form-control" value="{{ request()->get('mode') == 'edit' ? $kitchenManagerRow['email'] : old('email') }}" />
                </div>
            </div>
           
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="remarks">Remarks</label>
                </div>
                <div class="col-sm-9">
                    <textarea name="remarks" id="remarks" class="form-control">{{ $kitchenManagerRow['remarks'] ? $kitchenManagerRow['remarks'] : old('remarks') }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="status">Status *</label>
                </div>
                <div class="col-sm-9">
                    <select name="status" id="status" class="form-control" required>
                        <option value="active" @if (request()->get('mode') == 'edit') 
                                                    @if (($kitchenManagerRow['status']) == "active") 
                                                     {{"selected"}}
                                                    @endif
                                                @endif>Active</option>
                        <option value="inactive" @if (request()->get('mode') == 'edit') 
                            @if (($kitchenManagerRow['status']) == "inactive") 
                             {{"selected"}}
                            @endif
                        @endif>Inactive</option>
                    </select>
                </div>
            </div>

            @if ((request()->get('mode') == 'edit'))
                @if ($kitchenManagerRow['userid'] != "" and $kitchenManagerRow['userid'] != "0") 
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label>Author</label>
                        </div>
                        <div class="col-sm-9">
                            <p class="text"><a href="#">{{ ($userRow['display_name']) }}</a></p>
                        </div>
                    </div>
                @endif

                @if ($kitchenManagerRow['userid_updt'] != "" and $kitchenManagerRow['userid_updt'] != "0")
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
                        <p class="text">{{ ($kitchenManagerRow['user_ip']) }}</p>
                        <input type="hidden" name="user_ip" value="{{ (request()->get('mode') == 'edit') ? ($kitchenManagerRow['user_ip']) : "" }}" />
                    </div>
                </div> --}}

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>Modification Date & Time</label>
                    </div>
                    <div class="col-sm-9">
                        @if ($kitchenManagerRow['updated_at'] != "")
                            <p class="text">{{ \Carbon\Carbon::parse($kitchenManagerRow['updated_at'])->format('F d,Y \a\t H:i A') }}</p>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>Creation Date & Time</label>
                    </div>
                    <div class="col-sm-9">
                        @if ($kitchenManagerRow['created_at'] != "")
                            <p class="text">{{ \Carbon\Carbon::parse($kitchenManagerRow['created_at'])->format('F d,Y \a\t H:i A') }}</p>
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
                        {{-- <a href="register_actions.php?q=del&pid={{ $kitchenManagerRow['pid'] }}" class="btn btn-sm btn-danger mx-1" onclick="return del();"><i class="fas fa-trash"></i>&nbsp;&nbsp;Delete</a> --}}
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
<!--app-content close-->
@endsection
