<?php

namespace App\Http\Controllers\Dashboard\Utils;

use App\Http\Controllers\Controller;
use App\Models\AcademicLicense;
use App\Models\profileImage;
use Illuminate\Support\Str;

class MediaController extends Controller
{

    /**
     * handle uploaded media to store in database and server
     *
     * @param $media
     * @param $request
     * @param $key
     * @return mixed
     */
    public static function upload($request, $images, $userId)
    {
        (new self)->validate($request, ['file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);

        foreach ($images as $photo) {
            $name = self::name($photo);

            $photo->move("assets/media/", $name);
            
            profileImage::create( ['user_id' => $userId, 'image' => "assets/media/$name"]);
        }
    }

    /**
     * create new for new file
     *
     * @param $media
     * @return string
     */
    private static function name($photo): string
    {
        $name = str_replace([" ", "", "-", "/", "'", "\"", ":"], "_", now() . "_" . Str::random(10));

        return "ma_$name." . $photo->extension();
    }
}
