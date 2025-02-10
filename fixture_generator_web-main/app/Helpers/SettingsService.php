<?php
namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;

class SettingsService{
    protected Collection $settings;
    protected bool $isLoaded = false;

    public function get($key, $default = null){
        return $this->getCollection()->get($key, $default);
    }


    public function getCollection(): Collection{
        $collection = null;
        if(!$this->isLoaded){

        }
        else{
            $collection = Setting::query()->get();
            $this->isLoaded = true;
        }

        $this->settings = $collection;
        return $this->settings;
    }
}