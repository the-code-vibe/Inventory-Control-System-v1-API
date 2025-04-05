<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/categories",
     *     summary="Listar todas as categorias",
     *     tags={"Categorias"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de categorias"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Category::all());
    }

    /**
     * @OA\Get(
     *     path="/categories/{uuid}",
     *     summary="Buscar categoria por UUID",
     *     tags={"Categorias"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         description="UUID da categoria"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria encontrada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoria não encontrada"
     *     )
     * )
     */
    public function show($uuid)
    {
        $category = Category::where('uuid', $uuid)->firstOrFail();
        return response()->json($category);
    }

    /**
     * @OA\Post(
     *     path="/categories",
     *     summary="Criar nova categoria",
     *     tags={"Categorias"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             @OA\Property(property="title", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoria criada"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->only(['title']);
        $data['uuid'] = Str::uuid();
        $category = Category::create($data);
        return response()->json($category, 201);
    }

    /**
     * @OA\Put(
     *     path="/categories/{uuid}",
     *     summary="Atualizar categoria",
     *     tags={"Categorias"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         description="UUID da categoria"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria atualizada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoria não encontrada"
     *     )
     * )
     */
    public function update(Request $request, $uuid)
    {
        $category = Category::where('uuid', $uuid)->firstOrFail();
        $category->update($request->only(['title']));
        return response()->json($category);
    }

    /**
     * @OA\Delete(
     *     path="/categories/{uuid}",
     *     summary="Excluir categoria",
     *     tags={"Categorias"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         description="UUID da categoria"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Categoria excluída com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoria não encontrada"
     *     )
     * )
     */
    public function destroy($uuid)
    {
        $category = Category::where('uuid', $uuid)->firstOrFail();
        $category->delete();
        return response()->json(null, 204);
    }
}
