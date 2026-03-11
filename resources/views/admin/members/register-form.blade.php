@extends("admin.layout.app")
@section('title')
    <title>{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Members</title>
@endsection
@section('content')


<!-- CONTAINER -->
@php
    error_reporting(0);
@endphp

<div class="main-container container">

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Member</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Member</li>
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



    <form name="dataform" method="post" class="form-group" action="{{ request()->get('mode') == "insert" ? route('members.store') : route('members.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="mode" value="{{ request()->get('mode') }}" />
        <input type="hidden" name="regid" id="regid" value="{{ request()->get('mode') == 'edit' ? $registerRow['id'] : '' }}" />
        <input type="hidden" name="membership_id" id="old_membership_id" value="{{ request()->get('mode') == 'edit' ? $registerRow['membership_id'] : '' }}" />
        <input type="hidden" name="membership_id_value" id="old_membership_id_value" value="{{ request()->get('mode') == 'edit' ? $registerRow['membership_id_value'] : '' }}" />
        <input type="hidden" name="member_check" id="member_check" value="{{ request()->get('mode') == 'edit' ? $registerRow['member_check'] : '' }}" />
        <div class="form-rows-custom mt-3">
            @if(request()->get('mode') == 'edit')
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="sponsor_id">Membership ID *</label>
                    </div>
                    <div class="col-sm-9">
                        <p><b>{{ $registerRow['membership_id'] }}</b></p>
                    </div>
                </div>
            @endif

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="sponsor_id">Sponsor's ID *</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="sponsor_id" id="sponsor_id" class="form-control" value="{{ request()->get('mode') == 'edit' ? $registerRow['sponsor_id'] : old('sponsor_id') }}" onBlur="get_sponsor();" />
                    <p style="display:none;" class="mt-1 mb-0 error_cls text-left">
                        <font color="red">Please enter a valid Sponsor ID</font>
                    </p>
                    <div style="color:green;" class="mt-1 mb-0 success_cls text-left"></div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="sponsor_name">Sponsor's Name *</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="sponsor_name" id="sponsor_name" class="form-control" value="{{ request()->get('mode') == 'edit' ? $registerRow['sponsor_name'] : old('sponsor_name') }}" />
                </div>
            </div>
            <!-- <div class="row mb-3">
<div class="col-sm-3">
<label for="planid">Plan *</label>
</div>
<div class="col-sm-9">
<select NAME="planid" CLASS="form-control" ID="planid" required >
<option VALUE="">--select--</option>

</select>
</div>
</div> -->



            <!-- <div class="row mb-3">
        <div class="col-sm-3">
            <label for="member_type">Member Type</label>
        </div>
        <div class="col-sm-9">
            <select name="member_type" id="member_type" class='form-control' required>
                <option value="">--Select Member Type--</option>
                <option value="normal" <?php if ($registerRow['member_type'] == "normal") {
                                            echo "selected";
                                        } ?>>Normal</option>
                <option value="landing" <?php if ($registerRow['member_type'] == "landing") {
                                            echo "selected";
                                        } ?>>Landing</option>
                <option value="traditional" <?php if ($registerRow['member_type'] == "traditional") {
                                                echo "selected";
                                            } ?>>Traditional</option>
            </select>
        </div>
    </div> -->
    

            {{-- <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="rewardid">Designation </label>
                </div>
                <div class="col-sm-9">
                    <?php
                    $memberReId = $registerRow['rewardid'];
                    $rewardResult = $db->view("title", "mlm_rewards", "rewardid", " and rewardid = '
{$memberReId}'");

                    $rewardTitle = $rewardResult['result'][0]['title'];


                    ?>
                    <select name="rewardid" id="rewardid" class="form-control" required>
                        <option value="" <?php if (request()->get('mode') == 'edit') {
                                                if (($registerRow['rewardid']) == "") echo "selected";
                                            } ?>>--select--</option>
                        <?php
                        $rewardResult = $db->view('rewardid,title', 'mlm_rewards', 'rewardid', "and status='active'", 'order_custom asc');
                        foreach ($rewardResult['result'] as $rewardRow) {
                        ?>
                            <option VALUE="<?php echo ($rewardRow['rewardid']); ?>" <?php if (request()->get('mode') == 'edit') {
                                                                                                                        if ($rewardRow['rewardid'] == $registerRow['rewardid']) echo "selected";
                                                                                                                    } else {
                                                                                                                        if ($rewardRow['rewardid'] == '1') echo "selected";
                                                                                                                    } ?>><?php echo ($rewardRow['title']); ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div> --}}



            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="name">Name *</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="name" id="name" class="form-control" value="{{ request()->get('mode') == 'edit' ? $registerRow['name'] : old('name') }}" required />
                </div>
            </div>

            {{-- <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="last_name">Last Name</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="last_name" id="last_name" class="form-control" value="{{ request()->get('mode') == 'edit' ? $registerRow['last_name'] : old('last_name') }}" />
                </div>
            </div> --}}

            <!-- <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="username">Username</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="username" id="username" class="form-control" value="<?php if (request()->get('mode') == 'edit') echo ($registerRow['username']); ?>" />
                </div>
            </div> -->

            <!-- <div class="row mb-3">
        <div class="col-sm-3">
            <label for="father_name">Father Name</label>
        </div>
        <div class="col-sm-9">
            <input type="text" name="father_name" id="father_name" class="form-control" value="<?php if (request()->get('mode') == 'edit') echo ($registerRow['father_name']); ?>" />
        </div>
    </div> -->

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="relation_name">S/O, D/O, W/F, Spouse </label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="relation_name" id="relation_name" class="form-control" value="{{ request()->get("mode") == "edit" ? $registerRow['relation_name'] : old('relation_name') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="date_of_birth">Date of Birth</label>
                </div>
                <div class="col-sm-9">
                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ request()->get("mode") == "edit" ? $registerRow['date_of_birth'] : old('date_of_birth') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="email">Email *</label>
                </div>
                <div class="col-sm-9">
                    <input type="email" required name="email" id="email" class="form-control" value="{{ request()->get('mode') == 'edit' ? $registerRow['email'] : old("email") }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="gender">Gender</label>
                </div>
                <div class="col-sm-9">
                    <select name="gender" id="gender" class='form-control'>
                        <option value="male" <?php if ($registerRow['gender'] == "male") {
                                                    echo "selected";
                                                } ?>>Male</option>
                        <option value="female" <?php if ($registerRow['gender'] == "female") {
                                                    echo "selected";
                                                } ?>>Female</option>
                    </select>
                </div>
            </div>

            @if (request()->get('mode') == "edit")
                {{-- <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="password_text">Current Password</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="hidden" name="password_text" id="password_text" value="{{ request()->get('mode') == 'edit' ? $registerRow['password_text'] : '' }}" class="form-control" />
                        <input type="text" value="{{ request()->get('mode') == 'edit' ? $registerRow['password_text'] : '' }}" class="form-control" disabled />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="password">Password *</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="password" name="password" id="password" class="form-control" autocomplete="new-password" />
                        <input type="hidden" name="old_password" id="old_password" value="{{ request()->get('mode') == 'edit' ? $registerRow['password'] : '' }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="confirm_password">Confirm Password *</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" autocomplete="new-password" onBlur="passwordmatch();" />
                    </div>
                </div> --}}
            @endif  

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="mobile">Mobile No. *</label>
                </div>
                <div class="col-sm-9">
                    <div class="form-group text-left">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1" style="height: 31px;">+91</span>
                            <input class="form-control" name="mobile" id="mobile" type="text" placeholder="Enter 10 Digit Mobile No." aria-describedby="basic-addon1" minlength="10" maxlength="10" style="max-width: 22rem;" value="{{ request()->get('mode') == 'edit' ? $registerRow['mobile'] : old('mobile') }}" <?php if ($registerRow['mobile'] != "") ?> required />

                            <!-- <input class="form-control" name="mobile" id="mobile" type="text" placeholder="Enter 10 Digit Mobile No." aria-describedby="basic-addon1" onkeypress="return isNumberKey(event)" minlength="10" maxlength="10" style="max-width: 266px;" value="<?php if (request()->get('mode') == 'edit') echo ($registerRow['mobile']); ?>" <?php if ($registerRow['mobile'] != "") { ?> readonly <?php } ?> required /> -->
                            <?php if ($registerRow['mobile'] == "") { ?>
                                <!-- <button type="button" id="otp" onclick="return sms_send();" class="btn btn-primary btn-block w-auto btn_custom" style="padding: 0px 8px; font-size: 13px;">Send OTP</button> -->
                            <?php } ?>
                        </div>
                        <span class="otp_success" style="color:green;display:none;"><i class="fa fa-check"></i> OTP Sent Successfully!</span>
                        <span class="otp_failure" style="color:red;display:none;"><i class="fa fa-times"></i> Please enter a valid number!</span>
                    </div>
                </div>
            </div>

            <div class="row mb-3 verification_code_area" style="display:none;">
                <div class="col-sm-3">
                    <label for="mobile">Verification Code</label>
                </div>
                <div class="col-sm-9">
                    <div class="">
                        <div class="input-group">
                            <input class="form-control" name="verification_code" id="verification_code" type="text" onkeypress="return isNumberKey(event)" minlength="5" maxlength="5" class="w-50" style="max-width: 266px;" />
                            <button type="button" id="otp_verify" onclick="return sms_otpverify();" class="btn btn-primary btn-block w-auto btn_custom" style="padding: 0px 8px; font-size: 13px;">Verify</button>
                        </div>
                    </div>
                    <span class="otp_verified" style="color:green;display:none;"><i class="fa fa-check"></i> Verified!</span>
                    <span class="otp_verification_failed" style="color:red;display:none;"><i class="fa fa-times"></i> Please enter correct OTP!</span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="mobile_alter">Mobile No. (Alternative)</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="mobile_alter" id="mobile_alter" class="form-control" value="{{ request()->get('mode') == 'edit' ? $registerRow['mobile_alter'] : old('mobile_alter') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="address">Address *</label>
                </div>
                <div class="col-sm-9">
                    <input required type="text" name="address" id="address" class="form-control" value="{{ $registerRow['address'] ? $registerRow['address'] : old('address') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="pincode">Pincode *</label>
                </div>
                <div class="col-sm-9">
                    <input required type="number" name="pincode" id="pincode" class="form-control" value="{{ $registerRow['pincode'] ? $registerRow['pincode'] : old('pincode') }}" />
                </div>
            </div>

            <h5 class="mb-4 mt-5 bg-info p-3 text-light">Nominee Details</h5>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="nominee_name">Name </label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="nominee_name" id="nominee_name" class="form-control" value="{{ $registerRow['nominee_name'] ? $registerRow['nominee_name'] : old('nominee_name') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="nominee_relation">Relation</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="nominee_relation" id="nominee_relation" class="form-control" value="{{ $registerRow['nominee_relation'] ? $registerRow['nominee_relation'] : old('nominee_relation') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="nominee_age">Age</label>
                </div>
                <div class="col-sm-9">
                    <input type="number" name="nominee_age" id="nominee_age" class="form-control" value="{{ $registerRow['nominee_age'] ? $registerRow['nominee_age'] : old('nominee_age') }}" />
                </div>
            </div>

            <h5 class="mb-4 mt-5 text-light p-3 bg-info">Bank Details</h5>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="bank_name">Bank Name</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="bank_name" id="bank_name" class="form-control" value="{{ request()->get('mode') == 'edit' ? ($registerRow['bank_name']) : old('bank_name') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="branch_name">Branch Name</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="branch_name" id="branch_name" class="form-control" value="{{ request()->get('mode') == 'edit' ? ($registerRow['branch_name']) : old('branch_name') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="account_number">Account Number</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="account_number" id="account_number" class="form-control" value="{{ request()->get('mode') == 'edit' ? $registerRow['account_number'] : old('account_number') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="ifsc_code">Bank Swift/IFSC Code</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="ifsc_code" id="ifsc_code" class="form-control" value="{{ request()->get('mode') == 'edit' ? $registerRow['ifsc_code'] : old('ifsc_code') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="account_name">Account Holder Name</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="account_name" id="account_name" class="form-control" value="{{ request()->get('mode') == 'edit' ? $registerRow['account_name'] : old('account_name') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="bankdoc">Cancel Cheque Image(s)</label>
                </div>
                <div class="col-sm-9">
                    <input type="file" name="bankdoc[]" id="bankdoc" multiple />
                    <input type="hidden" name="old_bankdoc" id="old_bankdoc" value="{{ ($registerRow['bankdoc']) }}" />
                    @if ($registerRow['bankdoc'] != "")
                        <div class="mt-2 links d-flex gap-2">
                            <?php
                            $imgName = json_decode($registerRow['bankdoc']);
                            foreach ($imgName as $img) {
                            ?>
                                <div class="image-preview">
                                    <a href="{{ asset('uploads/' . $img) }}" target="_blank"><img src="{{ asset('uploads/' . $img) }}" title="{{$img}}" alt="{{$img}}" style="width: 100px;" class="image-preview-img" /></a><Br />
                                    {{-- <?php if ($members_per['d'] == "1") { ?><a href="register_form.php?mode=edit&regid=<?php echo $regid; ?>&bankdoc=<?php echo $img; ?>&q=bankdel" class="del_link" onClick="return del();">Delete</a><?php } ?> --}}
                                    <button type="button" class="del_muli_link" data-img="{{$img}}" data-old-img-id="old_bankdoc" >Delete</button>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    @endif
                    <em class="d-block mt-1">File should be Image and size under<br>Image extension should be .jpg, .jpeg, .png, .gif<br>Hold "Ctrl" key for multi-selection</em>
                </div>
            </div>


            <h5 class="mb-4 mt-5 bg-info text-light p-3">KYC Details</h5>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="pan_card">Pan Card</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="pan_card" id="pan_card" class="form-control" value="{{ $registerRow['pan_card'] ? $registerRow['pan_card'] : old('pan_card') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="panImage">Pan Card Document Image(s)</label>
                </div>
                <div class="col-sm-9">
                    <input type="file" name="panImage[]" id="panImage" multiple />
                    <input type="hidden" name="old_panImage" id="old_panImage" value="{{ $registerRow['panImage'] ? $registerRow['panImage'] : old('panImage') }}" />
                    @if ($registerRow['panImage'] != "")
                        <div class="mt-2 links d-flex gap-2">
                            <?php
                            $imgName = json_decode($registerRow['panImage']);
                            foreach ($imgName as $img) {
                            ?>
                                <div class="image-preview">
                                    <a href="{{ asset('uploads/' . $img) }}" target="_blank"><img src="{{ asset('uploads/' . $img) }}" title="{{ $img }}" alt="{{ $img }}" style="width: 100px;" class="image-preview-img" /></a><Br />
                                  
                                    <button type="button" class="del_muli_link" data-img="{{$img}}" data-old-img-id="old_panImage" >Delete</button>

                                </div>

                            <?php
                            }
                            ?>
                        </div>
                    @endif
                    <em class="d-block mt-1">File should be Image and size under <br>Image extension should be .jpg, .jpeg, .png, .gif<br>Hold "Ctrl" key for multi-selection</em>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="aadhar_card">Aadhaar Card </label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="aadhar_card" id="aadhar_card" class="form-control" value="{{ $registerRow['aadhar_card'] ? $registerRow['aadhar_card'] : old('aadhar_card') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="kycdoc">Aadhaar Card Document Image(s)</label>
                </div>
                <div class="col-sm-9">
                    <input type="file" name="kycdoc[]" id="kycdoc" multiple />
                    <input type="hidden" name="old_kycdoc" id="old_kycdoc" value="{{ $registerRow['kycdoc'] ? $registerRow['kycdoc'] : old('kycdoc') }}" />
                    @if ($registerRow['kycdoc'] != "")
                        <div class="mt-2 links d-flex gap-2">
                            <?php
                            $imgName = json_decode($registerRow['kycdoc']);
                            foreach ($imgName as $img) {
                            ?>
                                <div class="image-preview">
                                    <a href="{{ asset('uploads/' . $img) }}" target="_blank"><img src="{{ asset('uploads/' . $img) }}" title="{{ $img }}" alt="{{ $img }}" style="width: 100px;" class="image-preview-img" /></a><Br />
                                    {{-- <?php if ($members_per['d'] == "1") { ?><a href="register_form.php?mode=edit&regid=<?php echo $regid; ?>&kycdoc=<?php echo $img; ?>&q=kycdoc" class="del_link" onClick="return del();">Delete</a><?php } ?> --}}
                                    <button type="button" class="del_muli_link" data-img="{{$img}}" data-old-img-id="old_kycdoc" >Delete</button>
                                </div>

                            <?php
                            }
                            ?>
                        </div>
                    @endif
                    <em class="d-block mt-1">File should be Image and size under<br>Image extension should be .jpg, .jpeg, .png, .gif<br>Hold "Ctrl" key for multi-selection</em>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="imgName">Profile Picture</label>
                </div>
                <div class="col-sm-9">
                    <input type="file" name="imgName" id="imgName">
                    <input type="hidden" name="old_imgName" id="old_imgName" value="{{ $registerRow['imgName'] ? $registerRow['imgName'] : '' }}" />
                    @if (request()->get('mode') == 'edit' and $registerRow['imgName'] != "")
                        <div class="mt-2 links image-preview">
                            <img src="{{  asset('uploads/' . $registerRow['imgName']) }}" title="{{ ($registerRow['imgName']) }}" class="img-responsive mh-51" style="width: 100px;" /><br>
                            {{-- <a href="{{ IMG_MAIN_LOC . ($registerRow['imgName']) }}" target="_blank">Click to Download</a> | @if ($members_per['d'] == "1") <a href="register_form.php?mode=edit&regid={{ $regid}}&q=imgdel" onClick="return del();">Delete</a> @endif --}}
                            <button type="button" class="del_link"  data-old-img-id="old_kycdoc" >Delete</button>
                        
                        </div>
                    @endif
                    <em class="d-block mt-1">File should be Image and size under<br>Image extension should be .jpg, .jpeg, .png, .gif</em>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="remarks">Remarks</label>
                </div>
                <div class="col-sm-9">
                    <textarea name="remarks" id="remarks" class="form-control">{{ $registerRow['remarks'] ? $registerRow['remarks'] : old('remarks') }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="status">Status *</label>
                </div>
                <div class="col-sm-9">
                    <select name="status" id="status" class="form-control" required>
                        <option value="active" @if (request()->get('mode') == 'edit') 
                                                    @if (($registerRow['status']) == "active") 
                                                     {{"selected"}}
                                                    @endif
                                                @endif>Active</option>
                        <option value="inactive" @if (request()->get('mode') == 'edit') 
                            @if (($registerRow['status']) == "inactive") 
                             {{"selected"}}
                            @endif
                        @endif>Inactive</option>
                    </select>
                </div>
            </div>

            @if ((request()->get('mode') == 'edit'))
                @if ($registerRow['userid'] != "" and $registerRow['userid'] != "0") 
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label>Author</label>
                        </div>
                        <div class="col-sm-9">
                            <p class="text"><a href="#">{{ ($userRow['display_name']) }}</a></p>
                        </div>
                    </div>
                @endif

                @if ($registerRow['userid_updt'] != "" and $registerRow['userid_updt'] != "0")
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
                        <p class="text">{{ ($registerRow['user_ip']) }}</p>
                        <input type="hidden" name="user_ip" value="{{ (request()->get('mode') == 'edit') ? ($registerRow['user_ip']) : "" }}" />
                    </div>
                </div> --}}

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>Modification Date & Time</label>
                    </div>
                    <div class="col-sm-9">
                        @if ($registerRow['updated_at'] != "")
                            <p class="text">{{ \Carbon\Carbon::parse($registerRow['updated_at'])->format('F d,Y \a\t H:i A') }}</p>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>Creation Date & Time</label>
                    </div>
                    <div class="col-sm-9">
                        @if ($registerRow['created_at'] != "")
                            <p class="text">{{ \Carbon\Carbon::parse($registerRow['created_at'])->format('F d,Y \a\t H:i A') }}</p>
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
                        {{-- <a href="register_actions.php?q=del&regid={{ $registerRow['regid'] }}" class="btn btn-sm btn-danger mx-1" onclick="return del();"><i class="fas fa-trash"></i>&nbsp;&nbsp;Delete</a> --}}
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
<!--app-content close-->

<script>
    function get_sponsor() {
        if($("#sponsor_id").val()){
            $.ajax({
                type: 'post',
                url: '{{ route("fetch.member") }}',
                data: {
                    sponsor_id: $("#sponsor_id").val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response == "no") {
                        $(".error_cls").show();
                        $("#sponsor_id").val("");
                        $("#sponsor_name").val("");
                    } else {
                        $("#sponsor_name").val(response.name);
                        $(".error_cls").hide();
                    }
                },
                error: function(xhr, status, error) {
                        $(".error_cls").show();
                        $("#sponsor_id").val("");
                        $("#sponsor_name").val("");
                    }
            });
        }
    }
    $(document).ready(function() {
        get_sponsor();
    });


    // oldImg,type
   

    $(document).ready(function() {

     //   Keep parent div name this ( image-preview )
      $('.del_muli_link').click(function() {

        let userConfirmation = confirm("Are you sure you want to Delete?");

        if(userConfirmation){
            let parentDiv =  $(this).parent('.image-preview');
            let img = $(this).data('img');
            let oldImgId = $(this).data('old-img-id');
             
            let oldImg = $('#'+oldImgId);

        
            // console.log(oldImg.val());
            let arr = JSON.parse(oldImg.val());
          
            // Find the index of the value
            let index = arr.indexOf(img);

            if ( Array.isArray(arr) && index !== -1) {
                // Remove the value at the found index
                arr.splice(index, 1);

                oldImg.val(JSON.stringify(arr));
                parentDiv.hide();
            } 
        }

      });

     //   Keep parent div name this ( image-preview )
      $('.del_link').click(function() {
        let userConfirmation = confirm("Are you sure you want to Delete?");

        if(userConfirmation){
            let parentDiv =  $(this).parent('.image-preview');

            let oldImgId = $(this).data('old-img-id');
            let oldImg = $('#'+oldImgId);

            oldImg.val('');
            parentDiv.hide();
        }
      });


      




    });
</script>
@endsection
