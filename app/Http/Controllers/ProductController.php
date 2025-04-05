<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/products",
     *     summary="Listar todos os produtos",
     *     tags={"Produtos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de produtos"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Product::all());
    }

    /**
     * @OA\Get(
     *     path="/products/{uuid}",
     *     summary="Buscar produto por UUID",
     *     tags={"Produtos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         description="UUID do produto"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto encontrado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado"
     *     )
     * )
     */
    public function show($uuid)
    {
        $product = Product::where('uuid', $uuid)->firstOrFail();
        return response()->json($product);
    }

    /**
     * @OA\Post(
     *     path="/products",
     *     summary="Criar novo produto",
     *     tags={"Produtos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_provider","id_category","price","title","quantity","unit_type"},
     *             @OA\Property(property="id_provider", type="integer"),
     *             @OA\Property(property="id_category", type="integer"),
     *             @OA\Property(property="price", type="number", format="float"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="quantity", type="integer"),
     *             @OA\Property(property="unit_type", type="string", enum={"kg","g","T","unit","L","ml"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produto criado"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'id_provider',
            'id_category',
            'price',
            'title',
            'description',
            'quantity',
            'unit_type'
        ]);

        $data['uuid'] = Str::uuid();
        $product = Product::create($data);
        return response()->json($product, 201);
    }

    /**
     * @OA\Put(
     *     path="/products/{uuid}",
     *     summary="Atualizar produto",
     *     tags={"Produtos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         description="UUID do produto"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id_provider", type="integer"),
     *             @OA\Property(property="id_category", type="integer"),
     *             @OA\Property(property="price", type="number", format="float"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="quantity", type="integer"),
     *             @OA\Property(property="unit_type", type="string", enum={"kg","g","T","unit","L","ml"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto atualizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado"
     *     )
     * )
     */
    public function update(Request $request, $uuid)
    {
        $product = Product::where('uuid', $uuid)->firstOrFail();
        $product->update($request->only([
            'id_provider',
            'id_category',
            'price',
            'title',
            'description',
            'quantity',
            'unit_type'
        ]));

        return response()->json($product);
    }

    /**
     * @OA\Delete(
     *     path="/products/{uuid}",
     *     summary="Excluir produto",
     *     tags={"Produtos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         description="UUID do produto"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Produto excluído com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado"
     *     )
     * )
     */
    public function destroy($uuid)
    {
        $product = Product::where('uuid', $uuid)->firstOrFail();
        $product->delete();
        return response()->json(null, 204);
    }
}
