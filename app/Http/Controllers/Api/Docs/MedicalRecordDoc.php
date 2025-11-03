<?php

namespace App\Http\Controllers\Api\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Dossiers Médicaux",
 *     description="Gestion des dossiers médicaux des patients"
 * )
 */
class MedicalRecordDoc
{
    /**
     * @OA\Post(
     *     path="/api/medical-records",
     *     summary="Créer un nouveau dossier médical",
     *     tags={"Dossiers Médicaux"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreMedicalRecordRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Dossier médical créé avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/MedicalRecord")
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
     *     path="/api/medical-records/{medicalRecord}",
     *     summary="Afficher un dossier médical spécifique",
     *     tags={"Dossiers Médicaux"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="medicalRecord",
     *         in="path",
     *         required=true,
     *         description="ID du dossier médical",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dossier médical récupéré avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/MedicalRecord")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Dossier médical non trouvé"
     *     )
     * )
     */
    public function show() {}

    /**
     * @OA\Put(
     *     path="/api/medical-records/{medicalRecord}",
     *     summary="Mettre à jour un dossier médical",
     *     tags={"Dossiers Médicaux"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="medicalRecord",
     *         in="path",
     *         required=true,
     *         description="ID du dossier médical",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateMedicalRecordRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dossier médical mis à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/MedicalRecord")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Action non autorisée"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Dossier médical non trouvé"
     *     )
     * )
     */
    public function update() {}

    /**
     * @OA\Delete(
     *     path="/api/medical-records/{medicalRecord}",
     *     summary="Supprimer un dossier médical",
     *     tags={"Dossiers Médicaux"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="medicalRecord",
     *         in="path",
     *         required=true,
     *         description="ID du dossier médical",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Dossier médical supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Action non autorisée"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Dossier médical non trouvé"
     *     )
     * )
     */
    public function destroy() {}

    /**
     * @OA\Get(
     *     path="/api/patients/{patient}/medical-records",
     *     summary="Lister les dossiers médicaux d'un patient",
     *     tags={"Dossiers Médicaux"},
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
     *         description="Liste des dossiers médicaux",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/MedicalRecord")),
     *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
     *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *         )
     *     )
     * )
     */
    public function byPatient() {}

    /**
     * @OA\Get(
     *     path="/api/medical-records/follow-ups",
     *     summary="Lister les suivis à venir et en retard",
     *     tags={"Dossiers Médicaux"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des suivis",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="upcoming",
     *                 type="object",
     *                 @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/MedicalRecord")),
     *                 @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
     *                 @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *             ),
     *             @OA\Property(
     *                 property="overdue",
     *                 type="object",
     *                 @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/MedicalRecord")),
     *                 @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
     *                 @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *             )
     *         )
     *     )
     * )
     */
    public function followUps() {}
}
