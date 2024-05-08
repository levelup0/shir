<?php


namespace App\Actions\Thanks;


use App\Models\Thanks;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

/**
 * Class StoreUpdateImage
 * @package App\Actions\Thanks
 */
class StoreUpdateImage
{
    /**
     * @param Thanks $thanks
     * @param UploadedFile $file
     */
    public static function execute(Thanks $thanks, UploadedFile $file)
    {
        $folder = 'thanks';
        $filename = sprintf('%s.%s', Str::random(), $file->getClientOriginalExtension());
            if (File::exists(public_path('images/'.$folder)) == false) {
                File::makeDirectory(public_path('images/'.$folder), 0777, true, true);
            }
            Image::make($file)->save(public_path('images/'.$folder.'/').$filename);

            if (File::exists(public_path('images/'.$folder.'/'.$thanks->image))) {
                File::delete(public_path('images/'.$folder.'/'.$thanks->image));
            }
        $thanks->image = $filename;
        $thanks->save();
    }
}
