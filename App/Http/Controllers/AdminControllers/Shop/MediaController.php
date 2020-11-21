<?php

namespace App\Http\Controllers\AdminControllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Images;
use App\Settings;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;
use Lang;

class MediaController extends Controller
{
    //
    public function __construct(Images $images)
    {
        $this->Images = $images;

    }

    public function refresh()
    {
        $Images = new Images();
        $allimage = $Images->getimages();
        return view("admin.shop.media.loadimages")->with('allimage', $allimage);
    }

    public function display()
    {
        return view("admin.shop.media.index");
    }

    public function settingmedia($requeest)
    {

        setting(['Thumbnail_height' => $requeest->ThumbnailHeight])->save();
        setting(['Thumbnail_width' => $requeest->ThumbnailWidth])->save();
        setting(['Medium_height' => $requeest->MediumHeight])->save();
        setting(['Medium_width' => $requeest->MediumWidth])->save();
        setting(['Large_height' => $requeest->Large_height])->save();
        setting(['Large_width' => $requeest->LargeWidth])->save();
        return "success";

    }

    public function updatemediasetting(Request $request)
    {
        $messages = "Content has been updated successfully!";

        try {
            $mediasetting = $this->settingmedia($request);
            if (isset($request->regenrate) and $request->regenrate == 'yes') {
                $Images = new Images();
                $regenrate = $Images->regenrateAll($request);
                $messages = Lang::get("labels.Setting and Sizes are updated now");
            }

            return redirect()->back()->with('update', $messages);

        } catch (Exception $e) {
            return \Illuminate\Support\Facades\Redirect::back()->withErrors($messages)->withInput($request->all());
        }

    }

    public function add()
    {
        $Images = new Images();
        $images = $Images->getimages();
        return view('admin.shop.media.addimages')
            ->with('images', $images);
    }

    public function fileUpload(Request $request)
    {
        // Creating a new time instance, we'll use it to name our file and declare the path
        $time = Carbon::now();
        // Requesting the file from the form
        $image = $request->file('file');
        $extensions = Settings::imageType();
        if ($request->hasFile('file') and
            in_array($request->file->extension(), $extensions)) {
            // getting size
            $size = getimagesize($image);
            list($width, $height, $type, $attr) = $size;
            // Getting the extension of the file
            $extension = $image->getClientOriginalExtension();
            // Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
            $directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
            // Creating the file name: random string followed by the day, random number and the hour
//            $filename = date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
            $filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;

            // This is our upload main function, storing the image in the storage that named 'public'
            $upload_success = $image->storeAs($directory, $filename,env('PublicFolder') );

            //store DB
            $Path = 'images/media/' . $directory . '/' . $filename;
            $Images = new Images();
            $imagedata = $Images->imagedata($filename, $Path, $width, $height);
            $AllImagesSettingData = $Images->AllimagesHeightWidth();

            switch (true) {
                case ($width >= $AllImagesSettingData[5]
                    || $height >= $AllImagesSettingData[4]):
                    $tuhmbnail = $this->storeThumbnial($Path, $filename, $directory, $filename);
                    $mediumimage = $this->storeMedium($Path, $filename, $directory, $filename);
                    $largeimage = $this->storeLarge($Path, $filename, $directory, $filename);
                    break;
                case ($width >= $AllImagesSettingData[3] || $height >= $AllImagesSettingData[2]):
                    $tuhmbnail = $this->storeThumbnial($Path, $filename, $directory, $filename);
                    $mediumimage = $this->storeMedium($Path, $filename, $directory, $filename);
                    //                $storeLargeImage = $Images->Largerecord($filename,$Path,$width,$height);
                    break;
                case ($width >= $AllImagesSettingData[0] || $height >= $AllImagesSettingData[1]):
                    $tuhmbnail = $this->storeThumbnial($Path, $filename, $directory, $filename);
                    //                $storeLargeImage = $Images->Largerecord($filename,$Path,$width,$height);
                    //                $storeMediumImage = $Images->Mediumrecord($filename,$Path,$width,$height);

                    break;
                //            default:
                //                $tuhmbnail = $this->storeThumbnial($Path,$filename,$directory,$filename);
                //                $storeLargeImage = $Images->Largerecord($filename,$Path,$width,$height);
                //                $storeMediumImage = $Images->Mediumrecord($filename,$Path,$width,$height);
            }

        } else {
            return "Invalid Image";
        }

    }

    public function storeThumbnial($Path, $filename, $directory, $input)
    {
        $Images = new Images();
        $thumbnail_values = $Images->thumbnailHeightWidth();

        $originalImage = $Path;

        $destinationPath = public_path('images/media/' . $directory . '/');
        $thumbnailImage = Image::make($originalImage, array(
            'width' => $thumbnail_values[1],
            'height' => $thumbnail_values[0],
            'grayscale' => false));
        $namethumbnail = $thumbnailImage
            ->save($destinationPath . 'thumbnail' . time() . $filename);

        $Path = 'images/media/' . $directory . '/' . 'thumbnail' . time() . $filename;
        $destinationFile = public_path($Path);
        $size = getimagesize($destinationFile);
        list($width, $height, $type, $attr) = $size;
        $Images = new Images();
        $storethumbnail = $Images->thumbnailrecord($input, $Path, $width, $height);
        return $namethumbnail;
    }

    public function storeMedium($Path, $filename, $directory, $input)
    {
        $Images = new Images();
        $Medium_values = $Images->MediumHeightWidth();

        $originalImage = $Path;

        $destinationPath = public_path('images/media/' . $directory . '/');
        $thumbnailImage = Image::make($originalImage, array(

            'width' => $Medium_values[1],

            'height' => $Medium_values[0],

            'grayscale' => false));
        $namemedium = $thumbnailImage->save($destinationPath . 'medium' . time() . $filename);
        $Path = 'images/media/' . $directory . '/' . 'medium' . time() . $filename;

        $destinationFile = public_path($Path);
        $size = getimagesize($destinationFile);
        list($width, $height, $type, $attr) = $size;

        $storeMediumImage = $Images->Mediumrecord($input, $Path, $width, $height);

        return $namemedium;
    }

    public function storeLarge($Path, $filename, $directory, $input)
    {
        $Images = new Images();
        $Large_values = $Images->LargeHeightWidth();

        $originalImage = $Path;

        $destinationPath = public_path('images/media/' . $directory . '/');
        $thumbnailImage = Image::make($originalImage, array(

            'width' => $Large_values[1],

            'height' => $Large_values[0],

            'grayscale' => false));
//        $upload_success = $thumbnailImage->save($directory, $filename, 'public');
        $namelarge = $thumbnailImage->save($destinationPath . 'large' . time() . $filename);

        $Path = 'images/media/' . $directory . '/' . 'large' . time() . $filename;
        $destinationFile = public_path($Path);
        $size = getimagesize($destinationFile);
        list($width, $height, $type, $attr) = $size;

        $storeLargeImage = $Images->Largerecord($input, $Path, $width, $height);

        return $namelarge;
    }

    public function detailimage($id)
    {
        $Images = new Images();
        $images = $Images->getimagedetail($id);
        //dd($imageDetail);
        //$returnHTML = view('admin.modal-body-view')->with('imageDetail', $imageDetail);
        $result['images'] = $images;
        $returnHTML = view('admin.shop.media.detail')->with('result', $result);

        return ($returnHTML);

    }

    public function regenerateimage(Request $request)
    {
        $Images = new Images();
        $images = $Images->regenerate($request->image_id, $request->id, $request->width, $request->height);
        //dd($imageDetail);
        //$returnHTML = view('admin.modal-body-view')->with('imageDetail', $imageDetail);
        $result['images'] = $images;
        return redirect()->back()->with('success', Lang::get("labels.imageresizedmsg"));
    }

    public function deleteimage(Request $request)
    {
        $images = explode(",", $request->images);
        foreach ($images as $image) {
            $Images = new Images();
            $imagedelete = $Images->imagedelete($image);
        }
        return 'success';

    }

}
