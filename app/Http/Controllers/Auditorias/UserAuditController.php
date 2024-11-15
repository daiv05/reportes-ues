<?php

namespace App\Http\Controllers\Auditorias;
use OwenIt\Auditing\Models\Audit;
use App\Models\Seguridad\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAuditController extends Controller
{
    /**
     * Mostrar todos los registros de auditoría para el modelo User.
     */
    /**
     * Mostrar todos los registros de auditoría para el modelo User.
     */
    public function index(Request $request)
    {
        $query = Audit::query();

        // Filtrar por modelo auditable (si se especifica)
        if ($request->has('model') && $request->model) {
            $query->where('auditable_type', $request->model);
        }

        // Filtrar por evento (si se especifica)
        if ($request->has('event') && $request->event) {
            $query->where('event', $request->event);
        }

        // Filtrar por usuario (si se especifica)
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filtrar por fecha de creación (si se especifica)
        if ($request->has('start_date') && $request->start_date) {
            $query->where('created_at', '>=', $request->start_date);
        }
        // Realizar la consulta paginada
        $audits = $query->paginate(10);

        // Obtener los tipos de modelos únicos (auditable_type)
        $models = Audit::select('auditable_type')->distinct()->get();

        // Obtener los eventos únicos si hay un modelo seleccionado
        $events = [];
        if ($request->has('model') && $request->model) {
            $events = Audit::select('event')
                ->where('auditable_type', $request->model)
                ->distinct()
                ->get();
        }

          // Obtener los usuarios únicos para el filtro de usuario
          $users = User::all(); // Cargar todos los usuarios, puedes optimizarlo según tus necesidades.

          // Pasar los filtros disponibles y la lista de auditorías a la vista
          return view('audits.index', compact('audits', 'models', 'events', 'users'));
    }

    /**
     * Obtener los eventos según el modelo seleccionado.
     */
    public function getEvents(Request $request)
    {
        if ($request->has('model')) {
            // Obtener los eventos para el modelo seleccionado
            $events = Audit::select('event')
                ->where('auditable_type', $request->model)
                ->distinct()
                ->get();

            return response()->json($events);
        }

        return response()->json([]);
    }
}
