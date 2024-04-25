<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
     */
    public function store(Request $request)
    {
        $rules = ['title' => 'required|max:100'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json($validator->messages());

        $board = Board::create($request->all());
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
