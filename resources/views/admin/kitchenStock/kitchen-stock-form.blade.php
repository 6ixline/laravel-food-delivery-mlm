@extends('admin.layout.app')
@section('title')
    <title>{{ request()->get('mode') == 'insert' ? 'Add New' : 'Update' }} Kitchen Manager</title>
@endsection
@section('content')
    <!-- CONTAINER -->
    @php
        error_reporting(0);
    @endphp

    <div class="main-container container">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">{{ request()->get('mode') == 'insert' ? 'Add New' : 'Update' }} Kitchen Stock</h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ request()->get('mode') == 'insert' ? 'Add New' : 'Update' }} Kitchen Stock</li>
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
            action="{{ request()->get('mode') == 'insert' ? route('kitchenStock.store') : route('kitchenStock.update') }}"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="mode" value="{{ request()->get('mode') }}" />
            <input type="hidden" name="id" id="id"
                value="{{ request()->get('mode') == 'edit' ? $KitchenStockRow['id'] : '' }}" />
            <input type="hidden" name="kitchen_id" id="kitchen_id" value="{{ request()->get('kitchen_id') }}" />

            <div class="form-rows-custom mt-3">

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="ingredients_id">Item Name *</label>
                    </div>
                    <div class="col-sm-9">

                        <select name="ingredients_id" id="ingredients_id" class="form-control" required>
                            <option value="">--select itmes name -- </option>
                            @foreach ($IngredientRows as $ingredientRow)
                                <option value="{{ $ingredientRow['id'] }}"
                                    @if (request()->get('mode') == 'edit') @if ($ingredientRow['id'] == $KitchenStockRow['ingredients_id']) 
                                                     {{ 'selected' }} @endif
                                    @endif data-unit="{{ $ingredientRow['unit'] }}">
                                    {{ ucwords($ingredientRow['title']) }}</option>
                            @endforeach


                        </select>


                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="qty">Quantity *</label>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" onkeypress="return isNumber(event)" required name="qty" id="qty"
                            class="form-control"
                            value="{{ request()->get('mode') == 'edit' ? $KitchenStockRow['qty'] : old('qty') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="unit">Unit</label>
                    </div>
                    <div class="col-sm-9">


                        
                        @php
                        
                           $unitArray = [
                                'kg' => 'Kilogram',
                                'gm' => 'Gram',
                                'liter' => 'Liter',
                                'ml' => 'Milliliter',
                            ];
                        @endphp

                        <input type="text" id="unit" readonly class="form-control"
                            value="@if (request()->get('mode') == 'edit') {{ $unitArray[$KitchenStockRow['ingredient']['unit']] }} @endif" />


                    </div>
                </div>







                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="status">Status *</label>
                    </div>
                    <div class="col-sm-9">
                        <select name="status" id="status" class="form-control" required>
                            <option value="active"
                                @if (request()->get('mode') == 'edit') @if ($KitchenStockRow['status'] == 'active') 
                                                     {{ 'selected' }} @endif
                                @endif>Active</option>
                            <option value="inactive"
                                @if (request()->get('mode') == 'edit') @if ($KitchenStockRow['status'] == 'inactive') 
                             {{ 'selected' }} @endif
                                @endif>Inactive</option>
                        </select>
                    </div>
                </div>

                @if (request()->get('mode') == 'edit')
                    @if ($KitchenStockRow['userid'] != '' and $KitchenStockRow['userid'] != '0')
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label>Author</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="text"><a href="#">{{ $userRow['display_name'] }}</a></p>
                            </div>
                        </div>
                    @endif

                    @if ($KitchenStockRow['userid_updt'] != '' and $KitchenStockRow['userid_updt'] != '0')
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label>Author (Modified By)</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="text"><a href="#">{{ $userupdtRow['display_name'] }}</a></p>
                            </div>
                        </div>
                    @endif

                    {{-- <div class="row mb-3">
                    <div class="col-sm-3">
                        <label>User's IP Address</label>
                    </div>
                    <div class="col-sm-9">
                        <p class="text">{{ ($KitchenStockRow['user_ip']) }}</p>
                        <input type="hidden" name="user_ip" value="{{ (request()->get('mode') == 'edit') ? ($KitchenStockRow['user_ip']) : "" }}" />
                    </div>
                </div> --}}

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label>Modification Date & Time</label>
                        </div>
                        <div class="col-sm-9">
                            @if ($KitchenStockRow['updated_at'] != '')
                                <p class="text">
                                    {{ \Carbon\Carbon::parse($KitchenStockRow['updated_at'])->format('F d,Y \a\t H:i A') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label>Creation Date & Time</label>
                        </div>
                        <div class="col-sm-9">
                            @if ($KitchenStockRow['created_at'] != '')
                                <p class="text">
                                    {{ \Carbon\Carbon::parse($KitchenStockRow['created_at'])->format('F d,Y \a\t H:i A') }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endif

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
                            {{-- <a href="register_actions.php?q=del&pid={{ $KitchenStockRow['pid'] }}" class="btn btn-sm btn-danger mx-1" onclick="return del();"><i class="fas fa-trash"></i>&nbsp;&nbsp;Delete</a> --}}
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

   <script>
        document.getElementById('ingredients_id').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const unit = selectedOption.getAttribute('data-unit');

             
            const unitArray = {
                kg: 'Kilogram',
                gm: 'Gram',
                liter: 'Liter',
                ml: 'Milliliter'
            };

            console.log(unit);

            if( unit != null){
                document.getElementById('unit').value=unitArray[unit];
            }else{
                document.getElementById('unit').value='';
            }
             
           
        });
    </script>

    <!--app-content close-->
@endsection


