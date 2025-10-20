<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Clase base para todos los controladores del sistema.
 *
 * Este controlador actúa como clase principal que heredan todos los demás
 * controladores del proyecto. Proporciona acceso a los traits nativos de Laravel:
 *
 * - **AuthorizesRequests**: Permite manejar la autorización de acciones del usuario
 *   mediante políticas y gates.
 * - **ValidatesRequests**: Facilita la validación de datos de formularios e inputs
 *   antes de procesar las solicitudes HTTP.
 *
 * Al extender esta clase, cada controlador del sistema obtiene automáticamente
 * estas funcionalidades estándar sin necesidad de volver a implementarlas.
 *
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
