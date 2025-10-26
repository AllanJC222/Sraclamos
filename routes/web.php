<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\categreclamoController;
use App\Http\Controllers\sectorController;
use App\Http\Controllers\abonadoController;
use App\Http\Controllers\rolController;
use App\Http\Controllers\usuarioController;
use App\Http\Controllers\opdistribucionController;
use App\Http\Controllers\barrioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\registrarseController;
use App\Http\Controllers\ReclamoController;
use App\Http\Controllers\usuariologController;


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Archivo de rutas web del sistema
|--------------------------------------------------------------------------
| Este archivo define todas las rutas del sistema, incluyendo:
| - Rutas públicas (login, reclamos externos)
| - Rutas autenticadas (panel interno)
| - Rutas con control de acceso por tipo de usuario (Administrador / Operador)
|
| Cada grupo está claramente segmentado para mejorar el mantenimiento y
| la seguridad del sistema de reclamos.
|
| Middleware clave:
| - auth:usuariolog → protege rutas internas.
| - check.user.type:x → restringe acceso según tipo de usuario.
|--------------------------------------------------------------------------
*/
/*  ============================================================
    RUTAS PÚBLICAS (Login / Logout / Reclamos Externos)
    ============================================================ */

Route::get('/', function () {
    return view('welcome');
});

/**
 * Autenticación del sistema
 * Controlador: App\Http\Controllers\Auth\LoginController
 */

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/**
 * Rutas de reclamos públicos (usuarios no autenticados)
 * Controlador: App\Http\Controllers\ReclamoController
 */
Route::prefix('reclamos/publico')->group(function () {
    Route::get('/crear', [ReclamoController::class, 'publicCreate'])->name('reclamos.publico.crear');
    Route::post('/store', [ReclamoController::class, 'publicStore'])->name('reclamos.publico.store');
    Route::get('/gracias/{codigo}', [ReclamoController::class, 'gracias'])->name('reclamos.publico.gracias');
    Route::get('/consulta', [ReclamoController::class, 'consulta'])->name('reclamos.publico.consulta');
    Route::get('/consultar', [ReclamoController::class, 'consultar'])->name('reclamos.publico.consultar');
});

/*
|--------------------------------------------------------------------------
| Rutas de Usuarios Autenticados (Ambos Tipos)
|--------------------------------------------------------------------------
| Todas las rutas aquí están protegidas por el guard 'usuariolog'.
*/

Route::middleware('auth:usuariolog')->group(function () {

    // RUTA COMPARTIDA: Dashboard. Todos los usuarios logueados pueden acceder aquí.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rutas para la gestión de abonados (CRUD Completo)
    Route::get('/abonados/crear', [abonadoController::class, 'crear'])->name('abonados.crear');
    Route::post('/abonados/store', [abonadoController::class, 'store'])->name('abonados.store');
    Route::get('/abonados/leer', [abonadoController::class, 'leer'])->name('abonados.leer');
    Route::get('/abonados/actualizar/{IdAbonado}', [abonadoController::class, 'edit'])->name('abonados.edit');
    Route::put('/abonados/actualizar/{IdAbonado}', [abonadoController::class, 'update'])->name('abonados.update');
    Route::post('/abonados/toggle-estado/{IdAbonado}', [abonadoController::class, 'toggleEstado'])->name('abonados.toggleEstado');





    // Rutas para sector (CRUD Completo)
    Route::get('/sectores/crear', [sectorController::class, 'crear'])->name('sectores.crear');
    Route::post('/sectores/store', [sectorController::class, 'store'])->name('sectores.store');
    Route::get('/sectores/leer', [sectorController::class, 'leer'])->name('sectores.leer');
    Route::get('/sectores/actualizar/{IdSector}', [sectorController::class, 'edit'])->name('sectores.edit');
    Route::put('/sectores/actualizar/{IdSector}', [sectorController::class, 'update'])->name('sectores.update');
    Route::delete('/sectores/eliminar/{IdSector}', [sectorController::class, 'destroy'])->name('sectores.destroy');

    // Rutas para la gestión de usuarios operadores (CRUD Completo)
    // Rutas para la gestión de usuarios (CRUD Completo)
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/crear', [usuarioController::class, 'crear'])->name('crear');
        Route::post('/store', [usuarioController::class, 'store'])->name('store');
        Route::get('/leer', [usuarioController::class, 'leer'])->name('leer');
        Route::get('/edit/{idUsuario}', [usuarioController::class, 'edit'])->name('edit');
        Route::put('/update/{idUsuario}', [usuarioController::class, 'update'])->name('update');
        // ✅ Corregida: sin repetir "usuarios"
        Route::post('/{idUsuario}/toggle', [usuarioController::class, 'toggleEstado'])->name('toggleEstado');
    });




    // Rutas para Reclamos siguiendo convenciones de Laravel/REST:
    // Nota: Se ha cambiado el nombre del método 'crear' a 'create' y 'leer' a 'index'.

    Route::get('/reclamos', [ReclamoController::class, 'index'])->name('reclamos.leer');
    Route::get('/reclamos/crear', [ReclamoController::class, 'create'])->name('reclamos.crear');
    Route::post('/reclamos', [ReclamoController::class, 'store'])->name('reclamos.store');
    // Editar / Actualizar / Eliminar
    Route::get('/reclamos/{id}/editar', [ReclamoController::class, 'edit'])->name('reclamos.edit');
    Route::put('/reclamos/{id}', [ReclamoController::class, 'update'])->name('reclamos.update');
    Route::delete('/reclamos/{id}', [ReclamoController::class, 'destroy'])->name('reclamos.destroy');
    Route::get('/reclamos/exportar-excel', [ReclamoController::class, 'exportExcel'])->name('reclamos.exportExcel');



    Route::get('/reclamos/{id}', [ReclamoController::class, 'show'])->name('reclamos.show');
    Route::get('/reclamos/{id}/pdf', [ReclamoController::class, 'exportPDF'])
        ->name('reclamos.pdf');
        //------------------------------------------------------------------------------------------------------
        //se agrego esta ruta para subir pdf, se se llamada al metodo de este mismo
    Route::post('/reclamos/{id}/subir-pdf', [ReclamoController::class, 'uploadPdfFinal'])
        ->name('reclamos.uploadPdfFinal');
    Route::get('reclamos/{id}/descargar-final', [ReclamoController::class, 'downloadPdfFinal'])->name('reclamos.downloadPdfFinal');



    // AJAX: listar barrios por sector
    Route::get('/barrios/por-sector', [BarrioController::class, 'porSector'])
        ->name('barrios.porSector');

    // Endpoint de prueba de JSON (opcional para diagnosticar)
    Route::get('/ping-json', fn() => response()->json(['pong' => true], 200))
        ->name('ping.json');


    // Rutas para la gestión de categorías de reclamo (CRUD Completo)
    Route::get('/categoria/crear', [categreclamoController::class, 'crear'])->name('categoria.crear');
    Route::post('/categoria/store', [categreclamoController::class, 'store'])->name('categoria.store');
    Route::get('/categoria/leer', [categreclamoController::class, 'leer'])->name('categoria.leer');
    Route::get('/categoria/actualizar/{IdCategoria}', [categreclamoController::class, 'edit'])->name('categoria.edit');
    Route::put('/categoria/actualizar/{IdCategoria}', [categreclamoController::class, 'update'])->name('categoria.update');
    Route::delete('/categoria/eliminar/{IdCategoria}', [categreclamoController::class, 'destroy'])->name('categoria.destroy');
    // Rutas para barrio (CRUD Completo)
    Route::get('/barrios/crear', [barrioController::class, 'crear'])->name('barrios.crear');
    Route::post('/barrios/store', [barrioController::class, 'store'])->name('barrios.store');
    Route::get('/barrios/leer', [barrioController::class, 'leer'])->name('barrios.leer');
    Route::get('/barrios/actualizar/{IdBarrio}', [barrioController::class, 'edit'])->name('barrios.edit');
    Route::put('/barrios/actualizar/{IdBarrio}', [barrioController::class, 'update'])->name('barrios.update');
    Route::delete('/barrios/eliminar/{IdBarrio}', [barrioController::class, 'destroy'])->name('barrios.destroy');

    /*
    |--------------------------------------------------------------------------
    | Rutas Específicas del ADMINISTRADOR (user_tipo:1) - CRUD Completo
    |--------------------------------------------------------------------------
    */
    Route::middleware('check.user.type:1')->group(function () {

        // CRUD de usuarios del login
        Route::prefix('usuariolog')->name('usuariolog.')->group(function () {
            Route::get('/leer', [usuariologController::class, 'leer'])->name('leer');
            Route::get('/edit/{id}', [usuariologController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [usuariologController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [usuariologController::class, 'destroy'])->name('destroy');

        });



        // Rutas para la gestión de roles (CRUD Completo)
        Route::get('/roles/crear', [rolController::class, 'crear'])->name('roles.crear');
        Route::post('/roles/crear', [rolController::class, 'store'])->name('roles.store');
        Route::get('/roles/leer', [rolController::class, 'leer'])->name('roles.leer');
        Route::get('/roles/{IdRol}/editar', [rolController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{IdRol}', [rolController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{IdRol}', [rolController::class, 'destroy'])->name('roles.destroy');

        // Rutas de registro (Gestión de logins)
        Route::get('/registro/registrarse', [registrarseController::class, 'registrarse'])->name('registrarse.crearlogs');
        Route::post('/registro/registrar', [registrarseController::class, 'registrar'])->name('registrar.storelogs');

        // Rutas de Distribución de Operadores (CRUD Completo)
        Route::prefix('distribucion')->group(function () {
            Route::get('/', [opdistribucionController::class, 'index'])->name('distribucion.index');
            Route::get('/crear', [opdistribucionController::class, 'crear'])->name('distribucion.crear');
            Route::post('/store', [opdistribucionController::class, 'store'])->name('distribucion.store');
            Route::get('/editar/{id}', [opdistribucionController::class, 'edit'])->name('distribucion.edit');
            Route::put('/update/{id}', [opdistribucionController::class, 'update'])->name('distribucion.update');
            Route::post('/toggleEstado/{id}', [opdistribucionController::class, 'toggleEstado'])->name('distribucion.toggleEstado');
            Route::get('/leer/{id}', [opdistribucionController::class, 'show'])->name('distribucion.leer');
        });




    }); // Fin del grupo de administrador


    Route::middleware(['auth', 'check.user.type:1,2,3,4'])->group(function () {

        // Ruta para MOSTRAR LA LISTA (GET /noticias)
        // Llama al método 'index' del 'NoticiaController'
        Route::get('/noticias', [App\Http\Controllers\NoticiaController::class, 'index'])
            ->name('noticias.leers');

        // Ruta para MOSTRAR EL FORMULARIO DE CREAR (GET /noticias/crear)
        // Llama al método 'create'
        Route::get('/noticias/crear', [App\Http\Controllers\NoticiaController::class, 'create'])
            ->name('noticias.crear');

        // Ruta para GUARDAR LA NUEVA NOTICIA (POST /noticias)
        // Llama al método 'store'
        Route::post('/noticias', [App\Http\Controllers\NoticiaController::class, 'store'])
            ->name('noticias.store');

        // 1. Ruta para MOSTRAR el formulario de edición
        // {id} es un parámetro que se pasará al método 'edit'
        Route::get('/noticias/{id}/editar', [App\Http\Controllers\NoticiaController::class, 'edit'])
            ->name('noticias.edit');

        // 2. Ruta para PROCESAR la actualización (PUT)
        Route::put('/noticias/{id}', [App\Http\Controllers\NoticiaController::class, 'update'])
            ->name('noticias.update');

        // 3. Ruta para ELIMINAR el registro (DELETE)
        Route::delete('/noticias/{id}', [App\Http\Controllers\NoticiaController::class, 'destroy'])
            ->name('noticias.destroy');

        // Aquí irían las rutas para editar, actualizar y eliminar
        // Ej: Route::get('/noticias/{id}/editar', ...)
        // Ej: Route::put('/noticias/{id}', ...)
        // Ej: Route::delete('/noticias/{id}', ...)
    });


    /*
    |--------------------------------------------------------------------------
    | Rutas Específicas de USUARIO REGULAR/OPERADOR (user_tipo:2) - Acceso Limitado
    |--------------------------------------------------------------------------
    */
    Route::middleware('check.user.type:2')->group(function () {




        // Aquí irían las rutas específicas del operador para Reclamos (crear, listar sus reclamos, etc.)

    }); // Fin del grupo de usuario regular

}); // Fin del grupo de usuarios autenticados
