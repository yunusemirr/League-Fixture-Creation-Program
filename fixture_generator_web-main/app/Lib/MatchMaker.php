<?php

namespace App\Lib;

use App\Exceptions\BackendException;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Support\Collection;

class MatchMaker
{

    private $attributes = [];

    /**
     * @var Collection<Team> $_teams
     */
    private Collection $_teams;
    private Collection $_rounds;

    public int $weekInPeriod = 0;


    public function __construct(
        public Season $season
    ) {
        $this->_teams = collect();
        $this
            ->__hydrate()
            ->__generateRounds();
    }



    public function fillSeason()
    {
        $saturday = $this->season->start_date->clone();

        $this->season->weeks()->delete();
        foreach ($this->_rounds as $week_index => $week_matches) {
            $period = $week_index <= $this->_teams->count() ? 1 : 2;

            $week_date = $saturday->clone()->addWeeks($week_index);
            $week = $this->season->weeks()->create([
                'week' => $week_index,
                'week_date' => $week_date,
                'period' => $period
            ]);

            foreach ($week_matches as $match_index => $match) {
                $week->matches()->create([
                    "home_team_id" => $match->home?->id,
                    "away_team_id" => $match->away?->id,
                    "home_score" => -1,
                    "away_score" => -1,
                    "status" => "pending",
                    "match_datetime" => $week_date->clone()->addDays(
                        $match_index < count($week_matches) / 2 ? 0 : 1
                    ),
                    "season_id" => $this->season->id
                ]);
            }
        }

        return true;
    }


    private function __generateRounds(): MatchMaker
    {
        $rounder = new RoundRobber($this->_teams, $this->season->id);
        $this->_rounds = $rounder->rounder();

        return $this;
    }

    private function __hydrate(): MatchMaker
    {
        // first get all teams
        $teams = Team::all();

        $filteredTeams = $teams->where('is_active', 1);

        // if teams count is odd, add bay team
        if ($filteredTeams->count() % 2 != 0) {
            $bayTeam = $teams->where('is_active', 0)->where('name', 'Bay')->first();
            if (!$bayTeam) throw new BackendException('Bay team not found');
            $filteredTeams->push($bayTeam);
        }

        $this->weekInPeriod = $filteredTeams->count() - 1;
        $this->_teams = $filteredTeams;

        return $this;
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public static function init(Season $season)
    {
        return new self($season);
    }
}
