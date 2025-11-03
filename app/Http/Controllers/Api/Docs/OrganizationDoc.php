<?php

namespace App\Http\Controllers\Api\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Organisations",
 *     description="Gestion des organisations et des changements de contexte"
 * )
 */
class OrganizationDoc
{
    /**
     * @OA\Get(
     *     path="/api/organizations",
     *     summary="Lister les organisations de l'utilisateur",
     *     tags={"Organisations"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des organisations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Organization")
     *         )
     *     )
     * )
     */
    public function index() {}

    /**
     * @OA\Get(
     *     path="/api/organizations/current",
     *     summary="Obtenir l'organisation courante",
     *     tags={"Organisations"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Organisation courante",
     *         @OA\JsonContent(ref="#/components/schemas/Organization")
     *     )
     * )
     */
    public function current() {}

    /**
     * @OA\Get(
     *     path="/api/organizations/{organization}",
     *     summary="Afficher une organisation spécifique",
     *     tags={"Organisations"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         required=true,
     *         description="ID de l'organisation",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails de l'organisation",
     *         @OA\JsonContent(ref="#/components/schemas/Organization")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Accès refusé à cette organisation"
     *     )
     * )
     */
    public function show() {}

    /**
     * @OA\Post(
     *     path="/api/organizations/switch/{organization}",
     *     summary="Changer d'organisation courante",
     *     tags={"Organisations"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         required=true,
     *         description="ID de l'organisation vers laquelle basculer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Changement d'organisation réussi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="organization", ref="#/components/schemas/Organization")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Accès refusé à cette organisation"
     *     )
     * )
     */
    public function switch() {}

    /**
     * @OA\Post(
     *     path="/api/organizations",
     *     summary="Créer une nouvelle organisation",
     *     tags={"Organisations"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreOrganizationRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Organisation créée avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Organization")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Droits insuffisants pour créer une organisation"
     *     )
     * )
     */
    public function store() {}

    /**
     * @OA\Put(
     *     path="/api/organizations/{organization}",
     *     summary="Mettre à jour une organisation",
     *     tags={"Organisations"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         required=true,
     *         description="ID de l'organisation",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateOrganizationRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Organisation mise à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Organization")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Droits insuffisants pour modifier cette organisation"
     *     )
     * )
     */
    public function update() {}

    /**
     * @OA\Delete(
     *     path="/api/organizations/{organization}",
     *     summary="Supprimer une organisation",
     *     tags={"Organisations"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         required=true,
     *         description="ID de l'organisation à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Organisation supprimée avec succès"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Droits insuffisants pour supprimer cette organisation"
     *     )
     * )
     */
    public function destroy() {}
}
