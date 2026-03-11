@extends("admin.layout.app")
@section('title')
    <title>{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Performance Bonus</title>
@endsection
@section('content')


<!-- CONTAINER -->
@php
    error_reporting(0);
@endphp

<div class="main-container container">

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Performance Bonus</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Performance Bonus</li>
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



    <form name="dataform" method="post" class="form-group" action="{{ request()->get('mode') == "insert" ? route('performanceBonus.store') : route('performanceBonus.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="mode" value="{{ request()->get('mode') }}" />
        <input type="hidden" name="pid" id="pid" value="{{ request()->get('mode') == 'edit' ? $performanceBonusRow['id'] : '' }}" />
        <div class="form-rows-custom mt-3">
          
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="title">Rank *</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="title" id="title" class="form-control" value="{{ request()->get('mode') == 'edit' ? $performanceBonusRow['title'] : old('title') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="bv_range_start">B.V. Start *</label>
                </div>
                <div class="col-sm-9">
                    <input type="number" step="any" name="bv_range_start" id="bv_range_start" class="form-control" value="{{ request()->get('mode') == 'edit' ? $performanceBonusRow['bv_range_start'] : old('bv_range_start') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="bv_range_end">B.V. End *</label>
                </div>
                <div class="col-sm-9">
                    <input type="number" step="any" name="bv_range_end" id="bv_range_end" class="form-control" value="{{ request()->get('mode') == 'edit' ? $performanceBonusRow['bv_range_end'] : old('bv_range_end') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="monthly_self_bv">Compulsory Montly Self B.V. *</label>
                </div>
                <div class="col-sm-9">
                    <input type="number" step="any" name="monthly_self_bv" id="monthly_self_bv" class="form-control" value="{{ request()->get('mode') == 'edit' ? $performanceBonusRow['monthly_self_bv'] : old('monthly_self_bv') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="incentive">Incentive (%) *</label>
                </div>
                <div class="col-sm-9">
                    <input type="number" step="any" name="incentive" id="incentive" class="form-control" value="{{ request()->get('mode') == 'edit' ? $performanceBonusRow['incentive'] : old('incentive') }}" />
                </div>
            </div>
          

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="remarks">Remarks</label>
                </div>
                <div class="col-sm-9">
                    <textarea name="remarks" id="remarks" class="form-control">{{ $performanceBonusRow['remarks'] ? $performanceBonusRow['remarks'] : old('remarks') }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="status">Status *</label>
                </div>
                <div class="col-sm-9">
                    <select name="status" id="status" class="form-control" required>
                        <option value="active" @if (request()->get('mode') == 'edit') 
                                                    @if (($performanceBonusRow['status']) == "active") 
                                                     {{"selected"}}
                                                    @endif
                                                @endif>Active</option>
                        <option value="inactive" @if (request()->get('mode') == 'edit') 
                            @if (($performanceBonusRow['status']) == "inactive") 
                             {{"selected"}}
                            @endif
                        @endif>Inactive</option>
                    </select>
                </div>
            </div>

            @if ((request()->get('mode') == 'edit'))
                @if ($performanceBonusRow['userid'] != "" and $performanceBonusRow['userid'] != "0") 
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label>Author</label>
                        </div>
                        <div class="col-sm-9">
                            <p class="text"><a href="#">{{ ($userRow['display_name']) }}</a></p>
                        </div>
                    </div>
                @endif

                @if ($performanceBonusRow['userid_updt'] != "" and $performanceBonusRow['userid_updt'] != "0")
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
                        <p class="text">{{ ($performanceBonusRow['user_ip']) }}</p>
                        <input type="hidden" name="user_ip" value="{{ (request()->get('mode') == 'edit') ? ($performanceBonusRow['user_ip']) : "" }}" />
                    </div>
                </div> --}}

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>Modification Date & Time</label>
                    </div>
                    <div class="col-sm-9">
                        @if ($performanceBonusRow['updated_at'] != "")
                            <p class="text">{{ \Carbon\Carbon::parse($performanceBonusRow['updated_at'])->format('F d,Y \a\t H:i A') }}</p>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>Creation Date & Time</label>
                    </div>
                    <div class="col-sm-9">
                        @if ($performanceBonusRow['created_at'] != "")
                            <p class="text">{{ \Carbon\Carbon::parse($performanceBonusRow['created_at'])->format('F d,Y \a\t H:i A') }}</p>
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
                        {{-- <a href="register_actions.php?q=del&pid={{ $performanceBonusRow['pid'] }}" class="btn btn-sm btn-danger mx-1" onclick="return del();"><i class="fas fa-trash"></i>&nbsp;&nbsp;Delete</a> --}}
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
<!--app-content close-->
@endsection
