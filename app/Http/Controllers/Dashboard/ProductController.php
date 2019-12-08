<?php

namespace App\Http\Controllers\Dashboard;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories=Category::all();
        $products=Product::when($request->search,function($q) use($request){
            return $q->whereTranslationLike('name','%'. $request->search .'%');
        })->when($request->category_id,function($q) use($request){
            return $q->where('category_id',$request->category_id);

        })->latest()->paginate(3);
        return view('dashboard.products.index',compact('categories','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories=Category::all();
        return view('dashboard.products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=[
            'category_id'=>'required'
        ];
        foreach (config('translatable.locales') as $locale){
            $rules +=[$locale. '.name'=>'required|unique:product_translations,name'];
            $rules +=[$locale. '.description'=>'required'];
        }
    
        $rules+=[
            'purchase_price'=>'required',
            'sale_price'=>'required',
            'stock'=>'required'

        ];
       $request->validate($rules);
       $request_data=$request->all();

       if($request->image){
           Image::make($request->image)->resize(300, null, function ($constraint) {
               $constraint->aspectRatio();
           })->save(public_path('uploads/products_images/'. $request->image->hashName()));
           $request_data['image']=$request->image->hashName();

       }
//dd($request_data);
       Product::create($request_data);
       session()->flash('success',__('site.added_succefully'));
       return redirect()->route('dashboard.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories=Category::all();
        return view('dashboard.products.edit',compact('categories','product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules=[
            'category_id'=>'required'
        ];
        foreach (config('translatable.locales') as $locale){
            $rules +=[$locale. '.name'=>['required',Rule::unique('product_translations','name')->ignore($product->id,'product_id')]];
            $rules +=[$locale. '.description'=>'required'];
        }
    
        $rules+=[
            'purchase_price'=>'required',
            'sale_price'=>'required',
            'stock'=>'required'

        ];
       $request->validate($rules);
       $request_data=$request->all();

       if($request->image){
           if($product->image !='default.jpg'){
            Storage::disk('public_uploads')->delete('/products_images/' .$product->image);
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_images/'. $request->image->hashName()));
        }
            $request_data['image']=$request->image->hashName(); 
          
       }
//dd($request_data);
        $product->update($request_data);
       session()->flash('success',__('site.updated_succefully'));
       return redirect()->route('dashboard.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product->image !='default.jpg'){
            Storage::disk('public_uploads')->delete('/products_images/' .$product->image);
        }
        $product->delete();
        session()->flash('success',__('site.deleted_succefully'));
        return redirect()->route('dashboard.products.index');
    }
}
