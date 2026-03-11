<?php

namespace App\Http\Controllers\customer;

use App\DTO\BaseResponseDTO;
use App\Http\Controllers\Controller;
use App\Services\CustomerDashboardService;
use Illuminate\Http\Request;
use Throwable;

class DashboardController extends Controller
{
    //
    private CustomerDashboardService $customerDashboardService;

    public function __construct(CustomerDashboardService $customerDashboardService)
    {
        $this->customerDashboardService = $customerDashboardService;        
    }

    public function HomeData(Request $request){
        try{
            $validated = $request->validate([
                "pincode" => "String|required"
            ]);
            $dashboardStats = $this->customerDashboardService->getDashBoardStats($validated['pincode']);
            $response = new BaseResponseDTO("success", "Dashbaord Stats Fetch Successfully!", $dashboardStats);
            return response()->json($response, 200);
        }catch(Throwable $th){
            $response = new BaseResponseDTO("error", $th->getMessage());
            return response()->json($response, 400);
        }
    }

    
}
