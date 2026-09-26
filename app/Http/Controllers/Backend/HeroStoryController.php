<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;use App\Models\HeroStory;use App\Support\AdminImage;use Illuminate\Http\Request;
class HeroStoryController extends Controller
{
 public function index(){return view('backend.hero_stories.index',['stories'=>HeroStory::orderBy('sort_order')->get()]);}
 public function create(){return view('backend.hero_stories.create');}
 private function data(Request $request,?HeroStory $story=null):array{
  $data=$request->validate(['label'=>'required|string|max:255','eyebrow'=>'nullable|string|max:255','title_line1'=>'nullable|string|max:255','title_line2'=>'nullable|string|max:255','accent'=>'nullable|string|max:255','description'=>'nullable|string','image'=>'nullable|string|max:255','image_file'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:8192','alt'=>'nullable|string|max:255','action_text'=>'nullable|string|max:255','action_href'=>'nullable|string|max:255','is_dark'=>'boolean','is_active'=>'boolean']);
  $data['image']=AdminImage::store($request->file('image_file'),'uploads/hero-stories',$story?->image ?? ($data['image'] ?? null));unset($data['image_file']);$data['is_dark']=$request->boolean('is_dark');$data['is_active']=$request->boolean('is_active');return $data;
 }
 public function store(Request $request){HeroStory::create($this->data($request));return redirect()->route('admin.hero-stories.index')->with('success','Hero story created successfully.');}
 public function edit(HeroStory $hero_story){return view('backend.hero_stories.edit',compact('hero_story'));}
 public function update(Request $request,HeroStory $hero_story){$hero_story->update($this->data($request,$hero_story));return redirect()->route('admin.hero-stories.index')->with('success','Hero story updated successfully.');}
 public function destroy(HeroStory $hero_story){AdminImage::deleteManaged($hero_story->image);$hero_story->delete();return redirect()->route('admin.hero-stories.index')->with('success','Hero story deleted successfully.');}
}
