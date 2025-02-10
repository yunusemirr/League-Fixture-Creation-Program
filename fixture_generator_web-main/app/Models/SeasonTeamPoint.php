<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeasonTeamPoint extends Model
{
    protected $table = 'season_team_points_view';

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id');
    }
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
