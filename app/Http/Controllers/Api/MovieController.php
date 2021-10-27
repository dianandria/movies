<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{

	/**
     * @OA\Get(
     *      path="/api/movies?page={page_number}",
     *      operationId="getMoviesList",
     *      tags={"Movies"},
     *      summary="Get list of movies per page",
     *      description="Returns list of movies per page",
     *      @OA\Parameter(
     *          name="page_number",
     *          description="page number",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *     )
     */
    public function index(Request $request)
	{
		$movies = Http::get('https://ghibliapi.herokuapp.com/films')->json();
		
		$collection = collect($movies);
		
		if ($request->page)
		{
			$validator = Validator::make($request->all(),[
	            'page' => 'integer',
	        ]);

	        if($validator->fails()){
	            return response()->json($validator->errors());       
	        }

			$req = $request->page-1;
			$data = ([
				'data' => $collection->slice($req*10,10)->all(),
				'data_per_page' => $collection->slice($req*10,10)->count(),
			]);	
		}
		else{
			$data = $collection->all();
		}
		
		return response()->json($data);
	}
}
