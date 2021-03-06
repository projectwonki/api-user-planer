<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            // dd(Cache::get('user_plan_list'));

            if (Cache::has('user_plan_list')){

                return Cache::get('user_plan_list');

            }

            $arr_plan = Plan::whereUserId(auth('api')->user()->id)->orderBy('created_at','desc')->get()->toArray();

            $response = response()->json([
                'success' => true,
                'message' => 'success get all plan list. total row: ' . count($arr_plan),
                'data' => $arr_plan,
            ], 200);

            Cache::put('user_plan_list', $response);

            return $response;

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

            $check_duplicate = Plan::where('user_id', auth('api')->user()->id)
                                    ->where('title', $request->title)
                                    ->where('origin', $request->origin)
                                    ->where('destination', $request->destination)
                                    ->where('type', $request->type)
                                    ->where('start_date', $request->start_date)
                                    ->where('end_date', $request->end_date)->exists();

            if ($check_duplicate) {

                return response()->json([
                    'success' => false,
                    'message' => 'input data can not be same with the existing. please make a new one',
                ], 422);

            }

            $new_plan = new Plan;

            $new_plan->user_id = auth('api')->user()->id;
            $new_plan->title = $request->title;
            $new_plan->origin = $request->origin;
            $new_plan->destination = $request->destination;
            $new_plan->type = $request->type;
            $new_plan->start_date = $request->start_date;
            $new_plan->end_date = $request->end_date;
            $new_plan->description = $request->description;
            $new_plan->created_at = date('Y-m-d');
            $new_plan->save();

            Cache::forget('user_plan_list');

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

            $plan_detail = Plan::whereId($id)->whereUserId(auth('api')->user()->id)->first();

            if ($plan_detail === null) {
                return response()->json([
                    'success' => true,
                    'message' => 'plan detail not found',
                    'data' => array(),
                ], 200);
            }

            Cache::forget('user_plan_list');

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
    public function update(PlanRequest $request, $id)
    {
        try {

            $check_duplicate = Plan::where('user_id', auth('api')->user()->id)
                                    ->where('title', $request->title)
                                    ->where('origin', $request->origin)
                                    ->where('destination', $request->destination)
                                    ->where('type', $request->type)
                                    ->where('start_date', $request->start_date)
                                    ->where('end_date', $request->end_date)->exists();

            if ($check_duplicate) {

                return response()->json([
                    'success' => false,
                    'message' => 'update data can not be same with the existing. please update with new data',
                ], 422);

            }

            $update_plan = Plan::whereId($id)->whereUserId(auth('api')->user()->id)->first();

            if ($update_plan === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Plan is not found',
                ], 400);
            }

            $update_plan->user_id = auth('api')->user()->id;
            $update_plan->title = $request->title;
            $update_plan->origin = $request->origin;
            $update_plan->destination = $request->destination;
            $update_plan->type = $request->type;
            $update_plan->start_date = $request->start_date;
            $update_plan->end_date = $request->end_date;
            $update_plan->description = $request->description;
            $update_plan->updated_at = date('Y-m-d');
            $update_plan->save();

            Cache::forget('user_plan_list');

            return response()->json([
                'success' => true,
                'message' => 'Update plan successfuly',
            ], 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage(), 400);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $get_plan = Plan::whereId($id)->whereUserId(auth('api')->user()->id)->first();
            
            if ($get_plan === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Plan is not found',
                ], 400);
            }

            $get_plan->delete();

            Cache::forget('user_plan_list');

            return response()->json([
                'success' => true,
                'message' => 'Delete plan successfuly',
            ], 200);

        } catch (\Exception $e) {

            return response()->json($e->getMessage(), 400);

        }
    }
}
