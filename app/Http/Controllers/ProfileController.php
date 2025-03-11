<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Favorito;

class ProfileController extends Controller
{
    public function index()
    {
        $favoritos = Favorito::where('user_id', Auth::id())->get();

        $gatosFavoritos = [];
        $apiKey = 'live_evdcKrUApiKAJHQz20afo4lxDdfqCB3tflJmgmMNjF11TQqF99g4XshTUWrYxaUf';

        foreach ($favoritos as $fav) {
            $response = Http::withHeaders([
                'x-api-key' => $apiKey
            ])->get('https://api.thecatapi.com/v1/images/' . $fav->gato_id);

            if ($response->successful()) {
                $gatosFavoritos[] = $response->json();
            }
        }

        return view('profile.profile', compact('gatosFavoritos'));
    }
}
