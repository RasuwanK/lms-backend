<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\PortalUser;
use App\Models\Module;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    // Fetch results for a specific user, along with their associated modules
    public function getUserResults($userId)
    {
        // Fetch results for the user and eager load the module details
        $results = Result::with('module') // Eager load the module information
            ->where('user_id', $userId)
            ->get();

        return response()->json($results); // Return results in JSON format
    }

    // Quick insert results for testing
    public function addResults(Request $request)
    {
        // Example hardcoded data to insert results
        $results = [
            ['user_id' => 11, 'module_id' => 1, 'result' => 'A+'],
            ['user_id' => 12, 'module_id' => 2, 'result' => 'B'],
            ['user_id' => 13, 'module_id' => 3, 'result' => 'C+'],
        ];

        // Insert hardcoded results into the database
        foreach ($results as $result) {
            Result::create($result);
        }

        return response()->json(['message' => 'Results added successfully'], 201);
    }
}
