<?php

namespace App\DTO;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class CategoryDTO
{

    public ?int $categoryid;
    public ?String $title;
    public ?int $kitchen_id;
    public ?string $imgName;
    public ?String $remarks;
    public ?String $status;
   

    public function __construct(Request $request){

        try {
            
            $this->categoryid = $request->categoryid;
            $this->title = $request->title;
            $this->kitchen_id = $request->kitchen_id;
            $this->imgName = '';
            $this->remarks = $request->remarks;
            $this->status = $request->status;

        } catch (Exception $e) {

            throw new Exception("Error processing request: " . $e->getMessage());
        
        }catch (Throwable $t) { // Catch any other types of errors
        
            throw new Exception("Unexpected error: " . $t->getMessage());
        
        }

    }

}