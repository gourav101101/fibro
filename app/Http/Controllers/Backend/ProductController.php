<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;use App\Models\Product;use App\Support\AdminImage;use Illuminate\Http\Request;use Illuminate\Support\Str;
class ProductController extends Controller
{
 public function index(){return view('backend.products.index',['products'=>Product::orderBy('sort_order')->get()]);}
 public function create(){return view('backend.products.create');}
 private function data(Request $request,?Product $product=null):array{
  $data=$request->validate(['name'=>'required|string|max:255','title'=>'nullable|string|max:255','text'=>'nullable|string','material'=>'nullable|string|max:255','image'=>'nullable|string|max:255','image_file'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:8192','alt'=>'nullable|string|max:255','construction'=>'nullable|string|max:255','considerations'=>'nullable|array','is_active'=>'boolean']);
  $data['image']=AdminImage::store($request->file('image_file'),'uploads/products',$product?->image ?? ($data['image'] ?? null));unset($data['image_file']);$data['slug']=Str::slug($data['name']);$data['is_active']=$request->boolean('is_active');return $data;
 }
 public function store(Request $request){Product::create($this->data($request));return redirect()->route('admin.products.index')->with('success','Product created successfully.');}
 public function edit(Product $product){return view('backend.products.edit',compact('product'));}
 public function update(Request $request,Product $product){$product->update($this->data($request,$product));return redirect()->route('admin.products.index')->with('success','Product updated successfully.');}
 public function destroy(Product $product){AdminImage::deleteManaged($product->image);$product->delete();return redirect()->route('admin.products.index')->with('success','Product deleted successfully.');}
}
