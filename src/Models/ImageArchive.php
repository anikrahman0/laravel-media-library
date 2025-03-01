<?php

namespace Noobtrader\LaravelMediaLibrary\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageArchive extends Model
{
    use HasFactory;
    protected $table = "image_archives";
    protected $primaryKey = 'ImgArchiveID';
    protected $guarded = [];
}
