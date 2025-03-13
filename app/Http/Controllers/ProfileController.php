<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Favorito;
use Illuminate\Support\Facades\Hash;


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

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');
    }

}
