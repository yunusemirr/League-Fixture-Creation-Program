<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WeekMatch
 *
 * @property int $id
 * @property int|null $season_week_id
 * @property int|null $home_team_id
 * @property int|null $away_team_id
 * @property int|null $home_score
 * @property int|null $away_score
 * @property string|null $status
 * @property string|null $match_datetime
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Team|null $awayTeam
 * @property-read \App\Models\Team|null $homeTeam
 * @property-read \App\Models\SeasonWeek|null $week
 * @method static \Illuminate\Database\Eloquent\Builder|WeekMatch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WeekMatch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WeekMatch query()
 * @method static \Illuminate\Database\Eloquent\Builder|WeekMatch whereAwayScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekMatch whereAwayTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekMatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekMatch whereHomeScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekMatch whereHomeTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekMatch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekMatch whereMatchDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekMatch whereSeasonWeekId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekMatch whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeekMatch whereUpdatedAt($value)
 * @property int|null $week_id
 * @method static \Illuminate\Database\Eloquent\Builder|WeekMatch whereWeekId($value)
 * @mixin \Eloquent
 */
class WeekMatch extends Model
{
    protected $table = 'week_matches';
    protected $fillable = [
        "week_id",
        "home_team_id",
        "away_team_id",
        "home_score",
        "season_id",
        "away_score",
        "status",
        "match_datetime",

    ];
    protected $dates = ['match_datetime'];


    protected $appends = ['winner', 'winner_str'];


    public function week()
    {
        return $this->belongsTo(SeasonWeek::class, 'week_id');
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function getFinalDateAttribute(){
        return Carbon::parse($this->match_datetime)->setTime(20,00);
    }

    public function getWinnerAttribute()
    {

        if ($this->home_score > $this->away_score) {
            return $this->homeTeam;
        } elseif ($this->home_score < $this->away_score) {
            return $this->awayTeam;
        } else {
            return null;
        }
    }

    public function getWinnerStrAttribute()
    {
        if ($this->home_score == -1) {
            return "-";
        }

        if ($this->home_score > $this->away_score) {
            return "home";
        } elseif ($this->home_score < $this->away_score) {
            return "away";
        } else {
            return "draw";
        }
    }
}
