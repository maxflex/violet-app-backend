<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Photo;

class PhotosController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'photos' => 'required',
            'photos.*' => 'image'
        ]);
        foreach($request->file('photos') as $file) {
            $extension = $file->getClientOriginalExtension();
            $original_name = $file->getClientOriginalName();
            $filename = uniqid() . '.' . $extension;
            $file->storeAs('public/' . Photo::UPLOAD_PATH, $filename);
            auth()->user()->photos()->create([
                'filename' => $filename
            ]);
        }
        return emptyResponse();
    }

    public function destroy($id)
    {
        $item = Photo::find($id);
        $this->authorize('delete', $item);
        $item->delete();
    }
}
