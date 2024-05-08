<?php


namespace App\Actions\SettingsEmail;


use App\Models\SettingsEmail;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

/**
 * Class StoreUpdateImage
 * @package App\Actions\IpTelOptions
 */
class StoreUpdateImage
{
    /**
     * @param SettingsEmail $settingsEmail
     * @param UploadedFile $file
     */
    public static function execute(SettingsEmail $settingsEmail, UploadedFile $file)
    {
        $folder = 'ip-tel-options';
        $filename = sprintf('%s.%s', Str::random(), $file->getClientOriginalExtension());
            if (File::exists(public_path('images/'.$folder)) == false) {
                File::makeDirectory(public_path('images/'.$folder), 0777, true, true);
            }
            Image::make($file)->save(public_path('images/'.$folder.'/').$filename);

            if (File::exists(public_path('images/'.$folder.'/'.$settingsEmail->image))) {
                File::delete(public_path('images/'.$folder.'/'.$settingsEmail->image));
            }
        $settingsEmail->image = $filename;
        $settingsEmail->save();
    }
}
