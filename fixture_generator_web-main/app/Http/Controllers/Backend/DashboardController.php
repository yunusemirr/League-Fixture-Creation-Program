<?php

namespace App\Http\Controllers\Backend;

use App\Models\Chat;
use App\Models\User;
use App\Models\Contact;
use App\Models\Message;
use App\Models\School\Group;
use Illuminate\Http\Request;
use App\Models\School\Lesson;
use App\Models\Season;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends BaseController
{
    use BasePattern;

    public function __construct()
    {

        $this->page = 'panel';
        $this->title = 'Panel';

        parent::__construct();
    }

    public function getIndex(Request $request, Season $selectedSeason = null)
    {
        return redirect()->route('season.index')->with('error', 'Please select a season to view the dashboard.');
        $share = [];

        $share['seasons'] = Season::query()->orderBy("created_at", "desc")->get();
        $share['teams'] = Team::query()->orderBy("name", "asc")->get();

        if ($selectedSeason == null) {
            $selectedSeason = $share['seasons']->first();
        }

        if ($selectedSeason == null) {
            return redirect()->route('season.index');
        }


        if ($request->get('type') == 'fixture') {
            $share['type'] = 'fixture';

            if ($request->get('week', -1) != -1) {
                $share['selectedWeek'] = $selectedSeason->weeks->where('week', $request->get('week'))->first();
            } else {
                $share['selectedWeek'] = $selectedSeason->weeks->first();
            }
        } else {
            $share['type'] = 'standings';
        }


        $selectedSeason->load("weeks", "weeks.matches", "weeks.matches.homeTeam", "weeks.matches.awayTeam");
        $share['selectedSeason'] = $selectedSeason;

        return view('backend.index', $share);
    }
}
