<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;use App\Models\Material;use App\Support\AdminImage;use Illuminate\Http\Request;
class MaterialController extends Controller
{
 public function index(){return view('backend.materials.index',['materials'=>Material::orderBy('sort_order')->get()]);}
 public function edit(Material $material){return view('backend.materials.edit',compact('material'));}
 public function update(Request $request,Material $material){$data=$request->validate(['name'=>'required|string|max:255','category'=>'nullable|string|max:255','image'=>'nullable|string|max:255','image_file'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:8192','alt'=>'nullable|string|max:255','use'=>'nullable|string|max:255','description'=>'nullable|string','details'=>'nullable|string','attributes'=>'nullable|array']);$data['image']=AdminImage::store($request->file('image_file'),'uploads/materials',$material->image);unset($data['image_file']);$material->update($data);return redirect()->route('admin.materials.index')->with('success','Material updated successfully.');}
}
