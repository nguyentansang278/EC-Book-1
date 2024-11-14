<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeaturedItems;
use App\Models\Author;
use App\Models\Book;

class FeaturedItemsController extends Controller
{
    public function index(){
        $featuredItems = FeaturedItems::with(['author', 'book'])->get();
        return view('admin.featured_items.index', compact('featuredItems'));
    }

    public function create(){
        $authors = Author::all();
        $books = Book::all();
        return view('admin.featured_items.create', compact(['authors', 'books']));
    }

    public function store(Request $request){
        $inputs = $request->all();
        $featuredItem = FeaturedItems::create($inputs);
        return redirect(route('admin.featured_items.index'))->with('success', 'Created');
    }

    public function edit(){

    }
    public function update(){

    }
    public function destroy($id){
        $feturedItem = FeaturedItems::find($id);
        $feturedItem->delete();
        return redirect(route('admin.featured_items.index'))->with('success', 'Deleted');

    }
}
