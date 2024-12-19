<?php

namespace App\Helpers;

class ResponseHelper
{

	/**
	 * Generate a standardized response template.
	 *
	 * @param string $message The message to include in the response.
	 * @param bool $isSuccess Indicates if the response is successful. Defaults to true.
	 * @param mixed|null $data The data payload to include in the response. Defaults to null.
	 *
	 * @return array The response template including version, payload, message, and success status.
	 */
	public static function template($message, $isSuccess = true, $data = null, $errors=null)
	{
		return [
			"version" => config('app.version'),
			"payload" => $data,
			"message" => $message,
			"success" => $isSuccess,
			"errors" => $errors
		];
	}
	/**
	 * Send a 200 response with a message.
	 * The message is used as the body of the response.
	 *
	 * @param string|null $message The message to send with the response.
	 * @param mixed|null $data The data to send with the response.
	 * @return \Illuminate\Http\Response
	 */
	public static function success($message, $data = null)
	{
		return response()->json(ResponseHelper::template(
			$message,
			true,
			$data
		), 200);
	}

	/**
	 * Send a 404 response with a message.
	 * The message is used as the body of the response.
	 * The default message is "Api route requested is not available".
	 *
	 * @param string|null $message The message to send with the response.
	 * @return \Illuminate\Http\Response
	 */
	public static function notFound($message = null)
	{
		return response()->json(ResponseHelper::template(
			$message == null ? "Api route requested is not available" : $message,
			false,
		), 404);
	}

	/**
	 * Send a 404 response with a message.
	 * The message is used as the body of the response.
	 * The default message is "Invalid method".
	 *
	 * @param string|null $message The message to send with the response.
	 * @return \Illuminate\Http\Response
	 */
	public static function methodInvalid($message = null)
	{
		return response()->json(ResponseHelper::template(
			$message == null ? "Invalid method" : $message,
			false
		), 404);
	}

	/**
	 * Send a 415 response with a message.
	 * 415 means unsupported media type.
	 *
	 * @param string|null $message The message to send with the response.
	 *                             If null, the default message of "Invalid media type" will be used.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public static function invalidMedia($message = null)
	{
		return response()->json(ResponseHelper::template(
			$message == null ? "Invalid media type" : $message,
			false,
		), 415);
	}

	/**
	 * Send a 422 response with a message and validation errors.
	 * 422 means unprocessable entity.
	 *
	 * @param array $validationErrors The validation errors to send with the response.
	 * @param string|null $message The message to send with the response.
	 *                             If null, the default message of "Invalid request" will be used.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public static function invalid($validationErrors, $message = null)
	{
		return response()->json(ResponseHelper::template(
			$message == null ? "Invalid request" : $message,
			false,
			null,
			$validationErrors	
		), 422);
	}

	public static function serverError($message = null)
	{
		return response()->json(ResponseHelper::template(
			$message == null ? "Error with the database" : $message,
			false,
			null,
			null	
		), 500);
	}

	public static function unauthorized($message = null)
	{
		return response()->json(ResponseHelper::template(
			$message == null ? "Unauthorized" : $message,
			false,
			null,
			null	
		), 401);
	}
}
