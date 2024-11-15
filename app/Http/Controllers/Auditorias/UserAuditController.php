<?php

namespace App\Http\Controllers\Auditorias;
use OwenIt\Auditing\Models\Audit;
use App\Models\Seguridad\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAuditController extends Controller
{
       public function index(Request $request)
    {
        $query = Audit::query();

        if ($request->has('model') && $request->model) {
            $query->where('auditable_type', $request->model);
        }

        if ($request->has('event') && $request->event) {
            $query->where('event', $request->event);
        }

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('start_date') && $request->has('end_date') && $request->start_date && $request->end_date) {
            $query->whereRaw('DATE(created_at) BETWEEN ? AND ?', [$request->start_date, $request->end_date]);
        }

        $audits = $query->paginate(2);

        $models = Audit::select('auditable_type')->distinct()->get();

        $events = [];
        if ($request->has('model') && $request->model) {
            $events = Audit::select('event')
                ->where('auditable_type', $request->model)
                ->distinct()
                ->get();
        }

        $users = User::all();

        return view('audits.index', compact('audits', 'models', 'events', 'users'));
    }

   
    public function getEvents(Request $request)
    {
        if ($request->has('model')) {
            $events = Audit::select('event')
                ->where('auditable_type', $request->model)
                ->distinct()
                ->get();

            return response()->json($events);
        }

        return response()->json([]);
    }
}
