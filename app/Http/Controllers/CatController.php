<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorito;

class CatController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = 'live_evdcKrUApiKAJHQz20afo4lxDdfqCB3tflJmgmMNjF11TQqF99g4XshTUWrYxaUf';
    }

    public function index(Request $request)
    {
        $limit = 50;
        $offset = $request->input('offset', 0);

        $catsResponse = Http::withHeaders([
            'x-api-key' => $this->apiKey
        ])->get('https://api.thecatapi.com/v1/images/search', [
            'limit' => $limit,
            'page' => $offset / $limit + 1
        ]);

        if (!$catsResponse->successful()) {
            return view('cats.index')->with('error', 'Erro ao carregar gatos aleatórios.');
        }

        $favoritos = Auth::check()
            ? Favorito::where('user_id', Auth::id())->pluck('gato_id')->toArray()
            : [];

        return view('cats.index', [
            'cats' => $catsResponse->json(),
            'searchedRace' => 'Gatos Aleatórios',
            'favoritos' => $favoritos
        ]);
    }


    public function search(Request $request)
    {
        $raceName = $request->query('race');

        if (!$raceName) {
            return redirect()->route('cats.index', ['refresh' => time()]);
        }

        $breedsResponse = Http::withHeaders([
            'x-api-key' => $this->apiKey
        ])->get('https://api.thecatapi.com/v1/breeds');

        if (!$breedsResponse->successful()) {
            return redirect()->route('cats.index')->with('error', 'Erro ao buscar raças.');
        }

        $breeds = $breedsResponse->json();
        $breedId = null;

        foreach ($breeds as $breed) {
            if (strcasecmp($breed['name'], $raceName) === 0) {
                $breedId = $breed['id'];
                break;
            }
        }

        if (!$breedId) {
            return redirect()->route('cats.index')->with('error', 'Raça não encontrada.');
        }

        $catsResponse = Http::withHeaders([
            'x-api-key' => $this->apiKey
        ])->get('https://api.thecatapi.com/v1/images/search', [
            'breed_ids' => $breedId,
            'limit' => 10
        ]);

        if (!$catsResponse->successful()) {
            return redirect()->route('cats.index')->with('error', 'Erro ao buscar gatos.');
        }

        $favoritos = Auth::check()
            ? Favorito::where('user_id', Auth::id())->pluck('gato_id')->toArray()
            : [];

        return view('cats.index', [
            'cats' => $catsResponse->json(),
            'searchedRace' => $raceName,
            'favoritos' => $favoritos
        ]);
    }


    public function getBreeds(Request $request)
    {
        $breedsResponse = Http::withHeaders([
            'x-api-key' => $this->apiKey
        ])->get('https://api.thecatapi.com/v1/breeds');

        if (!$breedsResponse->successful()) {
            return response()->json([]);
        }

        $breeds = $breedsResponse->json();
        $searchTerm = strtolower($request->query('term'));

        $filteredBreeds = array_filter($breeds, function ($breed) use ($searchTerm) {
            return strpos(strtolower($breed['name']), $searchTerm) !== false;
        });

        return response()->json(array_values(array_map(fn($breed) => $breed['name'], $filteredBreeds)));
    }
}
