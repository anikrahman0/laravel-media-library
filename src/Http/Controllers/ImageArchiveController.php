<?php

namespace Noobtrader\LaravelMediaLibrary\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Noobtrader\LaravelMediaLibrary\Library\ImagePathGenerator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Noobtrader\LaravelMediaLibrary\Models\ImageArchive;
use Noobtrader\LaravelMediaLibrary\Library\FileServices\MonthlyFolder\CreateMonthlyFolder;

use Noobtrader\LaravelMediaLibrary\Library\Traits\DiskTrait; 


class ImageArchiveController extends BaseController
{
    use DiskTrait;
	protected $basePath;
	protected $basePathEnglish;
	protected $basePathBangla;
	protected $dbPath;
	protected $dbPathEn;
	protected $dbPathBn;

	public function __construct()
	{
        $this->diskInitialize();
		$this->basePathEnglish = Config::get('imagepath.base_paths.english');
		$this->basePathBangla = Config::get('imagepath.base_paths.bangla');
        $this->dbPathEn = Config::get('imagepath.base_paths.root_en');
        $this->dbPathBn = Config::get('imagepath.base_paths.root_bn');
        $this->cdn_url = Config::get('imagepath.cdn_url');
	}

    public function uploadImgToArchive(Request $request){

        $validator = Validator::make($request->all(), [
            'ImageArchivePath.*' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:1024',
        ]);

        // Define custom attribute names'
        // return response()->json(['disk'=> $this->disk, 'request' =>$request->all()]);
        $customAttributes = [];
        foreach ($request->file('ImageArchivePath') as $key => $file) {
            $customAttributes["ImageArchivePath.$key"] = 'Image ' . ($key + 1); // Customize the attribute name
        }
        $validator->setAttributeNames($customAttributes);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'errors',
                'errors' => $validator->errors(),
            ], 422); // Custom status code for validation errors
        }
        // if($request->ContentType=='english'){
        //     $this->basePath = $this->basePathEnglish;
        //     $this->dbPath = $this->dbPathEn;
        //     $path = $this->diskPathSelect($this->basePath);
        // }elseif($request->ContentType=='bangla'){
        //     $this->basePath = $this->basePathBangla;
        //     $this->dbPath = $this->dbPathBn;
        //     $path = $this->diskPathSelect($this->basePath);
        // }else{
        $this->basePath = $this->basePathBangla;
        $this->dbPath = $this->dbPathBn;
        $path = $this->diskPathSelect($this->basePath);
        // }
        extract((new ImagePathGenerator())->generatePath($this->basePath));

        // if ($this->disk === 'public') {
		// 	$CreateMonthlyFolder = new CreateMonthlyFolder($storePath);
		// 	$CreateMonthlyFolder->localPathGenerate($path.'/'.$storePath);
		// }elseif($this->disk === 'do_spaces' || $this->disk === 'minio') {
		// 	$CreateMonthlyFolder = new CreateMonthlyFolder($storePath);
		// 	$CreateMonthlyFolder->cloudPathGenerate($path.'/'.$storePath);
		// }
        $uploadedData = [];
        if (!empty($request->ImageArchivePath)) {
            foreach ($request->ImageArchivePath as $key => $image) {
                $imgFullPath = '';
                $ext = $image->extension();
                $f_n = Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME), '-');
                $imagename = $f_n . '-' . time() . '.' . $ext;
                // return response()->json(['success'=>$originalPath,'image'=>$imagename]);
                $imgFullPath .= $this->cdn_url.$originalPath. '/' .$imagename;
                // bg image
                $bgImage = $image->storeAs($originalPath, $imagename, $this->disk, 'public');
                $this->diskStorage->setVisibility($bgImage, 'public');

                $img = Image::make($image->path());
                // sm image
                $this->diskStorage->put($originalPath . '/SM/' . $imagename, $img->fit(300, 169, function ($constraint) {
					$constraint->aspectRatio();
				})->stream(), 'public');

                // thumb image
                $this->diskStorage->put($originalPath . '/THUMB/' . $imagename, $img->fit(120, 67, function
                ($constraint) {
					$constraint->aspectRatio();
				})->stream(), 'public');

                $imageSmName ='/SM/' . $imagename;
                $imageThumbName ='/THUMB/' . $imagename;
                $conetnt_gal_img_archive = [
                    'ImagePath' => $this->dbPath.$storePath . '/' . $imagename,
                    'ImageFileName' => $imagename,
                    'ImageSmPath' => $this->dbPath.$storePath . $imageSmName,
                    'ImageThumbPath' => $this->dbPath.$storePath . $imageThumbName,
                ];

                $insertedId = ImageArchive::insertGetId($conetnt_gal_img_archive);

                // Collect inserted ID and image path
                $uploadedData[$insertedId] = [
                    'imgFullPath' => $imgFullPath,
                    'imagename' => $this->dbPath.$storePath . '/' . $imagename,
                    'imageSmName' => $this->dbPath.$storePath . $imageSmName,
                    'imageThumbName' => $this->dbPath.$storePath . $imageThumbName,
                ];

            }
        }
        krsort($uploadedData);

        return response()->json(['success' => 'Image(s) uploaded successfully', 'images' => $uploadedData]);
    }

    public function imgSearch(Request $request)
	{
		// Validate the input
		$request->validate([
			// 'query' => 'required|string|min:3|max:200',
			'query' => 'required|string|max:200',
		]);

		$searchQuery = $request->input('query');
		$SearchType = $request->input('SearchType');

		// Retrieve images based on the query
        if($SearchType==1){
            $images = ImageArchive::where('ImageFileName', 'like', "%$searchQuery%")->limit(50)->get();
        }elseif($SearchType==2){
            $images = ImageArchive::where('HeadCaption', 'like', "%$searchQuery%")->limit(50)->get();
        }

		// Prepare HTML structure for the response
		$htmlResponse='';
		foreach ($images as $index => $image) {
			$imgFullPath = $this->cdn_url . '/media/' . $image->ImagePath;
            $caption = $image->HeadCaption;
            $imagename = $image->ImagePath;
            $imageSmPath = $image->ImageSmPath;
            $imageThumbPath = $image->ImageThumbPath;
            $archiveID =$image->ImgArchiveID;

            $htmlResponse.= '<div class="col-md-4 mb-4 mt-2">
                <div class="image-wrapper">
                    <div data-img-caption="'.$caption.'" data-img-id="'.$archiveID.'" data-img="'.$imagename.'" data-img-sm="'.$imageSmPath.'" data-img-thumb="'.$imageThumbPath.'"
                        class="img-selection img_'.$archiveID.'">
                            <div class="placeholder">
                                <img data-src="'.$imgFullPath.'" class="img-fluid lazyload" src="'.$imgFullPath.'" alt="">
                                <div class="edit-section" data-edit-id="'.$archiveID.'">
                                    <i class="fas fa-edit"></i>
                                    <span class="">Edit</span>
                                </div>
                            </div>
                        <div class="check">
                            <i class="fas fa-check showing"></i>
                            <i class="fas fa-minus hide"></i>
                        </div>
                    </div>
                </div>
            </div>';
			// }
		}
		// Return the HTML response directly as JSON
		return response()->json($htmlResponse);
	}

    public function updateArchive(Request $request)
	{
		// Validate the input
        $validator = Validator::make($request->all(), [
            'HeadCaption' => 'required|string|max:10000',
        ]);
         if ($validator->fails()) {
            return response()->json([
                'status' => 'errors',
                'errors' => $validator->errors(),
            ], 422); // Custom status code for validation errors
        }
		$caption = $request->input('HeadCaption');
		$archiveID = $request->input('archiveID');

        ImageArchive::where('ImgArchiveID',$archiveID)->update(['HeadCaption'=>$caption]);
        return response()->json(['success' => 'Image updated successfully']);
    }

    public  function diskPathSelect($selectedPath){
        $path ='';
        if($this->disk === 'public'){
            $path = public_path() . $selectedPath;
        }elseif($this->disk === 'do_spaces' || $this->disk === 'minio') {
            $path = $selectedPath;
        }
        return $path;
    }
}
