<?php

namespace App\Http\Controllers\Product;

use App\Models\Unit;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        // $products = Product::with('category:id,name','images:product_id,name')->orderBy('id', 'desc')->get();
        $products = Product::with('category:id,name','images:product_id,name')->orderBy('id', 'desc')->paginate(5);
        // dd($products); 

        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        $categories = Category::all();
        $units      = Unit::all();
        return view('product.create', compact('categories', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $productsInfo = json_decode($request->productsData);
        $product              = new Product();
        $product->title       = $productsInfo->title;
        $product->description = $productsInfo->description;
        $product->price       = $productsInfo->price;
        $product->old_price   = $productsInfo->old_price;
        $product->category_id = $productsInfo->category_id;
        $product->unit        = $productsInfo->unit;
        $product->created_by        = Auth::user()->id;
        $product->save();

         if ($request->hasFile('images')) {
            foreach($request->file('images') as $image){
                $filename    = Storage::put('upload/product/', $image);
                $product->images()->create([
                    'name' => $filename
                ]);
            }
        }

        return 'ok';

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $productEdit = Product::find($id);
        $categories = Category::all();
        $units      = Unit::all();
        return view('product.edit', compact('categories','units','productEdit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product) {
        $productsInfo = json_decode($request->productUpdateInfo);
        $product->title       = $productsInfo->title;
        $product->description = $productsInfo->description;
        $product->price       = $productsInfo->price;
        $product->old_price   = $productsInfo->old_price;
        $product->category_id = $productsInfo->category_id;
        $product->unit        = $productsInfo->unit;
        $product->created_by        = Auth::user()->id;
        $product->save();

         if ($request->hasFile('images')) {
            $product->images()->delete();
            foreach($request->file('images') as $image){
                $filename    = Storage::put('upload/product/', $image);
                $product->images()->create([
                    'name' => $filename
                ]);
            }
        }

        return 'ok';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product) {
        $product->delete();
        return 'deleted';
    }
}