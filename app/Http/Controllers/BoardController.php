<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Board controller
 * 
 * Implements store and update methods.
 * Uses Route Model Binding for automatic model injection.
 */
class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     * 
     * If success, returns 200 with new object as body.
     * If fails, returns errors.
     * 
     * Requires the field 'title', ignores everything else.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:100'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json($validator->messages());

        $board = Board::create(['title' => $request->json('title')]);
        return response()->json($board)->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {
    }

    /**
     * Update the specified resource in storage.
     * 
     * If success, returns 200 with new updated board.
     * If model is not found, return 404. As per Route Model Binding.
     * If fails, return 400 with error messages.
     * 
     * Requires the field 'stage', ignores everything else.
     * 'stage' must be '1', '2', or '3'. Error 400, otherwise.
     * 
     */
    public function update(Request $request, Board $board)
    {
        $rules = [
            'stage' => [
                'required',
                Rule::in(['1', '2', '3']),
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json($validator->messages(), 400);

        $board->stage = $request->json('stage');
        $board->save();

        return response()->json($board, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        //
    }
}
