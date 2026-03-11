@extends("admin.layout.app")
@section('title')
    <title>Members</title>
@endsection
@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Members <a href="{{route("admin.members", ['view' => 'form', 'mode'=> 'insert'])}}" class="btn btn-primary btn-sm mx-3 mb-2">Add New</a></h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Members</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->


    <form name="form_actions" method="POST" action="{{ route("members.actions") }}" ENCTYPE="MULTIPART/FORM-DATA">
        @csrf
         <div class="row">
            <div class="col-sm-12 mb-0">
                <div class="form-inline">
                    <select NAME="bulk_actions" CLASS="form-control mb_inline mb-2">
                        <option VALUE="">Bulk Actions</option>
                            <option VALUE="delete">Delete</option>
                        <!--<option VALUE="active">Status to Active</option>
<option VALUE="inactive">Status to Inactive</option>-->
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm mx-4 mb-2">Apply</button>

                    {{--<input type="text" name="membership_id" class="form-control mb_inline mb-2" placeholder="Membership ID" value="" />
                    <input type="text" name="name" class="form-control mb_inline mb-2" placeholder="Name" value="" />
                    <input type="text" name="email" class="form-control mb_inline mb-2" placeholder="Email ID" value="" />
                    <input type="text" name="mobile" class="form-control mb_inline mb-2" placeholder="Mobile No." value="" />
                    <select NAME="status" CLASS="form-control mb_inline mb-2">
                        <option VALUE="" >Status</option>
                        <option VALUE="active" >Active</option>
                        <option VALUE="inactive" >Inactive</option>
                    </select> --}}
                    <p class="pt-2">From&nbsp;</p> <input type="date" name="datefrom" class="form-control mb_inline mb-2" placeholder="From" value="{{ isset($datefrom) ? $datefrom : '' }}" />
                    <p class="pt-2">To&nbsp;</p> <input type="date" name="dateto" class="form-control mb_inline mb-2" placeholder="To" value="{{ isset($dateto) ? $dateto : '' }}" />
                    <input type="submit" value="Filter" class="btn btn-primary btn-sm mb-2 mx-2" /><a href="{{route("admin.members", ['view' => 'list'])}}" class="btn btn-danger btn-sm mb-2">Clear</a> 
                    <input type="submit" name="excel" value="&#xf1c3 Excel" style='font-family: "Font Awesome 5 Free";' class="btn btn-success btn-sm mb-2 mx-2" />

                    
                     {{-- <input type="submit" name="excel_balance" value="&#xf1c3 Download Balance Report" style='font-family: "Font Awesome 5 Free";min-width: 200px;' class="btn btn-success mb_inline btn-sm btn_submit ml-sm-2 ml-md-0 mb-2 mr-1 " />  --}}
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
                                        <th class="wd-15p border-bottom-0">Name</th>
                                        <th class="wd-15p border-bottom-0">Membership ID</th>
                                        <th class="wd-15p border-bottom-0">Sponsor ID</th>
                                        {{-- <th class="wd-15p border-bottom-0">Password</th> --}}
                                        <th class="wd-15p border-bottom-0">Genealogy</th>
                                        {{--<th class="wd-15p border-bottom-0">Downline Members</th> --}}
                                        <th class="wd-15p border-bottom-0">Email</th>
                                        <th class="wd-15p border-bottom-0">Mobile No.</th>
                                        <!-- <th>Members</th> -->
                                        <!-- <th>Sale</th> -->
                                        <!--<th>E-Wallet</th>-->
                                        <th class="wd-15p border-bottom-0">Status</th>
                                        <th class="wd-15p border-bottom-0">Date</th>
                                        <th class="wd-15p border-bottom-0" style="max-width: 50px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @if(count($registerRows) >= 1)
                                    @foreach($registerRows as $registerRow)
                                        <tr>
                                            <td><input type="checkbox" name="del_items[]" value="{{ $registerRow['id'] }}" /></td>
                                            <td>{{ $registerRow['name']}}</td>
                                            <td>{{ $registerRow['membership_id'] }}</td>
                                            <td>{{ $registerRow['sponsor_id'] }}</td>
                                            {{-- <td>{{ ($registerRow['password_text']) }}</td> --}}
                                            <td><a target="_blank" href="{{ route('members.genealogy', ['regid' => $registerRow['id']]) }}">Genealogy</a></td>
                                            {{-- <td><a href='downline_member_view.php?mid={{ $registerRow['membership_id'] }}'>Downline Members</a></td> --}}
                                            <td>{{ $registerRow['email'] }}</td>
                                            <td>{{ $registerRow['mobile'] }}</td>
                                            <td><span class="badge rounded-pill bg-{{ $registerRow['status'] == 'active' ? 'success' : 'danger' }} badge-sm me-1 mb-1 mt-1">{{ ucfirst($registerRow['status']) }}</span></td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($registerRow['created_at'])->format('d M, Y') }} 
                                                <br class="mb-hidden" />
                                                ({{ \Carbon\Carbon::parse($registerRow['created_at'])->diffForHumans() }})
                                            </td>
                                            <td>
                                                <div class="g-2">
                                                  
                                                        <a class="btn text-primary btn-sm" href="{{route("admin.members", ['view' => 'form', 'mode'=> 'edit', 'regid'=> $registerRow['id']])}}" data-bs-toggle="tooltip" data-bs-original-title="Edit"><span class="fe fe-edit fs-14"></span></a>
                                                        {{-- |
                                                        <form action="{{ route('members.delete') }}" name="single-delete" method="POST" style="display:inline;" onsubmit="event.stopPropagation();">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $registerRow['id'] }}">
                                                            <button type="button" onclick=" if(del()) { this.form.submit(); }" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete" ><span class="fe fe-trash-2 fs-14"></span></button>
                                                        </form> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                @else 
                                    <tr class="text-center">
                                        <td class="text-center" colspan="8">No Record is Available!</td>
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
