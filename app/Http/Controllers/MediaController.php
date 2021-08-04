<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Media;

class MediaController extends Controller
{
    public function index(){
		$medias = Media::all();
		return view('media.index', [
			'medias' => $medias
		]);
	}
	
	public function create(){
		
	}
	
	public function store(Request $request){
		$data = $request->all();
		
		try{
			$media = new Media;
			$media->name = pathinfo($data['file']->getClientOriginalName(), PATHINFO_FILENAME);
			$media->type = \File::mimeType($data['file']);
			$media->size = \File::size($data['file']);
			$media->format = \File::extension($data['file']->getClientOriginalName());
			$media->user_id = \Sentinel::getUser()->id;
			$media->status = 'publish';
			$media->save();
			
			$media->guid = 'uploads/'.date('Y').'/'.date('m').'/'.date('d').'/'.$media->slug.'.'.$media->format;
			$media->save();
			
			$img = \Image::make($data['file']);
			
			$path = public_path('uploads/'.date('Y').'/'.date('m').'/'.date('d'));
			
			if(!\File::exists($path)){
				\File::makeDirectory($path, 755, true);
			}
			
			$img->save(public_path($media->guid));
			
			// update activity log
			$log = array(
				'desc' => 'uploading new file '.$media->name
			);
			event(new \App\Events\UpdateData($media, $log));
		}catch (Exception $e) {
			return $e->getMessage();
		}
	}
	
	public function show(){
		
	}
	
	public function edit(){
		
	}
	
	public function update(){
		
	}
	
	public function destroy($media_id){
		$media = Media::find($media_id);
		$media->delete();
		
		unlink($media->guid);
		
		event(new \App\Events\UpdateData($media, array('desc' => 'removing media')));
		
		return array(
			'url' => route('media.index'),
			'message' => 'Media has been removed.'
		);
	}

	public function list(){
		$medias = Media::orderBy('created_at','desc')->get();
		return view('media.list', [
			'medias' => $medias
		]);
	}
	public function slideshowlist(){
		$medias = Media::orderBy('created_at','desc')->get();
		return view('media.slideshowlist', [
			'medias' => $medias
		]);
	}
	
	public function listImage(){
		$medias = Media::orderBy('created_at','desc')->get();
		return $medias;
	}
}
