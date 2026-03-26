<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;

class PessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Busca todas as pessoas no banco
        $pessoas = Pessoa::all();

        // Retorna como JSON
        return response()->json($pessoas);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'idade' => 'required|integer',
            'documento' => 'required|string|unique:pessoas',
            'foto' => 'nullable|string', // base64 string
        ]);

        $path = null;
        if ($request->foto) {
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->foto));
            $filename = uniqid() . '.png';
            Storage::disk('public')->put("fotos/$filename", $image);
            $path = "fotos/$filename";
        }

        return Pessoa::create([
            'nome' => $request->nome,
            'idade' => $request->idade,
            'documento' => $request->documento,
            'foto' => $path,
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
