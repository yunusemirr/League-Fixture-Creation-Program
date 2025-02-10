<?php

namespace App\Http\Controllers\Backend;

use App\Exceptions\BackendException;
use App\Lib\Helpers;
use App\Lib\MatchMaker;
use App\Models\Province;
use App\Models\Season;
use App\Models\SeasonTeamPoint;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\Field;

class SeasonController extends BaseController
{
    use BasePattern;

    public function __construct()
    {
        $this->page = "season";
        $this->title = "Seasons";
        $this->model = new Season();
        $this->listQuery = $this->model->query();

        $this->ajaxFields = collect([
            "start_date" => [
                "type" => Field::TEXT,
                "label_attr" => ["class" => "required form-label"],
                "attr" => [
                    "required" => "required",
                    "hd-component" => "date"
                ]
            ],
            "name" => [
                "type" => Field::TEXT,
                "label_attr" => ["class" => "form-label"],
            ],
            "gap" => [
                "type" => Field::NUMBER,
                "label_attr" => ["class" => "required form-label"],
                "attr" => [
                    "value" => 1,
                    "required"
                ]
            ]
        ]);

        parent::__construct();
    }

    public function seasonFinal(Request $req, Season $season)
    {
        $weights = [
            "0" => 10, // Matches with no goals are common but less than single-goal games
            "1" => 35, // 1-goal matches are quite frequent
            "2" => 30, // 2-goal matches are also very common
            "3" => 15, // 3-goal matches occur often
            "4" => 7,  // 4-goal matches are less frequent
            "5" => 2,  // Matches with 5 goals are rare
            "6" => 0.8, // Matches with 6 goals are very rare
            "7" => 0.4, // Matches with 7 goals are extremely rare
            "8" => 0.2, // Matches with 8 goals are exceedingly rare
            "9" => 0.1, // Matches with 9 goals are almost unheard of
            "10" => 0.05, // Matches with 10 goals are extremely rare
            "11" => 0.01  // Matches with 11 goals are nearly impossible
        ];
        $season->load('weeks', 'weeks.matches', 'weeks.matches.homeTeam', 'weeks.matches.awayTeam');
        foreach ($season->weeks as $week) {
            if($week->period == 2 && $req->get('p', -1) == 1){
                break;
            }
            foreach ($week->matches as $match) {
                if($match->home_team_id == 1 || $match->away_team_id == 1){
                    $match->update([
                        "home_score" => 0,
                        "away_score" => 0,
                        "status" => "completed"
                    ]);
                    continue;
                }
                $match->update([
                    "home_score" => Helpers::getRandomWeightedElement($weights),
                    "away_score" => Helpers::getRandomWeightedElement($weights),
                    "status" => "completed"
                ]);
            }
        }

        return redirect()->back()->with("success", "Season has been finalized successfully");
    }

    public function showSeason(Request $req, Season $season, $path = null)
    {
        $season->load("weeks", "weeks.matches", "weeks.matches.homeTeam", "weeks.matches.awayTeam");
        $compact = [
            "season" => $season
        ];

        $path = $path ?? "index";
        $compact["path"] = $path;


        if($path == "index"){
            $season->load('teamPoints', 'teamPoints.team');
        }


        if($path == "matches"){
            $matches = $season->weeks->map(function($week){
                return $week->matches;
            })->flatten()->sortByDesc("match_datetime");

            $compact["flat_matches"] = $matches;
        }




        return view("backend.season.show", $compact);
    }

    public function storeHook(Request $req)
    {
        $params = [];
        $teamCount = Team::query()->whereIsActive(1)->count();
        $isTeamLeaped = $teamCount % 2 == 0;
        $weekInPeriod = $teamCount - ($isTeamLeaped ? 1 : 0);


        $startDate = Carbon::parse($req->start_date);

        if ($startDate->dayOfWeek != Carbon::SATURDAY) {
            throw new BackendException("Start date must be a Saturday");
        }

        $totalWeeks = ($weekInPeriod * 2) + $req->gap;
        $endDate = $startDate->copy()->addWeeks($totalWeeks)->next(Carbon::SUNDAY);

        $params["start_date"] = $startDate;
        $params["end_date"] = $endDate;
        $params["name"] = $req->name != "" ? $req->name : $startDate->year . " - " . $endDate->year . " Season";
        $params["gap"] = $req->gap;
        return $req->merge($params)->all();
    }



    public function hydrateSeason(Request $req, Season $season)
    {
        $mm = MatchMaker::init($season);
        $mm->fillSeason();
        return redirect()->route("season.show", ['path' =>'fixture', 'season' => $season->id])->with("success", "Season has been assigned successfully");
    }
}
