<?php


namespace App\Actions\SubscriptionOptions;


use App\Models\SubscriptionOptions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

/**
 * Class StoreUpdateImage
 * @package App\Actions\SubscriptionOptions
 */
class StoreUpdateImage
{
    /**
     * @param SubscriptionOptions $subscriptionOptions
     * @param UploadedFile $file
     */
    public static function execute(SubscriptionOptions $subscriptionOptions, UploadedFile $file)
    {
        $folder = 'subscription-options';
        $filename = sprintf('%s.%s', Str::random(), $file->getClientOriginalExtension());
            if (File::exists(public_path('images/'.$folder)) == false) {
                File::makeDirectory(public_path('images/'.$folder), 0777, true, true);
            }
            Image::make($file)->save(public_path('images/'.$folder.'/').$filename);

            if (File::exists(public_path('images/'.$folder.'/'.$subscriptionOptions->image))) {
                File::delete(public_path('images/'.$folder.'/'.$subscriptionOptions->image));
            }
        $subscriptionOptions->image = $filename;
        $subscriptionOptions->save();
    }
}
