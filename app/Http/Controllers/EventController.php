<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function getAllEvents($userid): \Illuminate\Http\JsonResponse
    {
        $events = Event::where('userid', $userid)->get();
        return response()->json($events);
    }

    public function getEventInfo($userid, $eventid): \Illuminate\Http\JsonResponse
    {
        $event = Event::where('userid', $userid)->where('id', $eventid)->firstOrFail();
        return response()->json($event);
    }
    public function createEvent(Request $request,$userid,$eventid): \Illuminate\Http\JsonResponse
    {
        $event = new Event();
        $event->userid = $userid;
        $event->id = $eventid;
        $event->fill($request->all());
        $event->save();
        return response()->json(['message' => 'Event created']);
    }
    public function updateEvent(Request $request, $userid,$eventid): \Illuminate\Http\JsonResponse
    {
        $event = Event::where('userid', $userid)->where('id', $eventid)->firstOrFail();
        $event->update($request->all());
        return response()->json(['message' => 'Event updated']);
    }
    public function deleteEvent(Request $request, $userid,$eventid): \Illuminate\Http\JsonResponse
    {
        $event = Event::where('userid', $userid)->where('id', $eventid)->firstOrFail();
        $event->delete();
        return response()->json(['message' => 'Event deleted']);
    }
}
