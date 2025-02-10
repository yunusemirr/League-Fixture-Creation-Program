<?php
use App\Models\Accounting\Payment;
use App\Models\File;
use App\Models\Role;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphOneOrMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

if(!function_exists('hds')){
    function hds(){
    }
}

if (!function_exists('buttonPrivacyControl')) {
    function buttonPrivacyControl($route_name)
    {
        $onuser = Auth::user();

        $permissions = null;

        if ($onuser->permissions != null) {
            $permissions = $onuser->permissions;
        } else {
            $user_role = Role::find($onuser->role_id);

            if (!$user_role) {
                return false;
            }

            if ($user_role->permissions == null) {
                return false;
            }

            $permissions = $user_role->permissions;
        }

        if (!in_array($route_name, json_decode($permissions, true))) {
            return false;
        }

        return true;
    }
}



if (!function_exists('fileManager')) {
    /**
     * The function takes in a model, file, and disk and outputs them using the dd function.
     *
     * @param Model model The first parameter `` is an instance of the `Model` class, which is a
     * Laravel Eloquent model. It represents a database table and provides methods for querying and
     * manipulating data in that table.
     * @param File file  is an instance of the File class, which represents a file that has been
     * uploaded or will be uploaded. It contains information about the file such as its name, size, and
     * type.
     * @param disk The disk parameter is a string that specifies the disk on which the file is stored.
     * It defaults to 'public', which is the default disk in Laravel's filesystem configuration. Other
     * possible values for the disk parameter could be 'local', 's3', or any other disk that has been
     * configured in the
     */
    function fileManager(Model $model, Symfony\Component\HttpFoundation\FileBag $files, $disk = 'upload')
    {
        if ($model->id == null) {
            return $model;
        }

        if (!method_exists($model, 'files')) {
            return $model;
        }

        if (!($model->files() instanceof MorphMany) and !($model->files() instanceof MorphOne) and !($model->files() instanceof MorphOneOrMany)) {
            return $model;
        }

        $path = class_basename($model) ?? 'uploads';

        foreach($files as $attribute => $file){
            if(!is_array($file))
            {
                $file = [$file];
            }

            foreach ($file as $item) {;
                $name = now()->timestamp.'_'.uniqid().'.'.$item->getClientOriginalExtension();
                $r = Storage::disk($disk)
                ->putFileAs(
                    str($path)->snake()->__toString(),
                    $item,
                    str($name)->snake()->__toString()
                );

                $model->files()->create([
                    'type' => $attribute,
                    'name' => $item->getClientOriginalName(),
                    'mime_type' => $item->getMimeType(),
                    'path' => $r,
                ]);
            }
        }

        return true;
    }
}

if (!function_exists('PhoneNumber')) {
    function PhoneNumber($phone)
    {
        return  preg_replace("/[^0-9]/", "", $phone);
    }
}
