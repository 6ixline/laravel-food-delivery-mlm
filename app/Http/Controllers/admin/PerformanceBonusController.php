<?php

namespace App\Http\Controllers\admin;

use App\DTO\PerformanceBonusDTO;
use App\Http\Controllers\Controller;
use App\Models\PerformanceBonus;
use App\Services\PerformanceBonusService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Throwable;

class PerformanceBonusController extends Controller
{

    private PerformanceBonusService $performanceBonusService;

    public function __construct(PerformanceBonusService $performanceBonusService)
    {
        $this->performanceBonusService = $performanceBonusService;
    }
    //

    public function store(Request $request)
    {
        // Validate the incoming request data
        try{
            $this->validatePerforamnceBonusRequest($request);
        }catch(Exception $e){
            return redirect()->route("admin.performanceBonus", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $e->getMessage()])->withInput();
        }
        
        try {
            // Attempt to create a new Performance Bonus
            $requestDTO = new PerformanceBonusDTO($request);
            $this->performanceBonusService->createPerformanceBonus($request, $requestDTO);

        } catch (QueryException $e) {
            $message = "";
            if ($e->errorInfo[0] === '23000') { // General SQLSTATE code for integrity constraint violation
                if (strpos($e->getMessage(), '1062') !== false) { // MySQL unique constraint violation
                    $message = 'Duplicate entry.';
                }
                if (strpos($e->getMessage(), '1452') !== false) { // MySQL foreign key constraint violation
                    $message = 'Foreign key constraint fails.';
                }
            }
            if($e->errorInfo[0] === '01000'){
                $message = 'Please give a valid status value';
            }
            return redirect()->route("admin.performanceBonus", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $message])->withInput();
        } catch (Exception $e) {
            // Check for specific SQLSTATE error codes
            return redirect()->route("admin.performanceBonus", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()->route("admin.performanceBonus", ['view' => 'list'])->with('success', 'Performance Bonus Added successfully!');
    }

    public function updatePerformanceBonus(Request $request){
        // Validate the incoming request data
        try {
            $this->validatePerforamnceBonusRequest($request);
        } catch (Exception $e) {
            return redirect()->route("admin.performanceBonus", ['view' => 'form', 'mode' => $request->mode])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        try {

            // Create DTO and update Performace Bonus
            $requestDTO = new PerformanceBonusDTO($request);
            $this->performanceBonusService->updatePerformanceBonus($request, $requestDTO);

        } catch (QueryException $e) {
            $message = "Error! While Updating the . Please Try again.";
            if ($e->errorInfo[0] === '23000') {
                if (strpos($e->getMessage(), '1062') !== false) {
                    $message = 'Duplicate entry.';
                }
                if (strpos($e->getMessage(), '1452') !== false) {
                    $message = 'Foreign key constraint fails.';
                }
            }
            return redirect()->route("admin.performanceBonus", ['view' => 'form', 'mode' => $request->mode])
                ->withErrors(['error' => $message])
                ->withInput();
        } catch (Exception $e) {
            return redirect()->route("admin.performanceBonus", ['view' => 'form', 'mode' => $request->mode])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        return redirect()->route("admin.performanceBonus", ['view' => 'list'])
            ->with('success', 'Performace Bonus updated successfully!');
    }


    public function performanceBonusActions(Request $request){
        if($request->bulk_actions == "delete"){
            try{
                $this->performanceBonusService->bulkDeletePerformanceBonusByIds($request->input('del_items'));
                return redirect()->route("admin.performanceBonus", ['view' => 'list'])
                ->with('success', 'Selected Performace Bonus deleted successfully!');
            } catch (Throwable $e) {
                return redirect()->route("admin.performanceBonus", ['view' => 'list'])
                ->with(['error' => 'An error occurred: ' . $e->getMessage()]);
            }
        
        }else{
            $query = PerformanceBonus::query();

            if ($request->filled('datefrom')) {
                $query->whereDate('created_at', '>=', $request->datefrom);
            }

            if ($request->filled('dateto')) {
                $query->whereDate('created_at', '<=', $request->dateto);
            }

            $performanceBonusRows = $query->orderBy('id', 'desc')->get();

            return view("admin.performanceBonus.performance-bonus-list", ['performanceBonusRows' => $performanceBonusRows, "datefrom"=> $request->datefrom, "dateto"=> $request->dateto]);
        }

    }


    public function validatePerforamnceBonusRequest($request){
        return  $request->validate([
            'title' => 'required|string|max:255',
            'bv_range_start' => 'required|numeric',
            'bv_range_end' => 'required|numeric',
            'incentive' => 'required|numeric',
            'monthly_self_bv' => 'required|numeric',
        ]);
    }
}
