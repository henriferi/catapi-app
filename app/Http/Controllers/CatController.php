<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class CatController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = 'live_evdcKrUApiKAJHQz20afo4lxDdfqCB3tflJmgmMNjF11TQqF99g4XshTUWrYxaUf';
    }

    public function index()
    {
        $catsResponse = Http::withHeaders([
            'x-api-key' => $this->apiKey
        ])->get('https://api.thecatapi.com/v1/images/search', [
            'limit' => 50
        ]);
    
        if (!$catsResponse->successful()) {
            return view('cats.index')->with('error', 'Erro ao carregar gatos aleatórios.');
        }
    
        return view('cats.index', [
            'cats' => $catsResponse->json(),
            'searchedRace' => 'Gatos Aleatórios'
        ]);
    }
    

    public function search(Request $request)
    {
        $raceName = $request->query('race');

        if (!$raceName) {
            $catsResponse = Http::withHeaders([
                'x-api-key' => $this->apiKey
            ])->get('https://api.thecatapi.com/v1/images/search', [
                'limit' => 50
            ]);

            if (!$catsResponse->successful()) {
                return redirect()->route('cats.index')->with('error', 'Erro ao buscar gatos aleatórios.');
            }

            return view('cats.index', [
                'cats' => $catsResponse->json(),
                'searchedRace' => 'Gatos Aleatórios'
            ]);
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

        return view('cats.index', [
            'cats' => $catsResponse->json(),
            'searchedRace' => $raceName
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
