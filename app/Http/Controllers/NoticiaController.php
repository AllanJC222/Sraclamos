<?php
// Archivo: app/Http/Controllers/NoticiaController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia; // <--- 1. Importamos el Modelo

class NoticiaController extends Controller
{
    /**
     * Muestra la lista de noticias (Listar).
     */
    public function index()
    {
        // 2. Pedimos los datos al Modelo
        $noticias = Noticia::orderBy('created_at', 'desc')->get();

        // 3. Pasamos los datos a la Vista
        return view('noticias.leers', compact('noticias'));
    }

    /**
     * Muestra el formulario para crear una nueva noticia (Crear).
     */
    public function create()
    {
        // 3. Solo mostramos la Vista del formulario
        return view('noticias.crear');
    }

    /**
     * Guarda la nueva noticia en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validamos los datos que vienen del formulario (Vista)
        $request->validate([
            'Titulo' => 'required|string|max:255',
            'Contenido' => 'required|string',
        ]);

        // 2. Usamos el Modelo para crear el registro en la BD
        Noticia::create([
            'Titulo' => $request->Titulo,
            'Contenido' => $request->Contenido,
            'Publicado' => $request->has('Publicado') ? true : false
        ]);

        // 3. Redirigimos al usuario de vuelta a la lista (Vista)
        return redirect()->route('noticias.leers')
                         ->with('success', 'Noticia creada exitosamente.');
    }

    public function edit($id)
    {
        // 1. Buscamos la noticia por su ID.
        // findOrFail() es útil: si no la encuentra, muestra un error 404
        $noticia = Noticia::findOrFail($id);

        // 2. Pasamos la noticia encontrada a la nueva vista 'editar'
        return view('noticias.editar', compact('noticia'));
    }

    /**
     * ACTUALIZA la noticia en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // 1. Validamos los datos (igual que en store)
        $request->validate([
            'Titulo' => 'required|string|max:255',
            'Contenido' => 'required|string',
        ]);

        // 2. Buscamos la noticia que vamos a actualizar
        $noticia = Noticia::findOrFail($id);

        // 3. Usamos el Modelo para actualizarla en la BD
        $noticia->update([
            'Titulo' => $request->Titulo,
            'Contenido' => $request->Contenido,
            'Publicado' => $request->has('Publicado') ? true : false
        ]);

        // 4. Redirigimos de vuelta a la lista con un mensaje
        return redirect()->route('noticias.leers')
                         ->with('success', 'Noticia actualizada exitosamente.');
    }

    /**
     * ELIMINA una noticia de la base de datos.
     */
    public function destroy($id)
    {
        // 1. Buscamos la noticia
        $noticia = Noticia::findOrFail($id);

        // 2. Usamos el Modelo para eliminarla
        $noticia->delete();

        // 3. Redirigimos de vuelta a la lista con un mensaje
        return redirect()->route('noticias.leers')
                         ->with('success', 'Noticia eliminada exitosamente.');
    }
}