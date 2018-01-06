<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Book;
use App\Entities\Category;
class BookController extends Controller
{
    public function getAllBook(Request $request){
        try{
            
            $books = Book::with('giver')->paginate($request->get('limit',25));
            return response()->json($books);
        }catch(Exception $e){
            
        }
    }

    public function getBookByCategory(Request $request,$id){
        $category = Category::find($id);
        $books = $category->books()->paginate($request->get('limit',25));
        return response()->json($books);
    }

    
}
