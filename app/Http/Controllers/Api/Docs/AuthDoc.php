<?php

namespace App\Http\Controllers\Api\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="Endpoints d'authentification"
 * )
 */
class AuthDoc
{
    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Authentifier un utilisateur",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="utilisateur@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="motdepasse"),
     *             @OA\Property(property="remember", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Connexion réussie",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Connexion réussie"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
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
     *                     @OA\Items(type="string", example="Ces identifiants ne correspondent pas à nos enregistrements.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Trop de tentatives de connexion",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trop de tentatives de connexion. Veuillez réessayer dans 60 secondes.")
     *         )
     *     )
     * )
     */
    public function login()
    {
        // Documentation only
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Déconnecter l'utilisateur actuel",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=204,
     *         description="Déconnexion réussie"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Non authentifié.")
     *         )
     *     )
     * )
     */
    public function logout()
    {
        // Documentation only
    }

    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Récupérer les informations de l'utilisateur connecté",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Informations de l'utilisateur",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function user()
    {
        // Documentation only
    }
}
