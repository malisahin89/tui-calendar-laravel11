<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\User;
use Illuminate\Http\Request;

class TuicalendarController extends Controller
{
    public function index()
    {
        $datas = Events::all();
        $users = User::select(['id','name','color'])->get();
        return view('tui-event-create', compact(['datas','users']));
    }

    public function store(Request $request)
    {
        $event = Events::create([
            'title' => $request->title,
            'calendar_id' => $request->calendarId,
            'content' => $request->location,
            'is_allday' => $request->isAllday,
            'is_private' => $request->isPrivate,
            'state' => $request->state,
            'start' => $request->input('start.d.d'),
            'end' => $request->input('end.d.d'),
            'event_id' => $request->event_id,
            'attendees' => $request->attendees,
            'category' => $request->category,
        ]);

        if ($event) {
            return response()->json(['success' => true, 'message' => 'Etkinlik Başarıyla Kaydedildi'], 201);
        }
        return response()->json(['success' => false, 'message' => 'Etkinlik Kayıt Edilemedi!'], 404);
    }

    public function update(Request $request)
    {
        $event = Events::findOrFail($request->id);

        $validatedData = [
            'title' => $request->title,
            'calendar_id' => $request->calendarId,
            'content' => $request->location,
            'is_allday' => $request->isAllday,
            'is_private' => $request->isPrivate,
            'state' => $request->state,
            'start' => $request->input('start.d.d'),
            'end' => $request->input('end.d.d'),
            'event_id' => $request->event_id,
            'attendees' => $request->attendees,
            'category' => $request->category,
        ];
        $event->update($validatedData);

        if ($event) {
            return response()->json(['success' => true, 'message' => 'Etkinlik Başarıyla Güncellendi'], 200);
        }
        return response()->json(['success' => false, 'message' => 'Etkinlik Güncellenemedi!'], 404);
    }

    public function destroy(Request $request)
    {
        $jsonData = $request->json()->all();
        $id = $jsonData['id']['id'];

        $event = Events::findOrFail($id);
        $event->delete();
        if ($event) {
            return response()->json(['success' => true, 'message' => 'Etkinlik Başarıyla Silindi'], 204);
        }
        return response()->json(['success' => false, 'message' => 'Etkinlik Silinemedi!'], 404);
    }
}
