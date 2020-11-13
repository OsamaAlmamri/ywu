<?php

namespace App\Traits;

use Carbon\Carbon;

trait FileTrait
{

    public function File_Save($file, $symbol, $path)
    {
        $datetime = Carbon::now()->format('YmdHis');
        $filename = $path . '/' . $symbol . $datetime . ' . ' . $file->getClientOriginalExtension();
        $file->move(public_path($path), $filename);
        return $filename;
    }
}
