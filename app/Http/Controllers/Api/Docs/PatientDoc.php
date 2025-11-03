<?php

namespace App\Http\Controllers\Api\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Patients",
 *     description="Gestion des patients et de leurs dossiers médicaux"
 * )
 */
class PatientDoc
{
    /**
     * @OA\Get(
     *     path="/api/patients",
     *     summary="Lister les patients",
     *     tags={"Patients"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Terme de recherche",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="gender",
     *         in="query",
     *         description="Filtrer par genre",
     *         required=false,
     *         @OA\Schema(type="string", enum={"male", "female", "other"})
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Nombre d'éléments par page",
     *         required=false,
     *         @OA\Schema(type="integer", default=20)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liste des patients",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Patient")),
     *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
     *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *         )
     *     )
     * )
     */
    public function index() {}

    /**
     * @OA\Get(
     *     path="/api/patients/search",
     *     summary="Rechercher des patients",
     *     tags={"Patients"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Terme de recherche (minimum 2 caractères)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Résultats de la recherche",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Patient")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function search() {}

    /**
     * @OA\Post(
     *     path="/api/patients",
     *     summary="Créer un nouveau patient",
     *     tags={"Patients"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StorePatientRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Patient créé avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function store() {}

    /**
     * @OA\Get(
     *     path="/api/patients/{patient}",
     *     summary="Afficher un patient spécifique",
     *     tags={"Patients"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="patient",
     *         in="path",
     *         required=true,
     *         description="ID du patient",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails du patient",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient non trouvé"
     *     )
     * )
     */
    public function show() {}

    /**
     * @OA\Put(
     *     path="/api/patients/{patient}",
     *     summary="Mettre à jour un patient",
     *     tags={"Patients"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="patient",
     *         in="path",
     *         required=true,
     *         description="ID du patient",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdatePatientRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient mis à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient non trouvé"
     *     )
     * )
     */
    public function update() {}

    /**
     * @OA\Delete(
     *     path="/api/patients/{patient}",
     *     summary="Supprimer un patient",
     *     tags={"Patients"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="patient",
     *         in="path",
     *         required=true,
     *         description="ID du patient à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Patient supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Action non autorisée"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient non trouvé"
     *     )
     * )
     */
    public function destroy() {}

    /**
     * @OA\Get(
     *     path="/api/patients/{patient}/appointments",
     *     summary="Lister les rendez-vous d'un patient",
     *     tags={"Patients"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="patient",
     *         in="path",
     *         required=true,
     *         description="ID du patient",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liste des rendez-vous",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Appointment")),
     *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
     *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *         )
     *     )
     * )
     */
    public function appointments() {}

    // La documentation pour /api/patients/{patient}/medical-records est gérée dans MedicalRecordDoc.php
}
