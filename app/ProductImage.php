<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileNotFoundException;

class ProductImage extends Model
{
    protected $table = 'product_images';

    public function getURLAttribute() {
        if(env('FILE_DISC') == 's3') {
            return "https://s3." . env('AWS_REGION') . ".amazonaws.com/" . env('AWS_BUCKET') . "/" . $this->attributes['location'];
        } else {
            return url('uploads/' . $this->attributes['location']);
        }
    }

    public function product() {
        return $this->belongsTo('App\Product');
    }

    /**
     * Override parent delete
     * Updates product references and deletes disk storage
     * @throws FileNotFoundException
     */
    public function delete() {
        //Update parent product if has thumbnail set to the image to be deleted
        $products = $this->product()->get();

        foreach($products as $p) {
            if($p->thumbnail_id == $this->attributes['id']) {
                $p->thumbnail_id = null;
                $p->save();
            }
        }

        try {
            Storage::disk(env('FILE_DISC'))->delete($this->attributes['location']);
        } catch(FileNotFoundException $e) {
            //Carry on
        }

        parent::delete();
    }
}
