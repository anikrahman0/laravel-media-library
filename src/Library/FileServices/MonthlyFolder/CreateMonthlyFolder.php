<?php

namespace Noobtrader\LaravelMediaLibrary\Library\FileServices\MonthlyFolder;

use Noobtrader\LaravelMediaLibrary\Library\Traits\DiskTrait;
use Illuminate\Support\Facades\Config;
use Noobtrader\LaravelMediaLibrary\Models\ComMonthlyImageFolderName;

class CreateMonthlyFolder {

    use DiskTrait;
	protected $subdirectories;
	protected $FolderName;

	public function __construct($FolderName)
	{
		$this->diskInitialize();
		$this->subdirectories = explode(',',Config::get('imagepath.subdirectories'));
		$this->FolderName = $FolderName;
	}
    public function localPathGenerate($path){
		if(!file_exists($path)){
			mkdir($path, 0775, true);
			if(!empty($this->subdirectories)){
				foreach ($this->subdirectories as $folder) {
					$subDirPath = $path . '/' . $folder;
					if (!file_exists($subDirPath)) {
						mkdir($subDirPath, 0775, true); // Create subdirectory
					}
				}
			}
		}
        $this->saveFolderToDB();
	}
	public function cloudPathGenerate($path){
		$this->diskStorage->makeDirectory($path);
		foreach ($this->subdirectories as $folder) {
			$subDirPath = $path . '/' . $folder;
			if (!$this->diskStorage->exists($subDirPath)) {
				$this->diskStorage->makeDirectory($subDirPath);
			}
		}
        $this->saveFolderToDB();
	}
	public function saveFolderToDB(){
        $dbMonthlyFolder = ComMonthlyImageFolderName::where('FolderName',$this->FolderName)->first();
        if(!$dbMonthlyFolder){
            $monthlyFolder = new ComMonthlyImageFolderName();
            $monthlyFolder->FolderName =$this->FolderName;
            $monthlyFolder->ImageFolderName =$this->FolderName;
            $monthlyFolder->save();
        }
	}
}
