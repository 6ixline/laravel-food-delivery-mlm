@extends("admin.layout.app")
@section('title')
    <title>Members</title>
@endsection
@section('content')
<!-- CONTAINER -->
<div class="main-container container-fluid">
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Team Structure - (<?= $registerRow['membership_id'] . " " . $registerRow['first_name']  . " " . $registerRow['last_name']; ?>)</h1>
    </div>

    <div class="form-rows-custom mt-3">
        <div class="row mb-3">
            <div class="col-12">
                <p>Note: Click on the member's box to view it's list</p>
                <div class="body genealogy-body genealogy-scroll">
                    <div class="genealogy-tree">
                        @php
                        $slr = 0;
                        function getAllDownlines($parent)

                        {
                            global $slr;
                                $treeResult = DB::table('sk_registrations')
                                    ->select('membership_id', 'name','imgName', 'username', 'status')
                                    ->where('sponsor_id', $parent)
                                    ->orderBy('id', 'asc')
                                    ->get()
                                    ->toArray();
                                if (count($treeResult) >= 1){
                                    if ($slr == 0) {
                                    $slr = 1;
                                    echo "<ul class='active'>";
                                } else {
                                    echo "<ul>";
                                    }
                                    foreach ($treeResult as $treeRow) {
                                        
                                        $membership_id = $treeRow->membership_id;
                                        
                                        $box_color = "box_token";
                                        $booking_status = "Available";
                                        
                                    echo "<li>";
                                    echo "<a href='javascript:void(0);'>";
                                    echo "<div class='member-view-box  ' style='background-color: #afdeff;'>";
                                    echo "<div class='member-image'>";
                                    if ($treeRow->imgName != "") {
                                        $image = asset('uploads/' . $treeRow->imgName);
                                        echo "<img src='{$image}' class='img-responsive' />";
                                    } else {
                                        $image = asset('assets/images/user-icon.png');
                                        echo "<img src='{$image}' class='img-responsive' />";
                                    }
                                    echo "<div class='member-details'>";
                                        $membership_id = ($treeRow->membership_id);
                                        $username = ($treeRow->first_name);
                                        echo "<p class='text-dark'><b>{$username}</b></p>";
                                        echo "<p class='text-dark'><b>{$membership_id}</b></p>";
                                        if ($treeRow->status == "inactive") {
                                        echo "<p class='pending text-danger'>Inactive</p>";
                                    }
                                    echo "</div>
                                        </div>
                                    </div>
                                    </a>";
                                    $slr++;
                                    getAllDownlines($treeRow->membership_id);
                                    echo "</li>";
                                }
                                echo "</ul>";
                            }
                        }
                        @endphp
                        <ul>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="member-view-box" style="background-color: #afdeff;">
                                        <div class="member-image">
                                            @if ($registerRow['imgName'] != "")
                                                <img src="{{ asset('uploads/' . $registerRow['imgName']) }}" class="img-responsive" />
                                            @else
                                                <img src="{{asset('assets/images/user-icon.png')}}" class="img-responsive" />
                                            @endif
                                            <div class="member-details">
                                                <p class="text-dark"><b>{{($registerRow['name']) }}</b></p>
                                                <p class="text-dark"><b>{{($registerRow['membership_id']) }}</b></p>
                                                @if ($registerRow['status'] == "inactive") 
                                                    <p class='pending text-danger'>Inactive</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                @php getAllDownlines($registerRow['membership_id']) @endphp
                            </li>
                        </ul>


                    </div>

                </div>



            </div>

        </div>

    </div>

</div>
<!-- CONTAINER END -->
@endsection
