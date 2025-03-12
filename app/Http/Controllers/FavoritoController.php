<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorito;
use App\Models\Gato;

class FavoritoController extends Controller
{
    public function index()
    {
        $favoritos = Favorito::where('user_id', Auth::id())
            ->with('gato')
            ->get();

        return view('favoritos.index', compact('favoritos'));
    }

    public function favoritar($gato_id)
    {
        $user_id = Auth::id();

        $favorito = Favorito::where('user_id', $user_id)
            ->where('gato_id', $gato_id)
            ->first();

        if ($favorito) {
            $favorito->delete();
            $mensagem = 'Gato removido dos favoritos!';
        } else {
            Favorito::create([
                'user_id' => $user_id,
                'gato_id' => $gato_id,
            ]);
            $mensagem = 'Gato adicionado aos favoritos!';
        }

        return back()->with('success', $mensagem);
    }
}