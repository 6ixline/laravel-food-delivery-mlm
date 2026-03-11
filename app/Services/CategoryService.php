<?php

namespace App\Services;

use App\DTO\CategoryDTO;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;


class CategoryService{
    public function createCategory(Request $request, CategoryDTO $requestDTO){
        
        try {
            if ($request->hasFile('imgName')) {
                $file = $request->file('imgName');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                $requestDTO->imgName = $filename;
            }

            $category = Category::create([
                'title' => $requestDTO->title,
                'kitchen_id' => $requestDTO->kitchen_id,
                'imgName' => $requestDTO->imgName,
                'remarks' => $requestDTO->remarks,
                'status'=> $requestDTO->status ? $requestDTO->status : "active"
            ]);

            return $category;

        } catch (Exception $e) {
            throw $e;
        }

    }

    public function updateCategory(Request $request, CategoryDTO $requestDTO){
        try {
            if ($request->hasFile('imgName')) {
                $file = $request->file('imgName');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                $requestDTO->imgName = $filename;
            }else{
                $requestDTO->imgName = $request->old_imgName;
            }

            $category = Category::where('id', $requestDTO->categoryid)->firstOrFail();
            $updateData = [
                'title' => $requestDTO->title,
                'kitchen_id' => $requestDTO->kitchen_id,
                'imgName' => $requestDTO->imgName,
                'remarks' => $requestDTO->remarks,
                'status' => $requestDTO->status ?? $category->status
            ];

            $category->update($updateData);

            return $category->fresh();
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function bulkDeleteCategoryByIds($categoryIds = [])
    {
        try {
            if (is_array($categoryIds) && count($categoryIds) > 0) {
                Category::whereIn('id', $categoryIds)->delete();
            } else {
                throw new Exception('No Record selected for deletion.');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteCategory($id){
        try {
            $category = Category::find($id);
            if (!$category) {
                throw new Exception('Record not found.');
            }
            $category->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}