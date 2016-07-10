<?php

namespace App\Http\Controllers\Admin;

use App\ProductImage;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|image|max:' . config('site.maxImageSize'),
        ]);

        $location = $this->generateFilePath($request->file('file'));

        //Avoid hash collision
        while(Storage::disk(config('filesystems.default'))->exists($location)) {
            $location = $this->generateFilePath($request->file('file'));
        }

        Storage::disk(config('filesystems.default'))->put($location, file_get_contents($request->file('file')->getRealPath()));

        $image = new ProductImage();
        $image->location = $location;
        $image->save();

        $this->garbageCollect();

        \Log::info('Uploading new image', ['user_id' => auth()->user()->id, 'ip' => $_SERVER['REMOTE_ADDR'], 'image_id' => $image->id]);

        return response()->json(['status' => 'success', 'id' => $image->id]);
    }

    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);

        $image->delete();

        \Log::info('Deleting image', ['user_id' => auth()->user()->id, 'ip' => $_SERVER['REMOTE_ADDR'], 'image_id' => $id]);

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
            Storage::disk(config('filesystems.default'))->delete($d['location']);
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
