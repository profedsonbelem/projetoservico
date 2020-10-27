<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    protected $clientes;

    public function __construct(Cliente $cliente)
    {
        $this->clientes = $cliente;
    }

    public function findAll()
    {
        $lista = Cliente::all();
        return response()->json($lista, 200);
    }

    public function findById($id)
    {

        $cliente = Cliente::find($id);
        if ($cliente) {
            return response()->json(["findid-result" => $cliente], 200);
        } else {
            return response()->json(["findid-result" => "nao encontrado..." . $id], 400);
        }
    }

    public function delete($id)
    {
        $cliente = Cliente::find($id);
        if ($cliente) {
            $cliente->delete();
            return response()->json(["delete-cliente" => "Dados Apagados do Cliente"], 200);
        } else {
            return response()->json(["delete-cliente" => "nao encontrado..." . $id], 400);
        }
    }

    public function create(Request $req)
    {
        try {
            $cliente = new Cliente($req->all());
            $cliente->save();
            return response()->json(["create-cliente" => "dados gravados"], 200);
        } catch (\Exception $ex) {
            return response()->json(["create-cliente" =>
                "nao foi possivel gravar os dados" . $ex->getMessage()], 500);
        }

    }

    public function update(Request $request, $id)
    {
        try {
            $cliente = Cliente::findOrFail($id);

            $cliente->fill($request->all());
            $cliente->save();
            return response()->json(["update-cliente" => "dados alterados"], 200);
        } catch (\Exception $ex) {
            return response()->json(["update-cliente" =>
                "nao foi possivel gravar os dados" . $ex->getMessage()], 500);
        }
    }
}
