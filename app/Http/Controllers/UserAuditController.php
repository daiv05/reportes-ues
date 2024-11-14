<?php

namespace App\Http\Controllers;
use OwenIt\Auditing\Models\Audit;

use Illuminate\Http\Request;

class UserAuditController extends Controller
{
    /**
     * Mostrar todos los registros de auditoría para el modelo User.
     */
    public function index(Request $request)
{
    $query = Audit::query();

    if ($request->has('model') && $request->model) {
        $query->where('auditable_type', $request->model);
    }

    if ($request->has('event') && $request->event) {
        $query->where('event', $request->event);
    }

    $audits = $query->paginate(10);

    return view('audits.index', compact('audits'));
}
}
