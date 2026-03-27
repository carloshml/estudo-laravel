<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;

class PessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        // Busca todas as pessoas no banco
        $pessoas = Pessoa::all();

        // Retorna como JSON
        return response()->json($pessoas);
    }

    public function index()
    {
        // Busca todas as pessoas no banco
        $pessoas = Pessoa::all();

        // Retorna a view 'pessoas' passando os dados
        return view('pessoas', compact('pessoas'));
    }

    public function getById($id)
    {
        $pessoa = Pessoa::find($id);

        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa não encontrada'], 404);
        }

        return response()->json($pessoa);
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
        $pessoa = Pessoa::find($id);

        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa não encontrada'], 404);
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'idade' => 'required|integer',
            'documento' => "required|string|unique:pessoas,documento,$id",
            'foto' => 'nullable|string',
        ]);

        $path = $pessoa->foto;
        if ($request->foto) {
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->foto));
            $filename = uniqid() . '.png';
            Storage::disk('public')->put("fotos/$filename", $image);
            $path = "fotos/$filename";
        }

        $pessoa->update([
            'nome' => $request->nome,
            'idade' => $request->idade,
            'documento' => $request->documento,
            'foto' => $path,
        ]);

        return response()->json($pessoa);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
