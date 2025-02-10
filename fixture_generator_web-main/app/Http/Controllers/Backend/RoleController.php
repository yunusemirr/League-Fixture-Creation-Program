<?php
namespace App\Http\Controllers\Backend;

use App\Models\RouteDB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{
    use BasePattern;

    public function __construct()
    {
        $this->page = 'role';
        $this->title = __('models.role.model_name');
        $this->model = new Role();
        $this->listQuery = $this->model->query();

        parent::__construct();
    }

    public function formHook($compact)
    {
        return array_merge($compact, [
            'routes' => RouteDB::whereNotNull('category_name')->orderBy('category_name')->get()->groupBy('category_name'),
        ]);
    }

    public function store(Request $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($request->permissions);

        return redirect()->route('role.index')->with('success', 'Rol başarıyla oluşturuldu.');
    }

    public function update(Request $request, $id = null)
    {
        $role = Role::query()->where('id', $id)->first();

        $role->update([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($request->permissions);

        return redirect()->back()->with('success', 'Rol başarıyla güncellendi.');
    }
}
