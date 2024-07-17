<?php 

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 

trait ImageUploadTrait {
    
    public function uploadImage(Request $request, $inputName, $path)
    {
        if($request->hasFile($inputName)){ 

            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_'.uniqid().'_'.$ext;
            $image->move(public_path($path), $imageName);

            return $path.'/'.$imageName; 
        }
    }

    public function updateImage(Request $request, $inputName, $path, $oldpath=null)
    {
        if($request->hasFile($inputName)){ 
            if(File::exists(public_path($oldpath))){
                File::delete(public_path($oldpath));
            }

            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_'.uniqid().'_'.$ext;
            $image->move(public_path($path), $imageName);

            return $path.'/'.$imageName; 
        }
    }
}