<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $arr_plan = Plan::orderBy('created_at','desc')->get()->toArray();

            return response()->json([
                'success' => true,
                'message' => 'success get all plan list. total row: ' . count($arr_plan),
                'data' => $arr_plan,
            ], 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage(), 400);

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanRequest $request)
    {
        try {

            $new_plan = new Plan;

            $new_plan->user_id = 0;
            $new_plan->title = $request->title;
            $new_plan->origin = $request->origin;
            $new_plan->destination = $request->destination;
            $new_plan->type = $request->type;
            $new_plan->start_date = $request->start_date;
            $new_plan->end_date = $request->end_date;
            $new_plan->description = $request->description;
            $new_plan->created_at = date('Y-m-d');
            $new_plan->save();

            return response()->json([
                'success' => true,
                'message' => 'Store plan successfuly',
            ], 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage(), 400);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $plan_detail = Plan::find($id)->toArray();

            return response()->json([
                'success' => true,
                'message' => 'success get plan detail',
                'data' => $plan_detail,
            ], 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage(), 400);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
