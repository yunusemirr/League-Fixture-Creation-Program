<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Season
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $gap
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Season newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Season newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Season query()
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereGap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SeasonWeek> $weeks
 * @property-read int|null $weeks_count
 * @mixin \Eloquent
 */
class Season extends Model
{
    protected $table = 'seasons';
    protected $fillable = ['name', 'gap', 'start_date', 'end_date'];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function weeks(){
        return $this->hasMany(SeasonWeek::class, 'season_id');
    }

    public function teamPoints(){
        return $this->hasMany(SeasonTeamPoint::class, 'season_id');
    }
}
