@extends("admin.layout.app")
@section('title')
    <title>{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Category</title>
@endsection
@section('content')


<!-- CONTAINER -->
@php
    error_reporting(0);
@endphp

<div class="main-container container">

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Category</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Category</li>
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



    <form name="dataform" method="post" class="form-group" action="{{ request()->get('mode') == "insert" ? route('category.store') : route('category.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="mode" value="{{ request()->get('mode') }}" />
        <input type="hidden" name="categoryid" id="categoryid" value="{{ request()->get('mode') == 'edit' ? $categoryRow['id'] : '' }}" />
        <input type="hidden" name="kitchen_id" id="kitchen_id" value="{{ request()->get('mode') == 'edit' ? $categoryRow['kitchen_id'] : $kitchen_id }}" />
        <div class="form-rows-custom mt-3">
          
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="title">Title *</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" required name="title" id="title" class="form-control" value="{{ request()->get('mode') == 'edit' ? $categoryRow['title'] : old('title') }}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="imgName">Banner *</label>
                </div>
                <div class="col-sm-9">
                    <input type="file" name="imgName" id="imgName"  class="form-control">
                    <input type="hidden" name="old_imgName" id="old_imgName" value="{{ $categoryRow['imgName'] ? $categoryRow['imgName'] : '' }}" />
                    @if (request()->get('mode') == 'edit' and $categoryRow['imgName'] != "")
                        <div class="mt-2 links image-preview mt-2">
                            <img src="{{  asset('uploads/' . $categoryRow['imgName']) }}" title="{{ ($categoryRow['imgName']) }}" class="img-responsive mh-51" style="width: 200px;" /><br>
                            <button type="button" class="del_link mt-2"  data-old-img-id="old_imgName" ><i class="far fa-trash-alt"></i> Delete</button>
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
                    <textarea name="remarks" id="remarks" class="form-control">{{ $categoryRow['remarks'] ? $categoryRow['remarks'] : old('remarks') }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="status">Status *</label>
                </div>
                <div class="col-sm-9">
                    <select name="status" id="status" class="form-control" required>
                        <option value="active" @if (request()->get('mode') == 'edit') 
                                                    @if (($categoryRow['status']) == "active") 
                                                     {{"selected"}}
                                                    @endif
                                                @endif>Active</option>
                        <option value="inactive" @if (request()->get('mode') == 'edit') 
                            @if (($categoryRow['status']) == "inactive") 
                             {{"selected"}}
                            @endif
                        @endif>Inactive</option>
                    </select>
                </div>
            </div>

            @if ((request()->get('mode') == 'edit'))
                @if ($categoryRow['userid'] != "" and $categoryRow['userid'] != "0") 
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label>Author</label>
                        </div>
                        <div class="col-sm-9">
                            <p class="text"><a href="#">{{ ($userRow['display_name']) }}</a></p>
                        </div>
                    </div>
                @endif

                @if ($categoryRow['userid_updt'] != "" and $categoryRow['userid_updt'] != "0")
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
                        <p class="text">{{ ($categoryRow['user_ip']) }}</p>
                        <input type="hidden" name="user_ip" value="{{ (request()->get('mode') == 'edit') ? ($categoryRow['user_ip']) : "" }}" />
                    </div>
                </div> --}}

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>Modification Date & Time</label>
                    </div>
                    <div class="col-sm-9">
                        @if ($categoryRow['updated_at'] != "")
                            <p class="text">{{ \Carbon\Carbon::parse($categoryRow['updated_at'])->format('F d,Y \a\t H:i A') }}</p>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>Creation Date & Time</label>
                    </div>
                    <div class="col-sm-9">
                        @if ($categoryRow['created_at'] != "")
                            <p class="text">{{ \Carbon\Carbon::parse($categoryRow['created_at'])->format('F d,Y \a\t H:i A') }}</p>
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
                        {{-- <a href="register_actions.php?q=del&pid={{ $categoryRow['pid'] }}" class="btn btn-sm btn-danger mx-1" onclick="return del();"><i class="fas fa-trash"></i>&nbsp;&nbsp;Delete</a> --}}
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    
    $(document).ready(function() {
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

<!--app-content close-->
@endsection
