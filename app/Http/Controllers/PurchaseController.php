<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    /**
     * @OA\Get(
     *     path="/purchases",
     *     summary="Listar todas as compras",
     *     tags={"Compras"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de compras"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Purchase::all());
    }

    /**
     * @OA\Get(
     *     path="/purchases/{uuid}",
     *     summary="Buscar compra por UUID",
     *     tags={"Compras"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         description="UUID da compra"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Compra encontrada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Compra não encontrada"
     *     )
     * )
     */
    public function show($uuid)
    {
        $purchase = Purchase::where('uuid', $uuid)->first();

        if (!$purchase) {
            return response()->json(['message' => 'Compra não encontrada.'], 404);
        }

        return response()->json($purchase);
    }

    /**
     * @OA\Post(
     *     path="/purchases",
     *     summary="Criar nova compra",
     *     tags={"Compras"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_products", "id_providers", "quantity", "price", "purcharse_date"},
     *             @OA\Property(property="id_products", type="integer", description="ID do produto"),
     *             @OA\Property(property="id_providers", type="integer", description="ID do fornecedor"),
     *             @OA\Property(property="quantity", type="integer", description="Quantidade comprada"),
     *             @OA\Property(property="price", type="number", format="float", description="Preço unitário"),
     *             @OA\Property(property="purcharse_date", type="string", format="date-time", description="Data da compra")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Compra criada"
     *     )
     * )
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_products' => 'required|exists:products,id',
            'id_providers' => 'required|exists:providers,id',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'purcharse_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = $request->all();
        $data['uuid'] = Str::uuid();

        $purchase = Purchase::create($data);
        return response()->json($purchase, 201);
    }

    /**
     * @OA\Put(
     *     path="/purchases/{uuid}",
     *     summary="Atualizar compra",
     *     tags={"Compras"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         description="UUID da compra"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id_products", type="integer", description="ID do produto"),
     *             @OA\Property(property="id_providers", type="integer", description="ID do fornecedor"),
     *             @OA\Property(property="quantity", type="integer", description="Quantidade comprada"),
     *             @OA\Property(property="price", type="number", format="float", description="Preço unitário"),
     *             @OA\Property(property="purcharse_date", type="string", format="date-time", description="Data da compra")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Compra atualizada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Compra não encontrada"
     *     )
     * )
     */
    public function update(Request $request, $uuid)
    {
        $purchase = Purchase::where('uuid', $uuid)->first();

        if (!$purchase) {
            return response()->json(['message' => 'Compra não encontrada.'], 404);
        }

        $data = $request->validate([
            'id_products' => 'sometimes|required|exists:products,id',
            'id_providers' => 'sometimes|required|exists:providers,id',
            'quantity' => 'sometimes|required|integer',
            'price' => 'sometimes|required|numeric',
            'purcharse_date' => 'sometimes|required|date',
        ]);

        $purchase->update($data);

        return response()->json($purchase);
    }

    /**
     * @OA\Delete(
     *     path="/purchases/{uuid}",
     *     summary="Excluir compra",
     *     tags={"Compras"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         description="UUID da compra"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Compra excluída com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Compra não encontrada"
     *     )
     * )
     */
    public function destroy($uuid)
    {
        $purchase = Purchase::where('uuid', $uuid)->first();

        if (!$purchase) {
            return response()->json(['message' => 'Compra não encontrada.'], 404);
        }

        $purchase->delete();

        return response()->json(null, 204);
    }
}