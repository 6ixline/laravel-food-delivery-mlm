<?php

namespace App\DTO;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class IngredientDTO
{

    public ?int $id;
    public ?String $title;
    public ?String $unit;
    public ?String $status;
   

    public function __construct(Request $request){

        try {
            
            $this->id = $request->id;
            $this->title = $request->title;
            $this->unit = $request->unit;
            $this->status = $request->status;

        } catch (Exception $e) {

            throw new Exception("Error processing request: " . $e->getMessage());
        
        }catch (Throwable $t) { // Catch any other types of errors
        
            throw new Exception("Unexpected error: " . $t->getMessage());
        
        }

    }

}