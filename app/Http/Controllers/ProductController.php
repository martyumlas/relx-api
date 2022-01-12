<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductCollection;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $products = Product::when($search, function ($query) use ($search) {
            $query->where('name', 'like', $search .'%');
        })->latest()->paginate(5);
        
        return new ProductCollection( $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->safe()->except('image');
        $img = $request->file('image');        
        if($img) {

            
            $path = $img->storeAs('products', $request->file('image')->hashName(), 'public');
            $data['image'] = $path;

            $thumb = Image::make($img)->resize(100, 100);
            
            if(!Storage::exists('public/thumbnail')) {
                Storage::makeDirectory('public/thumbnail');
            } 

            $thumb->save(storage_path('app/public/thumbnail/').$img->hashName());
            $data['thumbnail'] = 'thumbnail/'.$img->hashName();

 
    
            
        }

        $product = Product::create($data);

        return response()->json(['product' => $product, 'message' => 'Product Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json(['product' => $product]);
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->safe()->except('image');

        if($request->file('image')) {
            Storage::delete($product->image);
            $path = $request->file('image')->storeAs('products', $request->file('image')->hashName(), 'public');

            $data['image'] = $path;
        }

        $product->update($data);

        return response()->json(['product' => $product, 'message' => 'Product Created']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product->image) {
             Storage::disk('public')->delete($product->image_url);
        }
        if($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail_url);
        }

         $product->delete();
        return response()->json(['message' => 'Product Deleted']);
    }
}
