<?php

namespace App\Lib;

use Illuminate\Support\Collection;
use stdClass;

class RoundRobber
{
    private Collection $round_collection;

    private int $rounds = 0;
    private int $teams_count = 0;


    public function __construct(
        public Collection $teams,
        public ?int $seed = null
    ) {
        $this->teams = collect($teams->shuffle($this->seed));
        $this->round_collection = collect();
        $this->teams_count = $this->teams->count(); // total team count
        $this->rounds = $this->teams_count * 2; // total rounds (2 period)
    }

    public function rounder()
    {
        $teamsCount = $this->teams_count;
        $halfTeamCount = $teamsCount / 2;
        $rounds = $this->rounds;
        for ($round = 1; $round <= $rounds; $round += 1) {
            $this->round_collection[$round] = collect();
            foreach ($this->teams as $index => $team) {
                if ($index >= $halfTeamCount) {
                    continue;
                }

                $home = $team;
                $away = $this->teams[$index + $halfTeamCount];
                $match = new stdClass();
                if ($round % 2 === 0) {
                    $match->home = $away;
                    $match->away = $home;
                } else {
                    $match->home = $home;
                    $match->away = $away;
                }
                $this->round_collection[$round]->push($match);
            }
            $this->rotateForRoundRobin();
        }

        return $this->round_collection;
    }

    private function rotateForRoundRobin()
    {
        $teams = collect($this->teams);
        $teams_count = $teams->count();
        if ($teams_count < 3) {
            return $this;
        }
        $latest_index = $teams_count - 1;
        $factor = (int) ($teams_count % 2 === 0 ? $teams_count / 2 : ($teams_count / 2) + 1);
        $top_r_index = $factor - 1;
        $top_r_item = $teams[$top_r_index];
        $bot_l_index = $factor;
        $bor_l_item = $teams[$bot_l_index];
        for ($i = $top_r_index; $i > 0; $i -= 1) {
            $teams[$i] = $teams[$i - 1];
        }
        for ($i = $bot_l_index; $i < $latest_index; $i += 1) {
            $teams[$i] = $teams[$i + 1];
        }
        $teams[1] = $bor_l_item;
        $teams[$latest_index] = $top_r_item;
        $this->teams = $teams;
        return $this;
    }
}
