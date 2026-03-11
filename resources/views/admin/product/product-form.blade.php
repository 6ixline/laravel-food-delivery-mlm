@extends("admin.layout.app")
@section('title')
    <title>{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Product</title>
@endsection
@section('content')

@php $ingredient_string = ''; @endphp

@if (!empty($ingredients) && $ingredients->count() > 0)
    @foreach ($ingredients as $ingredient)
        @php
            $ingredient_string .= '<option value="' . $ingredient->id . '" data-unit="' . $ingredient->unit . '">' . ucwords($ingredient->title) . '</option>';
        @endphp
    @endforeach
@endif


<textarea style="display:none;"  id="ingredient_option" cols="30" rows="10"> {!!$ingredient_string!!}    
</textarea> 




<script>

    

    function add_items() {
            var rowCount = $('#itmes_table tbody tr').length;
            var ingredient_option = $('#ingredient_option').val();
            if (rowCount <= 0) {
                $("#itmes_table tbody").html(
                    `<tr><td> <input type="hidden" readonly step="any" name="unit[]" id="unit" class="form-control" /> <select name="items_name[]" id="items_name"  class="items_name form-control" required><option value="">--select items --</option>` +
                    ingredient_option + `</select> </td><td> <div class="d-flex"><input type="number" step="any" name="qty[]" id="qty" class="form-control" /> <div class="unit_box">  </div> </div></td>  <td class='text-center align-middle'><a href='javascript:void(0);' class='delete_items text-danger' data-toggle='tooltip' data-placement='top' title='Remove'><i class='far fa-trash-alt text-danger'></i></a></td></tr>`
                );
            } else {
                $("#itmes_table tbody tr:last").after(
                    `<tr><td> <input type="hidden" readonly step="any" name="unit[]" id="unit" class="form-control" /> <select name="items_name[]" id="items_name"  class="items_name form-control" required><option value="">--select items --</option>` +
                    ingredient_option + `</select> </td><td> <div class="d-flex"><input type="number" step="any" name="qty[]" id="qty" class="form-control" /> <div class="unit_box">  </div></div> </td><td class='text-center align-middle'><a href='javascript:void(0);' class='delete_items text-danger' data-toggle='tooltip' data-placement='top' title='Remove'><i class='far fa-trash-alt text-danger'></i></a></td></tr>`
                )
            }
    }

     

    function delete_items() {
        $("#itmes_table tbody tr:last").remove();
    }

    $(document).ready(function () {
        $("#itmes_table").on('click', '.delete_items', function () {
            $(this).parent().parent().remove();
        });
    });
    // function add_variant() {
    //     var rowCount = $('#variants_table tbody tr').length;
    //     if (rowCount <= 0) {
    //         $("#variants_table tbody").html(`<tr><td><input type="text" name="title[]" id="title" class="form-control" /></td><td><input type="number" step="any" name="mrp[]" id="mrp" class="form-control" /></td><td><input type="number" name="price[]" id="price" class="form-control" /></td><td><input type="number" step="any" name="business_volume[]" id="business_volume" class="form-control" /></td><td class='text-center align-middle'><a href='javascript:void(0);' class='delete_variant text-danger' data-toggle='tooltip' data-placement='top' title='Remove'><i class='far fa-trash-alt text-danger'></i></a></td></tr>`);
    //     }
    //     else {
    //         $("#variants_table tbody tr:last").after(`<tr><td><input type="text" name="title[]" id="title" class="form-control" /></td><td><input type="number" step="any" name="mrp[]" id="mrp" class="form-control" /></td><td><input type="number" name="price[]" id="price" class="form-control" /></td><td><input type="number" step="any" name="business_volume[]" id="business_volume" class="form-control" /></td><td class='text-center align-middle'><a href='javascript:void(0);' class='delete_variant text-danger' data-toggle='tooltip' data-placement='top' title='Remove'><i class='far fa-trash-alt text-danger'></i></a></td></tr>`)
    //     }
    // }

    // function delete_variant() {
    //     $("#variants_table tbody tr:last").remove();
    // }

    // $(document).ready(function () {
    //     $("#variants_table").on('click', '.delete_variant', function () {
    //         $(this).parent().parent().remove();
    //     });
    // });
</script>

<!-- CONTAINER -->
@php
    error_reporting(0);
@endphp

<div class="main-container container">

    
        <style>
            .unit_box {
                width: 50px;
                height: 35px;
                /* background: #fff; */
                color: #222;
                font-weight: 500;
                font-size: 15px;
                /* border: 1px solid #ccc; */
                border-radius: 8px;
                display: flex;
                justify-content: center;
                align-items: center;

            }
        </style>

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Food Item</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ request()->get('mode') == "insert" ? "Add New" : "Update" }} Food Item</li>
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



    <form name="dataform" method="post" class="form-group" action="{{ request()->get('mode') == "insert" ? route('product.store') : route('product.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="mode" value="{{ request()->get('mode') }}" />
        <input type="hidden" name="productid" id="productid" value="{{ request()->get('mode') == 'edit' ? $productRow['id'] : '' }}" />
        <input type="hidden" name="kitchen_id" id="kitchen_id" value="{{ request()->get('mode') == 'edit' ? $productRow['kitchen_id'] : $kitchen_id }}" />
        <div class="form-rows-custom mt-3">

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="category_id">Category *</label>
                </div>
                <div class="col-sm-9">
                    <select name="category_id" required class="form-control category_id" id="category_id">
                        <option value="">--Select Category--</option>
                        @foreach ($allCategory as $category_id => $title)
                            <option value="{{ $category_id }}" @if(request()->get('mode') == 'edit' && $productRow['category_id'] == $category_id ) selected @endif>{{ $title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
          
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="name">Name *</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" required name="name" id="name" class="form-control" value="{{ request()->get('mode') == 'edit' ? $productRow['name'] : old('name') }}" />
                </div>
            </div>


           
            {{-- <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="ingredients">Ingredients</label>
                </div>
                <div class="col-sm-9">
                    <input id="ingredients" name="ingredients" class="form-control" value ="{{ request()->get('mode') == 'edit' ? $productRow['ingredients'] : old('ingredients') }}" />
                    <i><small>Enter Ingredients comma (,) seperated</small></i>
                </div>
            </div> --}}

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="description">Description</label>
                </div>
                <div class="col-sm-9">
                    <textarea id="description" name="description" class="form-control">{{ request()->get('mode') == 'edit' ? $productRow['description'] : old('description') }}</textarea>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="pricing_mode">Pricing Mode*</label>
                </div>
                <div class="col-sm-9">
                    <select class="form-control" name="pricing_mode" id="pricing_mode">
                        <option value="qty" @if(request()->get('mode') == 'edit' && $productRow['pricing_mode'] == "qty" ) selected @endif>QTY</option>
                        <option value="variant" @if(request()->get('mode') == 'edit' && $productRow['pricing_mode'] == "variant" ) selected @endif>VARIANT</option>
                    </select>   
                </div>
            </div>


            <div class=' qty'>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="mrp">MRP *</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" step="any" required name="product_mrp" id="product_mrp" class="form-control" value="{{ request()->get('mode') == 'edit' ? $productRow['mrp'] : old('mrp') }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="price">Price *</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" step="any" required name="product_price" id="product_price" class="form-control" value="{{ request()->get('mode') == 'edit' ? $productRow['price'] : old('price') }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="business_volume">Business Volume (B.V.) *</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" step="any" required name="product_business_volume" id="business_volume" class="form-control" value="{{ request()->get('mode') == 'edit' ? $productRow['business_volume'] : old('business_volume') }}" />
                    </div>
                </div>
            </div>


             


            <div class="variant">
                <h5 class='bg-green p-3 text-light'>Ingredient</h5>
                <fieldset class="scheduler-border background-light approved-section"
                    style='max-width: 100%;'>

                    <table class="table variants" id="itmes_table">
                        <thead class='bg-info'>
                            <tr>
                                <th class='text-light'>Item Name</th>
                                <th class='text-light'>Unit</th>
                                <th class='text-light'>QTY</th>
                                <th class='text-light'></th>
                            </tr>
                        </thead>
                        <tbody class='bg-light' id='itmes_details'>
                            
                                 @if (request()->get('mode') == 'insert')
                                    <tr>
                                        <td>
                                            <input type="hidden" readonly step="any" name="unit[]" id="unit"
                                                class="form-control" />
                                            <select name="items_name[]" id="items_name" class="items_name form-control"
                                                required>
                                                <option value="">--select items --</option>
                                                {!! $ingredient_string !!}
                                            </select>
                                        </td>


                                        <td>
                                            <div class="d-flex"><input type="number" step="any" name="qty[]"
                                                    id="qty" class="form-control" />
                                                <div class="unit_box">
                                                </div>
                                            </div>


                                        </td>






                                        <td class="text-center align-middle"></td>
                                    </tr>
                                @elseif(request()->get('mode') == 'edit')
                                    @foreach ($productIngredientRows as $productIngredientRow)
                                        <tr>
                                            <td>
                                                <input type="hidden" readonly step="any" name="unit[]"
                                                    id="unit" class="form-control"
                                                    value="{{ $productIngredientRow->unit }}" />
                                                <input type="hidden" readonly step="any"
                                                    name="product_ingredient_id[]" id="product_ingredient_id"
                                                    class="form-control" value="{{ $productIngredientRow->id }}" />

                                                <select name="items_name[]" id="items_name"
                                                    class="items_name form-control" required>
                                                    <option value="">--select items --</option>

                                                    @if (!empty($ingredients) && $ingredients->count() > 0)
                                                        @foreach ($ingredients as $ingredient)
                                                            <option value="{{ $ingredient->id }}"
                                                                @if ($productIngredientRow['ingredients_id'] == $ingredient->id) {{ 'selected' }} @endif
                                                                data-unit="{{ $ingredient->unit }}">
                                                                {{ ucwords($ingredient->title) }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>


                                            <td>
                                                <div class="d-flex">
                                                    <input type="number" step="any" name="qty[]" id="qty"
                                                        class="form-control" value="{{ $productIngredientRow->qty }}" />
                                                    <div class="unit_box">
                                                    </div>
                                                </div>

                                            </td>



                                            <td class="text-center align-middle"><a href="javascript:void(0);"
                                                    class="delete_items text-danger"><i
                                                        class="far fa-trash-alt text-danger"></i></a></td>
                                        </tr>
                                    @endforeach
                                @endif
                        </tbody>
                    </table>
 {{-- add_items
          delete_items              
               delete_items         --}}

                    <a href="javascript:void(0);" onClick="add_items();"
                        class='btn btn-primary btn-sm float-right' style="float:right;">Add More</a>

                </fieldset>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="imgName">Product Image *</label>
                </div>
                <div class="col-sm-9">
                    <input type="file" name="imgName" id="imgName"  class="form-control">
                    <input type="hidden" name="old_imgName" id="old_imgName" value="{{ $productRow['imgName'] ? $productRow['imgName'] : '' }}" />
                    @if (request()->get('mode') == 'edit' and $productRow['imgName'] != "")
                        <div class="mt-2 links image-preview mt-2">
                            <img src="{{  asset('uploads/' . $productRow['imgName']) }}" title="{{ ($productRow['imgName']) }}" class="img-responsive mh-51" style="width: 200px;" /><br>
                            <button type="button" class="del_link mt-2"  data-old-img-id="old_imgName" ><i class="far fa-trash-alt"></i> Delete</button>
                        </div>
                    @endif
                    <em class="d-block mt-1">File should be Image and size under<br>Image extension should be .jpg, .jpeg, .png, .gif</em>
                </div>
            </div>
            
            
            {{-- <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="remarks">Remarks</label>
                </div>
                <div class="col-sm-9">
                    <textarea name="remarks" id="remarks" class="form-control">{{ $productRow['remarks'] ? $productRow['remarks'] : old('remarks') }}</textarea>
                </div>
            </div> --}}

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="isShowOnHome">Show On Home</label>
                </div>
                <div class="col-sm-9">
                    <input type="checkbox" name="isShowOnHome" id="isShowOnHome" class="" {{ request()->get('mode') == 'edit' && $productRow['isShowOnHome'] ? "checked" : (old('isShowOnHome') ? "checked" : "") }}>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="status">Status *</label>
                </div>
                <div class="col-sm-9">
                    <select name="status" id="status" class="form-control" required>
                        <option value="active" @if (request()->get('mode') == 'edit') 
                                                    @if (($productRow['status']) == "active") 
                                                     {{"selected"}}
                                                    @endif
                                                @endif>Active</option>
                        <option value="inactive" @if (request()->get('mode') == 'edit') 
                            @if (($productRow['status']) == "inactive") 
                             {{"selected"}}
                            @endif
                        @endif>Inactive</option>
                    </select>
                </div>
            </div>

            @if ((request()->get('mode') == 'edit'))
                @if ($productRow['userid'] != "" and $productRow['userid'] != "0") 
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label>Author</label>
                        </div>
                        <div class="col-sm-9">
                            <p class="text"><a href="#">{{ ($userRow['display_name']) }}</a></p>
                        </div>
                    </div>
                @endif

                @if ($productRow['userid_updt'] != "" and $productRow['userid_updt'] != "0")
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
                        <p class="text">{{ ($productRow['user_ip']) }}</p>
                        <input type="hidden" name="user_ip" value="{{ (request()->get('mode') == 'edit') ? ($productRow['user_ip']) : "" }}" />
                    </div>
                </div> --}}

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>Modification Date & Time</label>
                    </div>
                    <div class="col-sm-9">
                        @if ($productRow['updated_at'] != "")
                            <p class="text">{{ \Carbon\Carbon::parse($productRow['updated_at'])->format('F d,Y \a\t H:i A') }}</p>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>Creation Date & Time</label>
                    </div>
                    <div class="col-sm-9">
                        @if ($productRow['created_at'] != "")
                            <p class="text">{{ \Carbon\Carbon::parse($productRow['created_at'])->format('F d,Y \a\t H:i A') }}</p>
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
                        {{-- <a href="register_actions.php?q=del&pid={{ $productRow['pid'] }}" class="btn btn-sm btn-danger mx-1" onclick="return del();"><i class="fas fa-trash"></i>&nbsp;&nbsp;Delete</a> --}}
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

        $("#pricing_mode").on("change", handlePricingMode);
    });

    function handlePricingMode(){
        debugger
        let pricing_mode = $("#pricing_mode").val();

        if(pricing_mode == "qty"){

            $(".variant").show();
            $(".qty").show();
           
            $(".variant input").attr("required", true);
            $(".qty input").attr("required", true);
            let rowCount = $('#variants_table tbody tr').length;

            if(rowCount == 0){
                // add_variant();
            }
           
           

        }else if(pricing_mode == "variant"){

            
            $(".variant").hide();
            $(".qty").hide();
            $(".variant input").removeAttr("required");
            $(".variant select").removeAttr("required");
            $(".qty input").removeAttr("required");
        
            
           
        }else{
            $(".variant").hide();
            $(".qty").hide();
            $(".qty input").removeAttr("required");
            $(".variant input").removeAttr("required");
        }
    }

</script>

<script>
    $(document).on('change', '.items_name', function () {
    let unit = $(this).find('option:selected').data('unit');
    // console.log('Selected Unit:', unit); // see if unit is found

    const unitArray = {
            kg: 'Kilogram',
            gm: 'Gram',
            liter: 'Liter',
            ml: 'Milliliter'
    };

    let unit_value = '';

    if(unit != ''){
        unit_value = unitArray[unit];
    }
  let unitInput = $(this).parent().find('input[name="unit[]"]');

            let unitBox = $(this).closest('tr').children('td').eq(1).find('.unit_box');
            unitInput.val(unit);
            unitBox.text(unit)
            console.log('Input found:', unitInput.val(unit)); // verify input is found

 
});
</script>

<!--app-content close-->
@endsection
