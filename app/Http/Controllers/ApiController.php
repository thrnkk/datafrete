<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
	
	public function checkCEP($cep)
	{

		$opts = [
			"http" => [
				"header" => ["Authorization: Token token=b01454465b805d1283d1f9323c3972c6", 
							 "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"]
			]
		];

		$context = stream_context_create($opts);

		$file = file_get_contents('https://www.cepaberto.com/api/v3/cep?cep=' . $cep, false, $context);

		$result  = json_decode($file);

		return response()->json($result, 200); 
	}

	public function calculateDistance(Request $request)
	{

		$lat_orig = $request->input('lat_orig');
		$lon_orig = $request->input('lon_orig');

		$lat_dest = $request->input('lat_dest');
		$lon_dest = $request->input('lon_dest');

		$radius = 6371;

		$diffLatitude = $this->degreesToRadians($lat_dest - $lat_orig);
		$diffLongitude = $this->degreesToRadians($lon_dest - $lon_orig);

		$a = sin($diffLatitude / 2) * sin($diffLatitude / 2) + cos($this->degreesToRadians($lat_orig)) * cos($this->degreesToRadians($lat_dest)) * sin($diffLongitude / 2) * sin($diffLongitude / 2);

		$angle = 2 * atan2(sqrt($a), sqrt(1-$a));

		$distance = $radius * $angle;

		return response()->json(round($distance, 2), 200); 

	}

	private function degreesToRadians($degree) 
	{
		return $degree * (pi() / 180);
	}
}
