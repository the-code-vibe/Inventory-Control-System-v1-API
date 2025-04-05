<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
use Illuminate\Support\Str;

class ProviderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/providers",
     *     summary="Listar todos os fornecedores",
     *     tags={"Fornecedores"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de fornecedores"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Provider::all());
    }

    /**
     * @OA\Get(
     *     path="/providers/{uuid}",
     *     summary="Buscar fornecedor por UUID",
     *     tags={"Fornecedores"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         description="UUID do fornecedor"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fornecedor encontrado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Fornecedor não encontrado"
     *     )
     * )
     */
    public function show($uuid)
    {
        $provider = Provider::where('uuid', $uuid)->firstOrFail();
        return response()->json($provider);
    }

    /**
     * @OA\Post(
     *     path="/providers",
     *     summary="Criar novo fornecedor",
     *     tags={"Fornecedores"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "contact"},
     *             @OA\Property(property="name", type="string", example="Fornecedor XYZ"),
     *             @OA\Property(property="contact", type="string", example="(11) 99999-9999"),
     *             @OA\Property(property="email", type="string", example="contato@xyz.com"),
     *             @OA\Property(property="cnpj", type="string", example="12345678000199")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Fornecedor criado"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->only(['name', 'contact', 'email', 'cnpj']);
        $data['uuid'] = Str::uuid();
        $provider = Provider::create($data);
        return response()->json($provider, 201);
    }

    /**
     * @OA\Put(
     *     path="/providers/{uuid}",
     *     summary="Atualizar fornecedor",
     *     tags={"Fornecedores"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         description="UUID do fornecedor"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Fornecedor Atualizado"),
     *             @OA\Property(property="contact", type="string", example="(11) 98888-8888"),
     *             @OA\Property(property="email", type="string", example="novo@xyz.com"),
     *             @OA\Property(property="cnpj", type="string", example="98765432000111")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fornecedor atualizado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Fornecedor não encontrado"
     *     )
     * )
     */
    public function update(Request $request, $uuid)
    {
        $provider = Provider::where('uuid', $uuid)->firstOrFail();
        $provider->update($request->only(['name', 'contact', 'email', 'cnpj']));
        return response()->json($provider);
    }

    /**
     * @OA\Delete(
     *     path="/providers/{uuid}",
     *     summary="Excluir fornecedor",
     *     tags={"Fornecedores"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         required=true,
     *         description="UUID do fornecedor"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Fornecedor excluído com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Fornecedor não encontrado"
     *     )
     * )
     */
    public function destroy($uuid)
    {
        $provider = Provider::where('uuid', $uuid)->firstOrFail();
        $provider->delete();
        return response()->json(null, 204);
    }
}