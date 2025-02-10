<?php
namespace App\Http\Controllers\Backend;

use App\Models\Article;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends BaseController
{
    use BasePattern;

    public function __construct()
    {
        $this->page = 'setting';
        $this->title = 'Ayarlar';
        $this->model = new Setting();
        $this->listQuery = $this->model->query();

        parent::__construct();
    }

    public function index(Request $request)
    {
        $setting = Setting::query()->get();

        return view("backend.setting.form", compact('setting'));
    }

    public function save(Request $request){
        $settings = $request->setting;

        foreach($settings as $key => $value){
            $s = Setting::query()->updateOrCreate([
                'key' => $key
            ], [
                'value' => $value
            ]);
        }

        return redirect()->route('setting.index')->with('success', __('messages.form.store_success'));
    }
}
