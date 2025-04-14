<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product:: orderby('created_at','desc')->get();
        return view('products.index',['products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'sku'=>'required|unique:products,sku', //check the unique value in products table sku column
            'price'=>'required|numeric',
            'status'=>'required',
            'image'=>'image|mimes:jpg,png,jpeg|max:2048',

        ]);

        if($validator->fails()){
            return redirect(route('products.create'))->withErrors($validator)->withInput();
        }

        $product= new Product();// made a object od product class model
        $product->name=$request->name;
        $product->sku=$request->sku;
        $product->price=$request->price;
        $product->status=$request->status;
        $product->save(); 

        if ($request->hasFile('image')){
            $image=$request->image;
            $imageName= time().'.'.$image->getClientOriginalExtension();//getting timestamp+jpg or png
            $image->move(public_path('uploads/products'),$imageName);//taking the path and the file name 
            $product->image= $imageName;
            $product->save(); 
        }


        return redirect(route('products.index'))->with('success','Product created successfully'); //send success message 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product=Product::findorFail($id); 
        return view('products.edit',['product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        
            $product=Product::findorFail($id);//it will first find and get the info
            $oldImage = $product->image;//stored the image name in variable 

            $validator=Validator::make($request->all(),[
                'name'=>'required',
                'sku'=>'required|unique:products,sku,'.$id, //except the own id it will check the other id's
                'price'=>'required|numeric',
                'status'=>'required',
                'image'=>'image|mimes:jpg,png,jpeg|max:2048',
    
            ]);
    
            if($validator->fails()){
                return redirect(route('products.edit', $product->id))->withErrors($validator)->withInput();
            }
    
    
            $product->name=$request->name;
            $product->sku=$request->sku;
            $product->price=$request->price;
            $product->status=$request->status;
            $product->save(); //get updated
    



            if($request->hasFile('image')){
                //Delete old image 
                    if($oldImage != null && File::exists(public_path('uploads/products/'.$oldImage))){
                        File::delete(public_path('uploads/products/'. $oldImage));  
        
                    }
                //then save the image
                $image=$request->image;
                $imageName= time().'.'.$image->getClientOriginalExtension();//getting timestamp+jpg or png
                $image->move(public_path('uploads/products'),$imageName);//taking the path and the file name 
                $product->image= $imageName;
                $product->save(); 
            }
    
    
            return redirect(route('products.index'))->with('success','Product update successfully'); //send success message 
        
        }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product=Product::findorFail($id);

        if($product->image != null && File::exists(public_path('uploads/products/'.$product->image))){
            File::delete(public_path('uploads/products/'. $product->image)); 

        }

        $product->delete();

        return redirect(route('products.index'))->with('success', 'Product deleted successfully');
    }
}
