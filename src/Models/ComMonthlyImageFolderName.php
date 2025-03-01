<?php

namespace Noobtrader\LaravelMediaLibrary\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComMonthlyImageFolderName extends Model
{
	use HasFactory;
	protected $table = "com_monthly_image_folder_names";
	protected $primaryKey = 'FolderId';
	protected $guarded = [];
}
