<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = [];

        $appointments = Appointment::with(['client', 'employee'])->get();

        foreach ($appointments as $appointment) {
            if (!$appointment->start_time) {
                continue;
            }

            $events[] = [
                'title' => $appointment->client->name . ' ('.$appointment->employee->name.')',
                'start' => $appointment->start_time,
                'url'   => route('admin.appointments.edit', $appointment->id),
            ];
        }

        return view('admin.calendar.calendar', compact('events'));
    }

}
