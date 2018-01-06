<?php

namespace App\Http\Controllers\Frontend;

use App\Entities\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Exception;

class CategoryController extends Controller
{
    /**
     * Display all category.
     */
    public function all(Request $request){
        try{
            $limit = $request->get('limit')?$request->get('limit'):25;
            $categories = Category::paginate($limit);
            return response()->json($categories);
        }catch (Exception $e){

        }
    }

}
