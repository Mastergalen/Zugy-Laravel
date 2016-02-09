<?php

namespace App\Http\Controllers\Admin;

use App\ProductImage;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileNotFoundException;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|image|max:' . config('site.maxImageSize'),
        ]);

        $location = $this->generateFilePath($request->file('file'));

        //Avoid hash collision
        while(Storage::disk(env('FILE_DISC'))->exists($location)) {
            $location = $this->generateFilePath($request->file('file'));
        }

        Storage::disk(env('FILE_DISC'))->put($location, file_get_contents($request->file('file')->getRealPath()));

        $image = new ProductImage();
        $image->location = $location;
        $image->save();

        $this->garbageCollect();

        return response()->json(['status' => 'success', 'id' => $image->id]);
    }

    public function destroy($id)
    {
        $image = ProductImage::find($id);

        if($image != null)  {
            //Update parent product if has thumbnail set to the image to be deleted
            $products = $image->product()->get();

            foreach($products as $p) {
                if($p->thumbnail_id == $id) {
                    $p->thumbnail_id = null;
                    $p->save();
                }
            }

            try {
                Storage::disk(env('FILE_DISC'))->delete($image['location']);
            } catch(FileNotFoundException $e) {
                //Carry on
            }

            $image->delete();
        }

        return response()->json(['status' => 'success', 'id' => $id]);
    }

    /**
     * Delete orphaned images
     */
    public function garbageCollect()
    {
        $toBeDeleted = ProductImage::whereNull('product_id')
            ->where('created_at', '<', Carbon::now()->subHour(24)); //Orphaned images older than 24h deleted

        foreach($toBeDeleted->get() as $d) {
            Storage::disk(env('FILE_DISC'))->delete($d['location']);
        }

        $toBeDeleted->delete();
    }

    public function generateFilePath($file)
    {
        $now = Carbon::now();

        $path = "product-images/" .
            "{$now->year}/{$now->month}/{$now->day}/" .
            str_random(32) . "." . $file->guessClientExtension();

        return $path;
    }
}
