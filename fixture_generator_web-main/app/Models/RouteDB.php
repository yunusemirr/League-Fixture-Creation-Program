<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RouteDB
 *
 * @property int $id
 * @property string|null $category_name
 * @property string|null $name
 * @property string|null $route_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RouteDB newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RouteDB newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RouteDB query()
 * @method static \Illuminate\Database\Eloquent\Builder|RouteDB whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RouteDB whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RouteDB whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RouteDB whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RouteDB whereRouteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RouteDB whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RouteDB extends Model
{
    use HasFactory;

    protected $table = 'routes';

    protected $fillable = [
        'category_name',
        'name',
        'route_name'
    ];
}
