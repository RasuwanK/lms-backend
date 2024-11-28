<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function getAllEvents($userid): \Illuminate\Http\JsonResponse
    {
        $events = Event::where('userid', $userid)->get();

        if ($events->isEmpty()) {
            return ResponseHelper::notFound('No events found for this user');
        }
        return ResponseHelper::success('Events fetched successfully', $events);
    }

    public function getEventInfo($userid, $eventid): \Illuminate\Http\JsonResponse
    {
        $event = Event::where('userid', $userid)->where('id', $eventid)->first();

        if (!$event) {
            return ResponseHelper::notFound('Event not found');
        }
        return ResponseHelper::success('Event details fetched successfully', $event);
    }

    public function createEvent(Request $request, $userid, $eventid): \Illuminate\Http\JsonResponse
    {
        $event = new Event();
        $event->userid = $userid;
        $event->id = $eventid;
        $event->fill($request->all());
        $event->save();
        return ResponseHelper::success('Event created successfully', $event);
    }

    public function updateEvent(Request $request, $userid, $eventid): \Illuminate\Http\JsonResponse
    {
        $event = Event::where('userid', $userid)->where('id', $eventid)->first();

        if (!$event) {
            return ResponseHelper::notFound('Event not found');
        }

        $event->update($request->all());
        return ResponseHelper::success('Event updated successfully', $event);
    }

    public function deleteEvent(Request $request, $userid, $eventid): \Illuminate\Http\JsonResponse
    {
        $event = Event::where('userid', $userid)->where('id', $eventid)->first();

        if (!$event) {
            return ResponseHelper::notFound('Event not found');
        }

        $event->delete();
        return ResponseHelper::success('Event deleted successfully');
    }
}
