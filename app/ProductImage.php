<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
