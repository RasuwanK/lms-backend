<?php

namespace App\Helpers;

class ResponseHelper 
{
	public static function template($data, $message, $isSuccess = true) 
	{
		return [
			"version" => config('version'),
			"payload" => $data,
			"message" => $message,
			"success" => $isSuccess
		];
	}
	public static function success($data, $message)
	{
		return response()->json(ResponseHelper::template(
			$data,
			$message
		), 200);
	}

	public static function notFound($message = null)
	{
		return response()->json(ResponseHelper::template(
			null,
			$message == null ? "Api route requested is not available" : $message,
			false
		), 404);
	}
}