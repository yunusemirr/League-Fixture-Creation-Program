<?php

namespace App\Http\Controllers\Backend;

use App\Models\Province;
use App\Models\Team;
use Kris\LaravelFormBuilder\Field;

class TeamController extends BaseController
{
    use BasePattern;

    public function __construct()
    {
        $this->page = "team";
        $this->title = "Teams";
        $this->model = new Team();
        $this->listQuery = $this->model->query()->where("is_active", 1)->with("province");
        $provinces = Province::query()->get();

        $this->ajaxFields = collect([
            "name" => [
                "type" => Field::TEXT,
                "label_attr" => ["class" => "required form-label"],
                "attr" => [
                    "required" => "required",
                ]
            ],
            "province_id" => [
                "type" => Field::SELECT,
                "label_attr" => ["class" => "required form-label"],
                "attr" => [
                    "required" => "required",
                ],
                "choices" => $provinces->mapWithKeys(function ($province) {
                    return [$province->id => $province->name];
                })->toArray()
            ],
            "color" => [
                "type" => Field::COLOR,
                "label_attr" => ["class" => "required form-label"],
                "attr" => [
                    "required" => "required",
                ],
                "default_value" => "#000000"
            ],
            "is_active" => [
                "type" => Field::SELECT,
                "label_attr" => ["class" => "required form-label"],
                "choices" => [
                    1 => __("enums.is_active.yes"),
                    0 => __("enums.is_active.no")
                ],
            ]
        ]);

        view()->share("provinces", $provinces);
        parent::__construct();
    }
}
