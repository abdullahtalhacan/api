<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Pagination\Paginator;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryParams = $request->all();
        $limit = isset($queryParams['limit']) ? $queryParams['limit'] : 5;
        $currentPage = isset($queryParams['page']) ? $queryParams['page'] : 1;
        $orderBy = isset($queryParams['sortBy']) ? $queryParams['sortBy'] : "id-desc";
        $searchParam = isset($queryParams['search']) ? $queryParams['search'] : null;
        if ($orderBy) {
            $orderBy = explode('-', $orderBy);
        }
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $appointment = Appointment::when($orderBy, function ($query, array $orderBy) {
            if ($orderBy[0] === 'status') {
                $query->join('appointment_statuses', 'appointments.appointment_status_id', '=', 'appointment_statuses.id')
                    ->select('appointments.*', 'appointment_statuses.id as status_id', 'appointment_statuses.name as status_name', 'appointment_statuses.text as status_text', 'appointment_statuses.desc as status_desc')
                    ->orderBy('appointment_statuses.text', $orderBy[1])->with('status');
            } else {
                $query->orderBy($orderBy[0], $orderBy[1])->with('status');
            }
        })->when($searchParam, function ($query, string $searchParam) {
            $query->where('appointments.name', 'like', '%' . $searchParam . '%')
                ->orWhere('appointments.surname', 'like', '%' . $searchParam . '%')
                ->orWhere('appointments.email', 'like', '%' . $searchParam . '%');
        })->paginate($limit);

        return response()->json($appointment);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $entries = Appointment::all();
        $entriesGrouped = [];

        foreach ($entries as $entry) {
            $email = $entry->email;
            if (!isset($entriesGrouped[$email])) {
                $entriesGrouped[$email] = [];
            }
            $entriesGrouped[$email][] = $entry;
        }
        foreach ($entriesGrouped as &$group) {
            usort($group, function ($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });
        }

        //\Log::info($entriesGrouped);

        $appointment = Appointment::with('status')->find($id);
        return response()->json($entriesGrouped);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       try {
        $idArray = preg_split("/[,\.]/", $id);
        if(count($idArray) > 1) {
            Appointment::destroy($idArray);
            return response()->json(true);
        }else {
            $appointment = Appointment::find($idArray[0]);
            if($appointment){
                $appointment->delete();
                return response()->json(true);
            }else {
                return response()->json(false);
            }
        }
       } catch (\Throwable $th) {
        return response()->json(false);
       }
    }
}
