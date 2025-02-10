<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BaseModel;
use Exception;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Validator;

/**
 *
 *
 * @method EloquentDataTable datatableHook(EloquentDataTable $datatable): EloquentDataTable
 * @method array indexHook(Request $compact): array
 * @method array formHook(Request $form): array
 * @method array storeHook(Request $params): array
 * @method bool storeAfter(Model $object, Array $params, Request $request)
 * @method bool updateAfter(Model $object, Array $params, Request $request)
 * @method array updateHook(Request $params): array
 * @method Validator|NULL updateValidateHook(Request $request, Model $data): Validator|NULL
 * @method Validator|NULL storeValidateHook(Request $request): Validator|NULL
 */
class BaseController extends Controller
{
    use BasePattern;

    protected $container;

    public function __construct()
    {
        $container = (object)array(
            'title' => $this->title,
            'page' => $this->page,
        );

        $this->setContainer($container);
        $this->addBreadCrumb('Ana Sayfa', route('panel.show'));
        View::share('container', $container);
    }

    public function indexQuery($query, Request $request)
    {
        if ($request->has('filter_by')) {
            $filterArr = Arr::where($request->filter_by, function ($value, $key) {
                return $value != -1;
            });

            $query->where(
                $filterArr
            );
        }
        return $query;
    }
    public function index(Request $request)
    {
        if ($request->has('datatable')) {
            $select = (isset($this->listQuery) ? $this->listQuery : $this->model::orderBy('id', 'DESC')->select());

            if (method_exists($this, 'indexQuery')) {
                $select = $this->indexQuery($select, $request);
            }

            $obj = datatables()->of($select);

            if (method_exists($this, 'datatableHook')) {
                $obj = $this->datatableHook($obj);
            }

            $obj = $obj
                ->editColumn('created_at', function ($item) {
                    return (!is_null($item->created_at) ? $item->created_at->format('d.m.Y H:i') : '-');
                })
                ->editColumn('updated_at', function ($item) {
                    return (!is_null($item->updated_at) ? $item->updated_at->format('d.m.Y H:i') : '-');
                })
                ->editColumn('deleted_at', function ($item) {
                    return (!is_null($item->deleted_at) ? $item->deleted_at->format('d.m.Y H:i') : '-');
                })
                ->editColumn('image', function ($item) {
                    return !is_null($item->image) ? URL::to("upload/" . $this->page . "/" . $item->image) : NULL;
                })
                // ->editColumn('is_active', function ($item) {
                //     return $item->is_active == 1 ? 'Aktif' : 'Pasif';
                // })
                ->editColumn('created_by', function ($item) {
                    return $item->createdBy->name ?? null;
                });

            $obj = $obj->addIndexColumn()->make(true);

            return $obj;
        }

        $compact = [
            "request" => $request,
        ];

        if (method_exists($this, 'indexHook')) {
            $compact = $this->indexHook($compact);
        }


        return view("backend." . $this->page . ".all", $compact);
    }
    public function create(Request $request)
    {
        $compact = [
            "request" => $request,
        ];

        $compact['data'] = new BaseModel;

        if (method_exists($this, 'formHook')) {
            $compact = $this->formHook($compact);
        }


        if (view()->exists("backend." . $this->page . ".form")) {
            return view("backend." . $this->page . ".form", $compact);
        }



        return view("backend." . $this->page . ".create", $compact);
    }
    public function store(Request $request)
    {
        if (method_exists($this, 'storeValidateHook')) {
            $valid = $this->storeValidateHook($request);

            if ($valid instanceof Validator) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => $valid->errors()->first()
                ]);
            }
        }

        $params = $request->all();

        if (method_exists($this, 'storeHook')) {
            try {
                $params = $this->storeHook($request);
            } catch (Exception $ex) {
                if (request()->ajax()) {
                    return response()->json([
                        'status' => false,
                        'message' => $ex->getMessage()
                    ]);
                }

                return redirect()->back()->withError($ex->getMessage());
            }
        }

        if ($request->hasFile('profile_photos')) {
            $path = '/upload/user/';

            $image = $request->file('profile_photos');
            $original_name = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $filename = Carbon::now()->format('YmdHis') . '-' . $original_name;

            Storage::putFileAs(
                $path,
                $image,
                $filename
            );
            $params['profile_photo'] = $filename;
        }
        if ($request->hasFile('images')) {
            $path = '/upload/' . $this->page;

            $image = $request->file('images');
            $original_name = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $filename = Carbon::now()->format('YmdHis') . '-' . $original_name;

            Storage::putFileAs(
                $path,
                $image,
                $filename
            );
            $params['image'] = $filename;
        }

        if ($request->password) {
            $params['password'] = Hash::make($request['password']);
        }

        $object = $this->model::create($params);

        if ($object) {
            if (method_exists($this, 'storeAfter')) {
                return $this->storeAfter($object, $params, $request);
            }
        }

        if (request()->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Kayıt başarıyla eklendi.',
            ]);
        }

        return redirect()->route($this->page . ".index")->with(['success' => "Ekleme işleminiz başarılı."]);
    }

    public function show(Request $request)
    {
        $data = $this->model::find($request->id);

        if (!$data) {
            return redirect()->back()->withError("Kayıt bulunamadı!");
        }

        $compact = [
            "data" => $data,
            "request" => $request,
        ];

        return view("backend." . $this->page . ".show", $compact);
    }

    public function edit(Request $request)
    {
        $data = $this->model::find($request->id);

        if (!$data) {
            return redirect()->back()->withError("Kayıt bulunamadı!");
        }

        $compact = [
            "data" => $data,
            "request" => $request,
        ];

        if (method_exists($this, 'formHook')) {
            $compact = $this->formHook($compact);
        }

        if (view()->exists("backend." . $this->page . ".form")) {
            return view("backend." . $this->page . ".form", $compact);
        }

        return view("backend." . $this->page . ".edit", $compact);
    }

    public function update(Request $request, $model = null)
    {
        $data = $this->model::query()->where('id', $request->id)->first();

        if (!$data) {

            if (request()->ajax() or request()->acceptsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Kayıt bulunamadı!.',
                ]);
            }

            return redirect()->route($this->page . '.index')->withError("Kayıt bulunamadı!");
        }

        if (method_exists($this, 'updateValidateHook')) {
            $valid = $this->updateValidateHook($request, $data);

            if ($valid instanceof Validator) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => $valid->errors()->first()
                ]);
            }
        }

        $params = $request->all();
        if ($request->hasFile('profile_photos')) {
            $path = '/upload/user/';

            $image = $request->file('profile_photos');
            $original_name = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $filename = Carbon::now()->format('YmdHis') . '-' . $original_name;

            Storage::putFileAs(
                $path,
                $image,
                $filename
            );
            $params['profile_photo'] = $filename;
        }
        if ($request->hasFile('images')) {
            $path = '/upload/' . $this->page;

            $image = $request->file('images');
            $original_name = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $filename = Carbon::now()->format('YmdHis') . '-' . $original_name;

            Storage::putFileAs(
                $path,
                $image,
                $filename
            );
            $params['image'] = $filename;
        }

        if ($request->password) {
            $params['password'] = Hash::make($request['password']);
        }

        if (method_exists($this, 'updateHook')) {
            $params = $this->updateHook($params);
        }

        if ($request->hasFile('profile_image')) {
            $path = $this->page;

            $image = $request->file('profile_image');
            $original_name = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $filename = Carbon::now()->format('YmdHis') . '-' . $original_name;

            Storage::putFileAs(
                $path,
                $image,
                $filename
            );

            $data->files()->create([
                'type' => 'profile_image',
                'path' => $path . '/' . $filename,
            ]);
        }
        $data->updateOrFail($params);

        if (method_exists($this, 'updateAfter')) {
            return $this->updateAfter($data, $params, $request);
        }

        if (request()->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Kayıt başarıyla güncellendi.',
            ]);
        }

        return redirect()->route($this->page . ".index")->with(["success" => "Güncelleme işleminiz başarılı."]);
    }

    public function patch(Request $request)
    {
        $data = $this->model::find($request->id);

        if (!$data) {

            if ($request->isAjax() or $request->wantsJson()) {
                return response()->json(['status' => false, 'message' => "Kayıt bulunamadı!"]);
            }

            return redirect()->route($this->page . '.index')->withError("Kayıt bulunamadı!");
        }

        $params = $request->except(['id', '_token', 'image', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at', 'DT_RowIndex']);

        $data->update($params);

        return response()->json(['status' => true, 'message' => "Güncelleme işleminiz başarılı."]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|array|min:1',
            'id.*' => 'required|integer|exists:' . $this->model->getTable() . ',id',
        ]);

        $dd = $this->model->query()->whereIn('id', array_map('intval', $request->id))->delete();

        return response()->json(['status' => true, 'message' => "Silme işleminiz başarılı."]);
        $data = $this->model::find($request->id);

        if (!$data) {
            return response()->json(['status' => false, 'message' => "Kayıt bulunamadı!"]);
        }

        $data->delete();

        if (method_exists($this, 'deleteAfter')) {
            return $this->deleteAfter($data);
        }

        return response()->json(['status' => true]);
    }



    public function setContainer($data)
    {
        $this->container = $data;
    }

    public function getContainer()
    {
        return $this->container;
    }
}

trait BasePattern
{
    protected $title;
    protected $page;
    protected ?Model $model;
    protected ?Builder $listQuery;

    protected ?array $rules = [];
    protected ?array $updateRules = [];

    protected ?array $mesages;
    protected ?array $attributes;

    protected ?bool $shouldValidate = false;
    protected ?Collection $breadCrumb = null;
    public ?Collection $ajaxFields = null;

    public function isValid($type = 'store'): bool|\Illuminate\validation\Validator
    {
        $rules = null;

        if (count($this->rules) <= 0 and count($this->updateRules) <= 0) {
            $rules = null;
        } else {
            $rules = $type == 'store' ? $this->rules : (count($this->updateRules) > 0 ? $this->updateRules : $this->rules);
        }
        if ($rules == null) {
            return 'ok';
        }

        $validator = ValidatorFacade::make(request()->all(), $rules, [], $this->attributes ?? []);

        if (request()->ajax()) {
            if ($validator->fails()) {
                return $validator;
            }
        } else {
            $validator->validate();
        }

        return 'ok';
    }

    public function getModel()
    {
        return $this->model;
    }

    public function addBreadCrumb($title = null, $url = null)
    {

        if ($this->breadCrumb == null)
            $this->breadCrumb = collect();

        $this->breadCrumb->push((object)array(
            'title' => $title,
            'url' => $url
        ));
    }
}
