<?php

namespace App\DTO;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class PerformanceBonusDTO
{

    public ?int $pid;
    public ?String $title;
    public ?float $bv_range_start;
    public ?float $bv_range_end;
    public ?float $incentive;
    public ?float $monthly_self_bv;
    public ?String $remarks;
    public ?String $status;
   

    public function __construct(Request $request){

        try {
            
            $this->pid = $request->pid;
            $this->title = $request->title;
            $this->bv_range_start = $request->bv_range_start;
            $this->bv_range_end = $request->bv_range_end;
            $this->incentive = $request->incentive;
            $this->monthly_self_bv = $request->monthly_self_bv;
            $this->remarks = $request->remarks;
            $this->status = $request->status;

        } catch (Exception $e) {

            throw new Exception("Error processing request: " . $e->getMessage());
        
        }catch (Throwable $t) { // Catch any other types of errors
        
            throw new Exception("Unexpected error: " . $t->getMessage());
        
        }

    }

}