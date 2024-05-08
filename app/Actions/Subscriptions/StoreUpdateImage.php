<?php


namespace App\Actions\Subscriptions;


use App\Models\Subscriptions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

/**
 * Class StoreUpdateImage
 * @package App\Actions\Subscriptions
 */
class StoreUpdateImage
{
    /**
     * @param Subscriptions $subscriptions
     * @param UploadedFile $file
     */
    public static function execute(Subscriptions $subscriptions, UploadedFile $file)
    {
        $folder = 'subscriptions';
        $filename = sprintf('%s.%s', Str::random(), $file->getClientOriginalExtension());
            if (File::exists(public_path('images/'.$folder)) == false) {
                File::makeDirectory(public_path('images/'.$folder), 0777, true, true);
            }
            Image::make($file)->save(public_path('images/'.$folder.'/').$filename);

            if (File::exists(public_path('images/'.$folder.'/'.$subscriptions->image))) {
                File::delete(public_path('images/'.$folder.'/'.$subscriptions->image));
            }
        $subscriptions->image = $filename;
        $subscriptions->save();
    }
}
