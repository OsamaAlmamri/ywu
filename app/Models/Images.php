<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Kyslik\ColumnSortable\Sortable;
use Image;

class Images extends Model
{
    //
    use Sortable;

    public $sortable = ['id', 'name'];

    public function image_category()
    {

        return $this->hasMany('App\Image_category');
    }

    public function getimages()
    {


        $allimagesth = DB::table('images')
            ->leftJoin('image_categories', 'images.id', '=', 'image_categories.image_id')
            ->select('path', 'images.id', 'image_type')
            ->where('image_categories.image_type', 'THUMBNAIL')
            ->orderby('images.id', 'DESC')
            ->get();
        $allimages = DB::table('images')
            ->leftJoin('image_categories', 'images.id', '=', 'image_categories.image_id')
            ->select('path', 'images.id', 'image_type')
            ->where('image_categories.image_type', 'ACTUAL')
            ->orderby('images.id', 'DESC')
            ->get();

        $result = $allimages->merge($allimagesth)->keyBy('id');

        return $result;

    }


    public function getimagedetail($id)
    {

        $imagesdetail = DB::table('images')
            ->leftJoin('image_categories', 'images.id', '=', 'image_categories.image_id')
            ->where('images.id', $id)
            ->get();

        return $imagesdetail;


    }


    public function imagedata($filename, $Path, $width, $height, $user_id = null)
    {

        if (Auth::user()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = $user_id;
        }

        $imagedata = DB::table('images')->insert([
            ['name' => $filename, 'user_id' => $user_id]
        ]);
        $getimage_id = DB::table('images')->where('name', $filename)->first();

        $image_id = $getimage_id->id;

        $imagecatedata = DB::table('image_categories')->insert([
            ['image_id' => $image_id, 'image_type' => '1', 'height' => $height, 'width' => $width, 'path' => $Path]
        ]);
        return $image_id;

    }

    public function thumbnailrecord($filename, $Path, $width, $height)
    {
        $getimage_id = DB::table('images')->where('name', $filename)
            ->first();
        $image_id = $getimage_id->id;

        $imagecatedata = DB::table('image_categories')->insert([
            ['image_id' => $image_id, 'image_type' => '2', 'height' => $height, 'width' => $width, 'path' => $Path]
        ]);
    }


    public function Mediumrecord($filename, $Path, $width, $height)
    {
        $getimage_id = DB::table('images')->where('name', $filename)->first();
        $image_id = $getimage_id->id;
        $imagecatedata = DB::table('image_categories')->insert([
            ['image_id' => $image_id, 'image_type' => '4', 'height' => $height, 'width' => $width, 'path' => $Path]
        ]);

    }

    public function Largerecord($filename, $Path, $width, $height)
    {

        $getimage_id = DB::table('images')->where('name', $filename)->first();

        $image_id = $getimage_id->id;

        $imagecatedata = DB::table('image_categories')->insert([
            ['image_id' => $image_id, 'image_type' => '3', 'height' => $height,
                'width' => $width, 'path' => $Path,
                'updated_at' => date('y-m-d h:i:s')]
        ]);


    }

    public function thumbnailHeightWidth()
    {
        $Thumbnail_height = setting('Thumbnail_height', '150');
        $Thumbnail_width = setting('Thumbnail_width', '150');

        $thumbnailsetting = array($Thumbnail_height, $Thumbnail_width);
        return $thumbnailsetting;
    }

    public function MediumHeightWidth()
    {
        $Medium_height = setting('Medium_height', '400');
        $Medium_width = setting('Medium_width', '400');

        $Mediumsetting = array($Medium_height, $Medium_width);


        return $Mediumsetting;
    }

    public function LargeHeightWidth()
    {
        $Large_height = setting('Large_height', 900);
        $Large_width = setting('Large_width', '900');
        $Largesetting = array($Large_height, $Large_width);


        return $Largesetting;
    }

    public function AllimagesHeightWidth()
    {
        $Thumbnail_height = setting('Thumbnail_height', '150');
        $Thumbnail_width = setting('Thumbnail_width', '150');
        $Medium_height = setting('Medium_height', '400');
        $Medium_width = setting('Medium_width', '400');
        $Large_height = setting('Large_height', '900');
        $Large_width = setting('Large_width', '900');
        $AllImagessetting = array($Thumbnail_height, $Thumbnail_width,
            $Medium_height, $Medium_width
        , $Large_height, $Large_width);
        return $AllImagessetting;
    }

    public function imagedelete($id)
    {
        $imagesdetail = DB::table('images')
            ->where('images.id', $id)
            ->delete();

        $imagesdetailcategories = DB::table('image_categories')
            ->where('image_categories.image_id', $id)
            ->delete();
        return $imagesdetailcategories;
    }


    //regenerate section
    public function regenerate($image_id, $id, $width, $height)
    {
        $origianl_record = DB::table('image_categories')
            ->select('path')
            ->where('image_categories.image_id', $image_id)
            ->where('image_categories.image_type', 'ACTUAL')
            ->first();

        $required_record = DB::table('image_categories')
            ->select('path')
            ->where('image_categories.id', $id)
            ->first();


        $original_image_path = $origianl_record->path;
        $required_image_full_path = $required_record->path;

        //delete old size image
        if (file_exists($required_image_full_path)) {
            unlink($required_image_full_path);
        }


        //get name and path of required image
        $total_string = strlen($required_image_full_path);
        $required_imag_path = substr($required_image_full_path, 0, 21);
        $filename = substr($required_image_full_path, 21, $total_string);

        $destinationPath = public_path($required_imag_path);
        $saveimage = Image::make($original_image_path, array(

            'width' => $width,

            'height' => $height,

            'grayscale' => false));

        $namethumbnail = $saveimage->save($destinationPath . $filename);

        $Path = $required_image_full_path;
        $destinationFile = public_path($Path);
        $size = getimagesize($destinationFile);
        list($width, $height, $type, $attr) = $size;

        DB::table('image_categories')->where('id', $id)->update(
            [
                'width' => $width,
                'height' => $height,
                'updated_at' => date('y-m-d h:i:s')
            ]);

        return $namethumbnail;
    }

    public function regenrateAll($request)
    {
        //get settings
        $AllImagesSettingData = $this->AllimagesHeightWidth();

        $images = DB::table('images')
            ->leftJoin('image_categories', 'images.id', '=', 'image_categories.image_id')
            ->where('image_type', 'ACTUAL')
            //->where('image_categories.image_id',446)
            ->get();

        foreach ($images as $image) {
            $image_path = $image->path;
            $image_id = $image->image_id;

            $size = getimagesize($image_path);
            list($width, $height, $type, $attr) = $size;

            switch (true) {
                case ($width >= $AllImagesSettingData[5] || $height >= $AllImagesSettingData[4]):

                    $tuhmbnail = $this->regenerateimages($image_id, $AllImagesSettingData[0], $AllImagesSettingData[1], 'THUMBNAIL');
                    $mediumimage = $this->regenerateimages($image_id, $AllImagesSettingData[2], $AllImagesSettingData[3], 'MEDIUM');
                    $largeimage = $this->regenerateimages($image_id, $AllImagesSettingData[4], $AllImagesSettingData[5], 'LARGE');
                    break;
                case ($width >= $AllImagesSettingData[3] || $height >= $AllImagesSettingData[2]):
                    $tuhmbnail = $this->regenerateimages($image_id, $AllImagesSettingData[0], $AllImagesSettingData[1], 'THUMBNAIL');
                    $mediumimage = $this->regenerateimages($image_id, $AllImagesSettingData[2], $AllImagesSettingData[3], 'MEDIUM');
                    break;
                case ($width >= $AllImagesSettingData[0] || $height >= $AllImagesSettingData[1]):
                    $tuhmbnail = $this->regenerateimages($image_id, $AllImagesSettingData[0], $AllImagesSettingData[1], 'THUMBNAIL');
                    break;
            }

        }


    }

    //regenerate section
    public function regenerateimages($image_id, $width, $height, $image_type)
    {
        $origianl_record = DB::table('image_categories')
            ->select('path')
            ->where('image_categories.image_id', $image_id)
            ->where('image_categories.image_type', 'ACTUAL')
            ->first();

        $required_record = DB::table('image_categories')
            //->where('image_categories.id',$id)
            ->where('image_categories.image_id', $image_id)
            ->where('image_categories.image_type', $image_type)
            ->first();

        $original_image_path = $origianl_record->path;

        if ($required_record) {
            $required_image_full_path = $required_record->path;
            $id = $required_record->id;

            //delete old size image
            if (file_exists($required_image_full_path)) {
                unlink($required_image_full_path);
            }

            $total_string = strlen($required_image_full_path);
            $required_imag_path = substr($required_image_full_path, 0, 21);
            $filename = substr($required_image_full_path, 21, $total_string);

        } else {
            $required_image_full_path = $original_image_path;
            $total_string = strlen($original_image_path);
            $required_imag_path = substr($original_image_path, 0, 21);
            $filename = substr($original_image_path, 21, $total_string);
            $filename = strtolower($image_type) . time() . $filename;
        }

        $destinationPath = public_path($required_imag_path);
        $saveimage = Image::make($original_image_path, array(

            'width' => $width,

            'height' => $height,

            'grayscale' => false));

        $namethumbnail = $saveimage->save($destinationPath . $filename);

        $path = $required_imag_path . $filename;
        $destinationFile = $path;
        $size = getimagesize($destinationFile);
        list($width, $height, $type, $attr) = $size;

        //check insert or update
        if ($required_record) {

            DB::table('image_categories')->where('id', $id)->update(
                [
                    'width' => $width,
                    'height' => $height,
                    'updated_at' => date('y-m-d h:i:s')
                ]);
        } else {
            DB::table('image_categories')->insert(
                [
                    'width' => $width,
                    'height' => $height,
                    'created_at' => date('y-m-d h:i:s'),
                    'image_id' => $image_id,
                    'path' => $path,
                    'image_type' => $image_type
                ]);
        }

        return $namethumbnail;
    }


}
