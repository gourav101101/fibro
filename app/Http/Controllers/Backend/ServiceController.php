<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;use App\Models\Service;use App\Support\AdminImage;use Illuminate\Http\Request;use Illuminate\Support\Str;
class ServiceController extends Controller
{
 public function index(){return view('backend.services.index',['services'=>Service::orderBy('sort_order')->get()]);}
 public function create(){return view('backend.services.create');}
 private function data(Request $request,?Service $service=null):array{
  $data=$request->validate(['name'=>'required|string|max:255','title'=>'nullable|string|max:255','text'=>'nullable|string','image'=>'nullable|string|max:255','image_file'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:8192','points'=>'nullable|array','is_active'=>'boolean']);
  $data['image']=AdminImage::store($request->file('image_file'),'uploads/services',$service?->image ?? ($data['image'] ?? null));unset($data['image_file']);$data['slug']=Str::slug($data['name']);$data['is_active']=$request->boolean('is_active');return $data;
 }
 public function store(Request $request){Service::create($this->data($request));return redirect()->route('admin.services.index')->with('success','Service created successfully.');}
 public function edit(Service $service){return view('backend.services.edit',compact('service'));}
 public function update(Request $request,Service $service){$service->update($this->data($request,$service));return redirect()->route('admin.services.index')->with('success','Service updated successfully.');}
 public function destroy(Service $service){AdminImage::deleteManaged($service->image);$service->delete();return redirect()->route('admin.services.index')->with('success','Service deleted successfully.');}
}
