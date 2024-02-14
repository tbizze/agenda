<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function test(Request $request)
    {
        $eventos = Evento::all();
        dd($eventos->toArray());
    }
}
