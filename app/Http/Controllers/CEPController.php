<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CEP;
use Illuminate\Database\QueryException;

class CEPController extends Controller
{
    
    public function __construct(CEP $ceps)
    {
        $this->ceps = $ceps;
    }

    public function index()
    {
        $ceps = $this->ceps->get();
    
        return response()->json($ceps, 200); 
    }

    public function store(Request $request)
    {
        $newCEP = $request->all();

        try {

            CEP::create($newCEP);
            return response()->json($newCEP, 201);

        } catch (QueryException $exception) {

            return response()->json(['message' => 'Ocorreu um erro ao cadastrar essa distância.', 'date' => now(), 'error' => $exception], 404);

        }
        
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {

            $newData = $request->all();

            $updated = CEP::find($id);
            $updated->update($newData);
            return response()->json($updated, 200);

        } catch (QueryException $exception) {

            return response()->json(['message' => 'Ocorreu um erro ao atualizar essa distância.', 'date' => now(), 'error' => $exception], 404);

        }
    }

    public function destroy($id)
    {
        try {

            $deleted = CEP::find($id);
            $deleted->delete();
            return response()->json($deleted, 200);

        } catch (QueryException $exception) {

            return response()->json(['message' => 'Ocorreu um erro ao deletar essa distância.', 'date' => now(), 'error' => $exception], 404);

        }
    }
}
