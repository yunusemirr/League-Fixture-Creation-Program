<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SeasonWeek
 *
 * @property int $id
 * @property int|null $season_id
 * @property int|null $week
 * @property string|null $period
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WeekMatch> $matches
 * @property-read int|null $matches_count
 * @property-read \App\Models\Season|null $season
 * @method static \Illuminate\Database\Eloquent\Builder|SeasonWeek newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeasonWeek newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeasonWeek query()
 * @method static \Illuminate\Database\Eloquent\Builder|SeasonWeek whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeasonWeek whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeasonWeek wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeasonWeek whereSeasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeasonWeek whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeasonWeek whereWeek($value)
 * @mixin \Eloquent
 */
class SeasonWeek extends Model
{
    protected $table = 'season_weeks';
    protected $fillable = ['season_id', 'week', 'period', 'week_date'];
    protected $casts = [
        'week_date' => 'date'
    ];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function matches(){
        return $this->hasMany(WeekMatch::class, 'week_id');
    }

    public function getDateAttribute(){
        $clone = $this->season->start_date->clone();
        return $clone->addWeeks($this->week);
    }
}
