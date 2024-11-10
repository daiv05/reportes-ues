<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mantenimientos\Ciclo;
use App\Models\General\TipoCiclo;
use App\Http\Requests\CicloRequest;
use App\Mail\EnvioMailable;
use Illuminate\Support\Facades\Mail;

class CicloController extends Controller
{
    public function pruebaCorreo()
    {
        $vistaCorreo = 'emails.contactanos';  // Por defecto, usa 'contactanos'
        // Enviar el correo con la vista dinámica
        Mail::to('dc19019@ues.edu.sv')->send(new EnvioMailable($vistaCorreo));
    }
    public function index()
    {
        $vistaCorreo = 'emails.contactanos';  // Por defecto, usa 'contactanos'
        // Enviar el correo con la vista dinámica
        Mail::to('dc19019@ues.edu.sv')->send(new EnvioMailable($vistaCorreo));
        // Obtener los ciclos con su tipo de ciclo relacionado
        $ciclos = Ciclo::with('tipoCiclo')->paginate(10); // Usa paginación para mostrar la lista
        $tiposCiclos = TipoCiclo::all(); // Para el selector de tipos de ciclos en el modal


        return view('mantenimientos.ciclos.index', compact('ciclos', 'tiposCiclos'));
    }

    public function store(CicloRequest $request)
    {

        // Muestra la data que llega en la solicitud
        // dd($request->all());
        // Verifica si se debe activar este ciclo y desactiva otros si es necesario
        if ($request->activo) {
            Ciclo::where('activo', true)->update(['activo' => false]);
        }

        $ciclo = Ciclo::create($request->validated());

        return redirect()->route('ciclos.index')
            ->with('message', [
                'type' => 'success',
                'content' => 'Ciclo creado exitosamente'
            ]);
    }

    public function update(CicloRequest $request, $id)
    {
        $ciclo = Ciclo::findOrFail($id);

        // Si el ciclo a actualizar es activado, desactiva otros ciclos
        if ($request->activo) {
            Ciclo::where('activo', true)->where('id', '<>', $id)->update(['activo' => false]);
        }

        $ciclo->update($request->validated());

        return redirect()->route('ciclos.index')
            ->with('message', [
                'type' => 'success',
                'content' => 'Ciclo actualizado exitosamente'
            ]);
    }
}
