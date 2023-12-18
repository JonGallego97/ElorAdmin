<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cycle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class CycleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $cycles = Cycle::orderBy('id')->get();
            if(!is_null($cycles)) {
                return response()->json(['cycles'=>$cycles])->setStatusCode(Response::HTTP_OK);
            } else {
                return response()->json(['cycles'=>$cycles])->setStatusCode(Response::HTTP_NO_CONTENT);
            }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cycle = new Cycle();
        $cycle->name = $request['name'];

        $created = $cycle->save();
        if($created) {
            return response()->json(['cycle'=>$cycle])->setStatusCode(Response::HTTP_CREATED);
        } else {
            return response()->json(['cycle'=>$cycle])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $cycle = new Cycle();
        $cycle = Cycle::where('id', $id)->first();
        if (optional($cycle)->id !== null) {
            return response()->json(['cycle' => $cycle])
                ->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Cycle not found'])
                ->setStatusCode(Response::HTTP_NO_CONTENT);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cycle $cycle)
    {
        $cycle->name = $request['name'];
        $cycle->updated_at = now();
        $cycle->department_id = $request['department_id'];

        $updated = $cycle->save();
        if($updated) {
            return response()->json(['cycle'=>$cycle])->setStatusCode(Response::HTTP_CREATED);
        } else {
            return response()->json(['cycle'=>$cycle])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cycle $cycle)
    {
        $deleted = $cycle->delete();
        if ($deleted) {
            return response()->json(['cycle'=>$cycle])->setStatusCode(Response::HTTP_NO_CONTENT);
        } else {
            return response()->json(['cycle'=>$cycle])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }
}
