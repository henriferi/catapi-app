<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorito;

class FavoritoController extends Controller
{
    public function index()
    {
        $favoritos = Favorito::where('user_id', Auth::id())->get();
        return view('favoritos.index', compact('favoritos'));
    }

    public function favoritar($gato_id)
    {
        $user_id = Auth::id();

        $favorito = Favorito::where('user_id', $user_id)
            ->where('gato_id', $gato_id)
            ->first();

        if ($favorito) {
            $favorito->status = $favorito->status == 'ativo' ? 'removido' : 'ativo';
            $favorito->save();
        } else {
            Favorito::create([
                'user_id' => $user_id,
                'gato_id' => $gato_id,
                'status' => 'ativo'
            ]);
        }

        return back()->with('success', 'Favorito atualizado com sucesso!');
    }
}
