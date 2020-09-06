<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait PostTrait
{
    use FileTrait;

    public function Post_Rules()
    {
        return [
            "title" => "required",
            "body" => "required",
//            "category_id" => "required|integer",
            //"sound"=>"mimetypes:application/octet-stream,audio/mpeg",
            "image" => "nullable|image|mimes:jpg,png,jpeg,gif,svg",
            "book" => "nullable|file|mimes:pdf,doc",
            //"sound"=>"mimetypes:application/octet-stream,audio/mpeg",
            //"sound"=>"nullable|mp3_ogg_extension",
        ];
    }

    public function Post_Messages()
    {
        return [
            "title.required" => "يرجى كتابة عنوان المنشور",
            "body.required" => "يرجى كتابة نص المحتوى",
            //"category_id.required" => "يرجى اختيار احد الاقسام للنشر فيه",
            "image.image" => "يرجى اختيار صورة للرفع",
            "image.mimes" => "يجب ان يكون امتداد الصورة: jpg,png,jpeg,gif,svg",
            //"image.max"=>"لايمكن رفع صورة حجمها اكبر من 2 ميغا بايت",
            "book.mimes" => "يرجى اختيار ملف من نوع: pdf,doc",
            //"book.max"=>"لايمكن رفع ملف حجمه اكبر من 2 ميغا بايت",
            //"sound.mp3_ogg_extension"=>"يجب ان يكون امتداد الملف الصوتي  mp3",
            //"sound.max"=>"لايمكن ان يكون حجم الملف الصوتي اكبر من 6 ميغا بايت",
        ];
    }

    public function Post_Save(Request $request, $type, $symbol, $path)
    {
        if ($request->file($type) != null) {
            $file = $request->file($type);
            return $this->File_Save($file, $symbol, $path);
        } else {
            return null;
        }
    }

    public function Post_update(Request $request, $type, $symbol, $path, $column)
    {
        if ($file = $request->file($type)) {
            if ($column != null) {
                if (File::exists($path . $column)) {
                    unlink($path . $column);
                }
                return $this->File_Save($file, $symbol, $path);
            } else {
                return $this->File_Save($file, $symbol, $path);
            }
        } else {
            if (File::exists($path . $column)) {
                if ($column == !null) {
                    unlink($path . $column);
                }
                return null;
            }
        }
    }

    public function Post_delete($path, $column)
    {
        if ($column != null) {
            if (File::exists($path . $column)) {
                unlink($path . $column);
            }
        }
    }
}
