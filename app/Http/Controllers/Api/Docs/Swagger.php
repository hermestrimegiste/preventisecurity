<?php

namespace App\Http\Controllers\Api\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="MediCare API Documentation",
 *     description="Documentation de l'API MediCare",
 *     @OA\Contact(
 *         email="support@medicare.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Server(
 *     url="/",
 *     description="API Server"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     description="Utilisez le token JWT obtenu après authentification",
 *     name="Authorization",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * @OA\Tag(
 *     name="Authentication",
 *     description="Endpoints d'authentification"
 * )
 */
class Swagger
{
    // Classe vide, utilisée uniquement pour la documentation
}
