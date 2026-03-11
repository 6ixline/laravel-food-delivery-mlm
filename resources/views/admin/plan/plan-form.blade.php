@extends("admin.layout.app")
@section('title')
    <title>Plan Setting</title>
@endsection
@section('content')
<!-- CONTAINER -->
<?php
    error_reporting(0);
?>

<div class="main-container container">

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Plan Setting</li>
            </ol>
        </div>
    </div>
    <h1 class="bg-primary p-2 text-light mb-4" style="font-size: 18px;">Plan Setting</h1>

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



    <form name="dataform" method="post" class="form-group" action="{{ request()->get('mode') == "insert" ? "" : route('plan.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="mode" value="{{ request()->get('mode') }}" />
        <input type="hidden" name="planid" id="planid" value="{{ request()->get('mode') == 'edit' ? $planRow['id'] : '' }}" />
       
        <div class="form-rows-custom mt-3">
           
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="tds">Admin Charges (%)</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" required name="tds" id="tds" class="form-control" value="{{ request()->get('mode') == 'edit' ? $planRow['tds'] : old('tds') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="activation_reward_point">Activation Reward Point</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="activation_reward_point" id="activation_reward_point" class="form-control" value="{{ request()->get('mode') == 'edit' ? $planRow['activation_reward_point'] : old('activation_reward_point') }}" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="direct_referral_per">Direct Referral (%)</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="direct_referral_per" id="direct_referral_per" class="form-control" value="{{ request()->get('mode') == 'edit' ? $planRow['direct_referral_per'] : old('direct_referral_per') }}" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="minimum_order">Minimum Order (Rs.)</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="minimum_order" id="minimum_order" class="form-control" value="{{ request()->get('mode') == 'edit' ? $planRow['minimum_order'] : old('minimum_order') }}" />
                </div>
            </div>
           

            <div class="row mt-4 mb-4">
                <div class="col-sm-12">
                    @if(request()->get('mode') == "insert")
                        <button type="submit" id='btnSubmit' class="btn btn-primary btn-sm"><i class="fa fa-arrow-circle-right"></i>&nbsp;&nbsp;Add</button>
                        <button type="reset" class="btn btn-sm btn-danger mx-1"><i class="fas fa-sync-alt"></i>&nbsp;&nbsp;Reset</button>
                    @elseif(request()->get('mode') == "edit")
                        <button type="submit" name="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i>&nbsp;&nbsp;Submit</button>
                        {{-- <a href="register_actions.php?q=del&regid={{ $planRow['regid'] }}" class="btn btn-sm btn-danger mx-1" onclick="return del();"><i class="fas fa-trash"></i>&nbsp;&nbsp;Delete</a> --}}
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
<!--app-content close-->
@endsection
