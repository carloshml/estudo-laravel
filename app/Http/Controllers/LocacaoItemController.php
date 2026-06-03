<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LocacaoItem;

class LocacaoItemController extends Controller
{
    public function list()
    {
        $locacoes = LocacaoItem::with(['item', 'pessoa'])->orderBy('inicio', 'desc')->get();
        return response()->json($locacoes);
    }

    public function getById($id)
    {
        $locacao = LocacaoItem::with(['item', 'pessoa'])->find($id);

        if (!$locacao) {
            return response()->json(['message' => 'Locação não encontrada'], 404);
        }

        return response()->json($locacao);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id'   => 'required|exists:items,id',
            'pessoa_id' => 'required|exists:pessoas,id',
            'location'  => 'required|string|max:255',
            'inicio'    => 'required|date',
            'fim'       => 'required|date|after:inicio',
            'status'    => 'nullable|in:ativo,finalizado,cancelado',
        ]);

        $locacao = LocacaoItem::create([
            'item_id'   => $request->item_id,
            'pessoa_id' => $request->pessoa_id,
            'location'  => $request->location,
            'inicio'    => $request->inicio,
            'fim'       => $request->fim,
            'status'    => $request->status ?? 'ativo',
        ]);

        return response()->json($locacao->load(['item', 'pessoa']), 201);
    }

    public function update(Request $request, string $id)
    {
        $locacao = LocacaoItem::find($id);

        if (!$locacao) {
            return response()->json(['message' => 'Locação não encontrada'], 404);
        }

        $request->validate([
            'item_id'   => 'required|exists:items,id',
            'pessoa_id' => 'required|exists:pessoas,id',
            'location'  => 'required|string|max:255',
            'inicio'    => 'required|date',
            'fim'       => 'required|date|after:inicio',
            'status'    => 'nullable|in:ativo,finalizado,cancelado',
        ]);

        $locacao->update([
            'item_id'   => $request->item_id,
            'pessoa_id' => $request->pessoa_id,
            'location'  => $request->location,
            'inicio'    => $request->inicio,
            'fim'       => $request->fim,
            'status'    => $request->status ?? $locacao->status,
        ]);

        return response()->json($locacao->load(['item', 'pessoa']));
    }

    public function destroy(string $id)
    {
        $locacao = LocacaoItem::find($id);

        if (!$locacao) {
            return response()->json(['message' => 'Locação não encontrada'], 404);
        }

        $locacao->delete();
        return response()->json(['message' => 'Locação excluída com sucesso']);
    }

    public function updateStatus(Request $request, string $id)
    {
        $locacao = LocacaoItem::find($id);

        if (!$locacao) {
            return response()->json(['message' => 'Locação não encontrada'], 404);
        }

        $request->validate([
            'status' => 'required|in:ativo,finalizado,cancelado',
        ]);

        $locacao->update(['status' => $request->status]);
        return response()->json($locacao->load(['item', 'pessoa']));
    }
}
