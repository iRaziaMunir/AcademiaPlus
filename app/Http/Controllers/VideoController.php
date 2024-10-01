<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoRequest;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    // Store a video recording
    public function store(VideoRequest $request)
    {
        $video = Video::create($request->all());

        return response()->json(['message' => 'Video uploaded successfully', 'video' => $video]);
    }

    // Get videos for a quiz attempt
    public function index($attemptId)
    {
        // Fetch videos associated with the given attemptId
        $videos = Video::where('quiz_attempt_id', $attemptId)->get();

        // If videos are found, return them
        if ($videos->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'videos' => $videos
            ], 200);
        }

        // If no videos found for the attemptId, return a not found response
        return response()->json([
            'success' => false,
            'message' => 'No videos found for this attempt.'
        ], 404);
    }
}
