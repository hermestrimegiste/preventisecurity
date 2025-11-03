<?php

namespace App\Http\Controllers\Api\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\PathItem(path="/api")
 * 
 * Documentation pour la gestion des jetons CSRF
 */
class CsrfTokenDoc
{
    /**
     * @OA\Post(
     *     path="/api/csrf-token",
     *     summary="Obtenir un jeton CSRF",
     *     tags={"Authentification"},
     *     description="Récupère un jeton CSRF valide après authentification réussie",
     *     operationId="getCsrfToken",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Identifiants de l'utilisateur",
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="utilisateur@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="motdepasse")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Jeton CSRF récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="csrf_token", type="string", example="votre-token-csrf")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Identifiants invalides",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Les identifiants fournis sont incorrects.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Les données fournies ne sont pas valides."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(type="string", example="Le champ email est obligatoire.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getCsrfToken()
    {
        // Documentation only
    }
}
