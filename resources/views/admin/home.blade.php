@extends("admin.layout.app")
@section('title')
    <title>Home</title>
@endsection
@section('content')
<div class="main-container container-fluid">

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Dashboard - {{ucfirst(Auth::guard("admin")->user()->name)}}</h1>

    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW-1 -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="row">

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <div class="card bg-info img-card box-info-shadow" style="min-height: 110px;">
                        <a class="my-auto" href="{{route("admin.members", ['view' => 'list'])}}" data-bs-toggle="tooltip" data-bs-original-title="View All">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="text-white">
                                        <h3 class="mb-0 number-font mb-3">{{ $totalMembers }}</h3>
                                        <p class="text-white mb-0">Total Members! </p>
                                    </div>
                                    <div class="ms-auto"> <i class="fas fa-user  text-white fs-50 me-2 mt-2"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <div class="card bg-primary img-card box-primary-shadow" style="min-height: 110px;">
                        <a class="my-auto" href="{{route("admin.kitchen", ['view' => 'list'])}}" data-bs-toggle="tooltip" data-bs-original-title="View All">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="text-white">
                                        <h3 class="mb-0 number-font mb-3">{{ $totalKitchen }}</h3>
                                        <p class="text-white mb-0">Total Kitchen! </p>
                                    </div>
                                    <div class="ms-auto"> <i class="fas fa-utensils text-white fs-50 me-2 mt-2"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <div class="card bg-warning img-card box-warning-shadow" style="min-height: 110px;">
                        <a class="my-auto" href="{{route("admin.kitchenManager", ['view' => 'list'])}}" data-bs-toggle="tooltip" data-bs-original-title="View All">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="text-white">
                                        <h3 class="mb-0 number-font mb-3">{{ $totalKitchenManager }}</h3>
                                        <p class="text-white mb-0">Total Kitchen Manager!</p>
                                    </div>
                                    <div class="ms-auto"> <i class="fas fa-user-tie text-white fs-50 me-2 mt-2"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <div class="card bg-success img-card box-success-shadow" style="min-height: 110px;">
                        <a class="my-auto" href="{{route("admin.pincodeMaster", ['view' => 'list'])}}" data-bs-toggle="tooltip" data-bs-original-title="View All">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="text-white">
                                        <h3 class="mb-0 number-font mb-3">{{ $totalPincode }}</h3>
                                        <p class="text-white mb-0">Total Pincode! </p>
                                    </div>
                                    <div class="ms-auto"> <i class="fas fa-map-marker-alt text-white fs-50 me-2 mt-2"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                
                {{-- <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                    <div class="card overflow-hidden">
                        <div class="card bg-info img-card box-info-shadow">
                            <div class="d-flex">
                                <div class="mt-2">
                                    <h6 class="">Total Registrations</h6>
                                    <h2 class="mb-0 number-font">{{ $totalMembers }}</h2>
                                </div>
                                <div class="ms-auto">
                                    <div class="chart-wrapper mt-1">
                                    <i class="fe fe-users fa-5x"></i>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div> --}}
            
            </div>
        </div>
    </div>
    <!-- ROW-1 END -->
</div>
@endsection
