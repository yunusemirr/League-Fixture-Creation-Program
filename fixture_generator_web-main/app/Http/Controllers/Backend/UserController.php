<?php
namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kris\LaravelFormBuilder\Field;

class UserController extends BaseController
{
    use BasePattern;

    public function __construct()
    {
        $this->page = "user";
        $this->title = __("models.user.model_name");
        $this->model = new User();
        $this->listQuery = $this->model->query();

        $this->ajaxFields = collect([
            "name" => [
                "type" => Field::TEXT,
                "label_attr" => ["class" => "required form-label"],
                "attr" => [
                    "required" => "required",
                ]
            ],
            "surname" => [
                "type" => Field::TEXT,
                "label_attr" => ["class" => "required form-label"],
                "attr" => [
                    "required" => "required"
                ]
            ],
            "email" => [
                "type" => Field::TEXT,
                "label_attr" => ["class" => "required form-label"],
                "attr" => [
                    "required" => "required",
                    "hd-component" => "email"
                ]
            ],
            "phone" => [
                "type" => Field::TEXT,
                "label_attr" => ["class" => "required form-label"],
                "attr" => [
                    "required" => "required",
                    "hd-component" => "phone"
                ]
            ],
            "tc" => [
                "type" => Field::TEXT,
                "label_attr" => ["class" => "required form-label"],
                "attr" => [
                    "required" => "required",
                    "hd-component" => "tc",
                ]
            ],
            "role_id" => [
                "type" => Field::SELECT,
                "label_attr" => ["class" => "required form-label"],
                "choices" => [
                    1 => "Kullanıcı",
                    2 => "Admin",
                ],
            ],
            "is_active" => [
                "type" => Field::SELECT,
                "label_attr" => ["class" => "required form-label"],
                "choices" => [
                    1 => __("enums.is_active.yes"),
                    0 => __("enums.is_active.no")
                ],
            ],
            "profile_image" => [
                "type" => Field::FILE,
                "attr" => [
                    "accept" => "image/*"
                ],
                "wrapper" => [
                    "class" => "col-12"
                ]
            ],
            "password" => [
                "type" => Field::PASSWORD,
                "wrapper" => [
                    "class" => "col-12"
                ]
            ],
        ]);

        parent::__construct();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|array|min:1',
            'id.*' => 'required|integer|exists:' . $this->model->getTable() . ',id',
        ]);

        $dd = $this->model->query()->whereIn('id', array_map('intval', $request->id))->forceDelete();
        return response()->json(['status' => true, 'message' => "Silme işleminiz başarılı."]);
    }

    public function storeValidateHook($request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "surname" => "required",
            "email" => "required|email|unique:users,email",
            "phone" => "required|unique:users,phone",
            "tc" => "required|digits:11|unique:users,tc",
            "role_id" => "required|in:1,2,3,4,5",
            "is_active" => "required|in:0,1",
            "password" => "required|min:6"
        ], [], __('models.user'));

        if ($request->ajax()) {
            if ($validator->fails()) {
                return $validator;
            }
        } else {
            $validator->validate();
        }

        return NULL;
    }
    public function updateValidateHook($request, $data)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "surname" => "required",
            "email" => "required|email|unique:users,email," . $data->id,
            "phone" => "required|unique:users,phone," . $data->id,
            "tc" => "required|digits:11|unique:users,tc," . $data->id,
            "role_id" => "required|in:1,2,3,4,5",
            "is_active" => "required|in:0,1",
            "password" => "nullable|min:6"
        ], [], __('models.user'));

        if ($request->ajax()) {
            if ($validator->fails()) {
                return $validator;
            }
        } else {
            $validator->validate();
        }

        return NULL;
    }

    public function ajaxCheck(Request $request){
        $exists = $this->model->where($request->get("search"), $request->get("value"))->get();

        return response()->json($exists);

    }
}
