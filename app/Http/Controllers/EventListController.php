<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EventListController extends Controller
{
    public function index()
    {
        $nowDate = Carbon::now();
        $nowMont = $nowDate->format('Y-m') . '%';

        $users = Events::with('user')
            ->select(['id', 'calendar_id', 'title', 'content', 'start', 'end'])
            ->where(DB::raw("DATE_FORMAT(start, '%Y-%m')"), 'LIKE', $nowMont)
            ->get();
        return view('tui-events-list', compact(['users']));
    }
    public function search(Request $request)
    {
        $date = $request->date;
        $parts = explode('/', $date);
        $month = $parts[0];
        $year = $parts[1];

        $users = Events::with('user')
            ->select(['id', 'calendar_id', 'title', 'content', 'start', 'end'])
            ->where(DB::raw("DATE_FORMAT(start, '%Y-%m')"), 'LIKE', $year . '-' . $month . '%')
            ->get();
        return view('tui-events-list', compact(['users', 'date']));
    }


    public function topdf(Request $request)
    {
        $date=$request->date;
        $parts = explode('/', $date);
        $month = $parts[0];
        $year = $parts[1];

        $users = Events::with('user')
        ->select([ 'id', 'calendar_id', 'title', 'content', 'start', 'end' ])
        ->where(DB::raw("DATE_FORMAT(start, '%Y-%m')"), 'LIKE', $year.'-'.$month.'%')
        ->get();

        $data=[
            'date' => $date,
            'users' => $users
        ];

        $pdf = Pdf::loadView('tui-events-PDF', $data);
        return $pdf->download($month.'-'.$year.'-etkinlikler.pdf');

    }

}
