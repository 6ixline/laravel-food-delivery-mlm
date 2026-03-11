@extends('admin.layout.app')
@section('title')
    <title>{{ request()->get('mode') == 'insert' ? 'Add New' : 'Update' }} Product</title>
@endsection
@section('content')


    @php $ingredient_string = ''; @endphp

    @if (!empty($ingredients) && $ingredients->count() > 0)
        @foreach ($ingredients as $ingredient)
            @php
                $ingredient_string .=
                    '<option value="' .
                    $ingredient->id .
                    '" data-unit="' .
                    $ingredient->unit .
                    '">' .
                    ucwords($ingredient->title) .
                    '</option>';
            @endphp
        @endforeach
    @endif





    <textarea style="display:none;" id="ingredient_option" cols="30" rows="10"> {!! $ingredient_string !!}    
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

        $(document).ready(function() {
            $("#itmes_table").on('click', '.delete_items', function() {
                $(this).parent().parent().remove();
            });
        });
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
            <h1 class="page-title">{{ request()->get('mode') == 'insert' ? 'Add New' : 'Update' }} Food Variant</h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ request()->get('mode') == 'insert' ? 'Add New' : 'Update' }} Food Item</li>
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



        <form name="dataform" method="post" class="form-group"
            action="{{ request()->get('mode') == 'insert' ? route('productVariant.store') : route('productVariant.update') }}"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="mode" value="{{ request()->get('mode') }}" />

            {{-- Product Id  --}}
            <input type="hidden" name="productid" id="productid"
                value="{{ request()->get('mode') == 'edit' ? $productVariantsRow['product_id'] : request()->get('productid') }}" />

            {{-- Variant Id --}}
            <input type="hidden" name="variantid" id="variantid"
                value="{{ request()->get('mode') == 'edit' ? $productVariantsRow['id'] : request()->get('id') }}" />

            {{-- Kitchen Id --}}
            <input type="hidden" name="kitchen_id" id="kitchen_id" value="{{ request()->get('kitchen_id') }}" />
            <div class="form-rows-custom mt-3">



                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="name">Title *</label>
                    </div>
                    <div class="col-sm-9">

                        <input type="text" required name="title" id="title"
                            value="{{ request()->get('mode') == 'edit' ? $productVariantsRow['title'] : old('title') }}"
                            class="form-control" />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="name">MRP *</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" step="any" name="mrp" id="mrp"
                            value="{{ request()->get('mode') == 'edit' ? $productVariantsRow['mrp'] : old('mrp') }}"
                            class="form-control" />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="ingredients">Price</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" name="price" id="price"
                            value="{{ request()->get('mode') == 'edit' ? $productVariantsRow['price'] : old('price') }}"
                            class="form-control" />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="description">Business Volume (B.V.)</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" name="business_volume" id="business_volume"
                            value="{{ request()->get('mode') == 'edit' ? $productVariantsRow['business_volume'] : old('business_volume') }}"
                            class="form-control" />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="status">Status *</label>
                    </div>
                    <div class="col-sm-9">
                        <select name="status" id="status" class="form-control" required>
                            <option value="active"
                                @if (request()->get('mode') == 'edit') @if ($productVariantsRow['status'] == 'active') 
                                                     {{ 'selected' }} @endif
                                @endif>Active</option>
                            <option value="inactive"
                                @if (request()->get('mode') == 'edit') @if ($productVariantsRow['status'] == 'inactive') 
                             {{ 'selected' }} @endif
                                @endif>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="variant">
                    <h5 class='bg-green p-3 text-light'>Ingredient</h5>
                    <fieldset class="scheduler-border background-light approved-section" style='max-width: 100%;'>

                        <table class="table variants" id="itmes_table">
                            <thead class='bg-info'>
                                <tr>
                                    <th class='text-light'>Item Name</th>
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
                        <a href="javascript:void(0);" onClick="add_items();" class='btn btn-primary btn-sm float-right'
                            style="float:right;">Add More</a>

                    </fieldset>
                </div>







                <div class="row mt-4 mb-4">
                    <div class="col-sm-12">
                        @if (request()->get('mode') == 'insert')
                            <button type="submit" id='btnSubmit' class="btn btn-primary btn-sm"><i
                                    class="fa fa-arrow-circle-right"></i>&nbsp;&nbsp;Add</button>
                            <button type="reset" class="btn btn-sm btn-danger mx-1"><i
                                    class="fas fa-sync-alt"></i>&nbsp;&nbsp;Reset</button>
                        @elseif(request()->get('mode') == 'edit')
                            <button type="submit" name="submit" class="btn btn-primary btn-sm"><i
                                    class="fas fa-save"></i>&nbsp;&nbsp;Update</button>
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

                if (userConfirmation) {
                    let parentDiv = $(this).parent('.image-preview');

                    let oldImgId = $(this).data('old-img-id');
                    let oldImg = $('#' + oldImgId);

                    oldImg.val('');
                    parentDiv.hide();
                }
            });

            $("#pricing_mode").on("change", handlePricingMode);
        });

        function handlePricingMode() {
            let pricing_mode = $("#pricing_mode").val();

            if (pricing_mode == "qty") {
                $(".variant").hide();
                $(".qty").show();
                $(".variant input").removeAttr("required");
                $(".qty input").attr("required", true);
            } else if (pricing_mode == "variant") {
                $(".variant").show();
                $(".qty").hide();
                $(".qty input").removeAttr("required");
                $(".variant input").attr("required", true);
                let rowCount = $('#variants_table tbody tr').length;

                if (rowCount == 0) {
                    add_variant();
                }

            } else {
                $(".variant").hide();
                $(".qty").hide();
                $(".qty input").removeAttr("required");
                $(".variant input").removeAttr("required");
            }
        }
    </script>

    <script>
        $(document).on('change', '.items_name', function() {
            let unit = $(this).find('option:selected').data('unit');
            // console.log('Selected Unit:', unit); // see if unit is found

            const unitArray = {
                kg: 'Kilogram',
                gm: 'Gram',
                liter: 'Liter',
                ml: 'Milliliter'
            };

            let unit_value = '';

            if (unit != '') {
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
