@extends("admin.layout.app")
@section('title')
    <title>Category ({{$kitchen->name}})</title>
@endsection
@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">

    <!-- PAGE-HEADER -->
    <a href="{{route("admin.kitchen", ['view' => 'list'])}}" class='btn btn-dark btn-sm mt-3'>Go Back</a>
    <div class="page-header mt-2">
        <h1 class="page-title">Category ({{$kitchen->name}}) <a href="{{route("admin.category", ['view' => 'form', 'mode'=> 'insert', 'kitchen_id'=> $kitchen->id])}}" class="btn btn-primary btn-sm mx-3 mb-2">Add New</a></h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Category</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->


    <form name="form_actions" method="POST" action="{{ route("category.actions") }}" ENCTYPE="MULTIPART/FORM-DATA">
        @csrf
         <div class="row">
            <div class="col-sm-12 mb-0">
                <div class="form-inline">
                    <input type="hidden" name="kitchen_id" value="{{ $kitchen->id }}">
                    <select NAME="bulk_actions" CLASS="form-control mb_inline mb-2">
                        <option VALUE="">Bulk Actions</option>
                            <option VALUE="delete">Delete</option>
                        <!--<option VALUE="active">Status to Active</option>
                            <option VALUE="inactive">Status to Inactive</option>-->
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm mx-4 mb-2">Apply</button>

                   
                    <p class="pt-2">From&nbsp;</p> <input type="date" name="datefrom" class="form-control mb_inline mb-2" placeholder="From" value="{{ isset($datefrom) ? $datefrom : '' }}" />
                    <p class="pt-2">To&nbsp;</p> <input type="date" name="dateto" class="form-control mb_inline mb-2" placeholder="To" value="{{ isset($dateto) ? $dateto : '' }}" />
                    <input type="submit" value="Filter" class="btn btn-primary btn-sm mb-2 mx-2" /><a href="{{route("admin.category", ['view' => 'list', 'kitchen_id'=> $kitchen->id])}}" class="btn btn-danger btn-sm mb-2">Clear</a> 
                </div>
            </div>
        </div>


        <!-- Row -->
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap border-bottom" id="responsive-datatable">
                                <thead>
                                    <tr>
                                        <th class="wd-15p border-bottom-0" style="max-width: 30px;"><input type="checkbox" name="select_all" onClick="selectall(this);" /></th>
                                        <th class="wd-15p border-bottom-0">Title</th>
                                        <th class="wd-15p border-bottom-0">Status</th>
                                        <th class="wd-15p border-bottom-0">Date</th>
                                        <th class="wd-15p border-bottom-0" style="max-width: 50px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @if(count($categoryRows) >= 1)
                                    @foreach($categoryRows as $categoryRow)
                                        <tr>
                                            <td><input type="checkbox" name="del_items[]" value="{{ $categoryRow['id'] }}" /></td>
                                            <td>{{ $categoryRow['title'] }}</td>
                                            <td><span class="badge text-light rounded-pill bg-{{ $categoryRow['status'] == 'active' ? 'success' : 'danger' }} badge-sm me-1 mb-1 mt-1">{{ ucfirst($categoryRow['status']) }}</span></td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($categoryRow['created_at'])->format('d M, Y') }} 
                                                <br class="mb-hidden" />
                                                ({{ \Carbon\Carbon::parse($categoryRow['created_at'])->diffForHumans() }})
                                            </td>
                                            <td>
                                                <div class="g-2">
                                                  
                                                        <a class="btn text-primary btn-sm" href="{{route("admin.category", ['view' => 'form', 'mode'=> 'edit', 'categoryid'=> $categoryRow['id'], 'kitchen_id'=> $kitchen->id])}}" data-bs-toggle="tooltip" data-bs-original-title="Edit"><span class="fe fe-edit fs-14"></span></a>
                                                        {{-- |
                                                        <form action="{{ route('pincodeMaster.delete') }}" name="single-delete" method="POST" style="display:inline;" onsubmit="event.stopPropagation();">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $categoryRow['id'] }}">
                                                            <button type="button" onclick=" if(del()) { this.form.submit(); }" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete" ><span class="fe fe-trash-2 fs-14"></span></button>
                                                        </form> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                @else 
                                    <tr class="text-center">
                                        <td class="text-center" colspan="9">No Record is Available!</td>
                                    </tr>
                                @endif
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </form>

    
</div>
<!--app-content close-->
@endsection
