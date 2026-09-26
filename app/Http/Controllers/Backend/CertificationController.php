<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;use App\Models\Certification;use App\Support\AdminImage;use Illuminate\Http\Request;
class CertificationController extends Controller
{
 public function index(){return view('backend.certifications.index',['certifications'=>Certification::orderBy('sort_order')->get()]);}
 public function create(){return view('backend.certifications.create');}
 private function data(Request $request,?Certification $certification=null):array{
  $data=$request->validate(['name'=>'required|string|max:255','image'=>'nullable|string|max:255','image_file'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:8192','category'=>'nullable|string|max:255','is_active'=>'boolean']);
  $data['image']=AdminImage::store($request->file('image_file'),'credentials/uploads/certifications',$certification?->image ?? ($data['image'] ?? null));unset($data['image_file']);$data['is_active']=$request->boolean('is_active');return $data;
 }
 public function store(Request $request){Certification::create($this->data($request));return redirect()->route('admin.certifications.index')->with('success','Certification created successfully.');}
 public function edit(Certification $certification){return view('backend.certifications.edit',compact('certification'));}
 public function update(Request $request,Certification $certification){$certification->update($this->data($request,$certification));return redirect()->route('admin.certifications.index')->with('success','Certification updated successfully.');}
 public function destroy(Certification $certification){AdminImage::deleteManaged($certification->image);$certification->delete();return redirect()->route('admin.certifications.index')->with('success','Certification deleted successfully.');}
}
