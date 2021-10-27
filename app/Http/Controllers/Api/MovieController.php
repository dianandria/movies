<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
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
