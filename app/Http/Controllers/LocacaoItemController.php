<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LocacaoItem;

class LocacaoItemController extends Controller
{
    public function list()
    {
        $locacoes = LocacaoItem::with(['item', 'cliente'])->orderBy('inicio', 'desc')->get();
        return response()->json($locacoes);
    }

    public function getById($id)
    {
        $locacao = LocacaoItem::with(['item', 'cliente'])->find($id);

        if (!$locacao) {
            return response()->json(['message' => 'Locação não encontrada'], 404);
        }

        return response()->json($locacao);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id'    => 'required|exists:items,id',
            'cliente_id' => 'required|exists:clientes,id',
            'location'   => 'required|string|max:255',
            'inicio'     => 'required|date',
            'fim'        => 'required|date|after:inicio',
            'status'     => 'nullable|in:ativo,finalizado,cancelado',
        ]);

        $locacao = LocacaoItem::create([
            'item_id'    => $request->item_id,
            'cliente_id' => $request->cliente_id,
            'location'   => $request->location,
            'inicio'     => $request->inicio,
            'fim'        => $request->fim,
            'status'     => $request->status ?? 'ativo',
        ]);

        return response()->json($locacao->load(['item', 'cliente']), 201);
    }

    public function update(Request $request, string $id)
    {
        $locacao = LocacaoItem::find($id);

        if (!$locacao) {
            return response()->json(['message' => 'Locação não encontrada'], 404);
        }

        $request->validate([
            'item_id'    => 'required|exists:items,id',
            'cliente_id' => 'required|exists:clientes,id',
            'location'   => 'required|string|max:255',
            'inicio'     => 'required|date',
            'fim'        => 'required|date|after:inicio',
            'status'     => 'nullable|in:ativo,finalizado,cancelado',
        ]);

        $locacao->update([
            'item_id'    => $request->item_id,
            'cliente_id' => $request->cliente_id,
            'location'   => $request->location,
            'inicio'     => $request->inicio,
            'fim'        => $request->fim,
            'status'     => $request->status ?? $locacao->status,
        ]);

        return response()->json($locacao->load(['item', 'cliente']));
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
        return response()->json($locacao->load(['item', 'cliente']));
    }
}
