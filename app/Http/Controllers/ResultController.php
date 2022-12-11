<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $results = Result::all();
        $positions = Result::all()->unique('position');

//        return response()->json([
//            'results' => $results,
//            'positions' => $positions,
//        ],200);
    }

    public function getResult()
    {
        return Result::all();
    }

    public function getPosition()
    {
        Return Result::selectRaw('position_id, position')->distinct()->get();
    }

    static function generate(Request $request)
    {
        Result::truncate();

        $poll_id = $request->input('poll_id');

        $agg_results = DB::connection('mysql')
            ->table('votes')
            ->selectRaw('`votes`.`nominee_id`,`votes`.`position_id`,`nominees`.`name` as `nominee`,`positions`.`name` as `position`,  COUNT(*) AS `vote_count`')
            ->join('nominees', 'votes.nominee_id', '=', 'nominees.id')
            ->join('positions', 'votes.position_id', '=', 'positions.id')
            ->where('votes.poll_id', $poll_id)
            ->groupByRaw('`votes`.`position_id`, `votes`.`nominee_id`,`nominees`.`name`,`positions`.`name`')
            ->orderByRaw('`votes`.`position_id` asc, `vote_count` desc')
            ->get();

        foreach ($agg_results as $record) {
            try {
                Result::create([
                    'nominee_id' => $record->nominee_id,
                    'position_id' => $record->position_id,
                    'nominee' => $record->nominee,
                    'position' => $record->position,
                    'vote_count' => $record->vote_count,

                ]);
            } catch (\Exception $e)
            {
                return response()->json([ 'error'=>$e->getMessage()]);
            }
        }

        return response()->json([
            'status' => 'ok',
        ], 200);
    }
}
