@extends("admin.layout.app")
@section('title')
    <title>{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Ingredient</title>
@endsection
@section('content')


<!-- CONTAINER -->
@php
    error_reporting(0);
@endphp

<div class="main-container container">

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Ingredient</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Ingredient</li>
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



    <form name="dataform" method="post" class="form-group" action="{{ request()->get('mode') == "insert" ? route('ingredient.store') : route('ingredient.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="mode" value="{{ request()->get('mode') }}" />
        <input type="hidden" name="id" id="id" value="{{ request()->get('mode') == 'edit' ? $ingredientRow['id'] : '' }}" />
       
        <div class="form-rows-custom mt-3">
          
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="title">Item Name *</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" required name="title" id="title" class="form-control" value="{{ request()->get('mode') == 'edit' ? $ingredientRow['title'] : old('title') }}" />
                </div>
            </div>
            
          

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="unit">Unit</label>
                </div>
                <div class="col-sm-9">
                    <select name="unit" id="unit" class="form-control">

                        @php 
                          $unitArray = [
                                'kg'    => 'Kilogram',
                                'gm'    => 'Gram',
                                'liter' => 'Liter',
                                'ml'    => 'Milliliter',
                          ];
                        @endphp
                        
                        <option value="">--Select Unit--</option>
                        @foreach ($unitArray  as $id => $unit)
                            <option value="{{ $id }}" @if(request()->get('mode') == 'edit' && $ingredientRow['unit'] == $id) selected @endif>{{ $unit }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
           

           
          

            

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="status">Status *</label>
                </div>
                <div class="col-sm-9">
                    <select name="status" id="status" class="form-control" required>
                        <option value="active" @if (request()->get('mode') == 'edit') 
                                                    @if (($ingredientRow['status']) == "active") 
                                                     {{"selected"}}
                                                    @endif
                                                @endif>Active</option>
                        <option value="inactive" @if (request()->get('mode') == 'edit') 
                            @if (($ingredientRow['status']) == "inactive") 
                             {{"selected"}}
                            @endif
                        @endif>Inactive</option>
                    </select>
                </div>
            </div>

            @if ((request()->get('mode') == 'edit'))
                @if ($ingredientRow['userid'] != "" and $ingredientRow['userid'] != "0") 
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label>Author</label>
                        </div>
                        <div class="col-sm-9">
                            <p class="text"><a href="#">{{ ($userRow['display_name']) }}</a></p>
                        </div>
                    </div>
                @endif

                @if ($ingredientRow['userid_updt'] != "" and $ingredientRow['userid_updt'] != "0")
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
                        <p class="text">{{ ($ingredientRow['user_ip']) }}</p>
                        <input type="hidden" name="user_ip" value="{{ (request()->get('mode') == 'edit') ? ($ingredientRow['user_ip']) : "" }}" />
                    </div>
                </div> --}}

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>Modification Date & Time</label>
                    </div>
                    <div class="col-sm-9">
                        @if ($ingredientRow['updated_at'] != "")
                            <p class="text">{{ \Carbon\Carbon::parse($ingredientRow['updated_at'])->format('F d,Y \a\t H:i A') }}</p>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>Creation Date & Time</label>
                    </div>
                    <div class="col-sm-9">
                        @if ($ingredientRow['created_at'] != "")
                            <p class="text">{{ \Carbon\Carbon::parse($ingredientRow['created_at'])->format('F d,Y \a\t H:i A') }}</p>
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
                        {{-- <a href="register_actions.php?q=del&pid={{ $ingredientRow['pid'] }}" class="btn btn-sm btn-danger mx-1" onclick="return del();"><i class="fas fa-trash"></i>&nbsp;&nbsp;Delete</a> --}}
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

<!--app-content close-->
@endsection





