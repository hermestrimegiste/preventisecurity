<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="MediCare API Documentation",
 *     description="API documentation for MediCare - A healthcare management system",
 *     @OA\Contact(
 *         email="support@medicare.com",
 *         name="MediCare Support"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     securityScheme="bearerAuth",
 *     bearerFormat="JWT"
 * )
 * 
 * @OA\SecurityRequirement({
 *     "bearerAuth": {}
 * })
 * 
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for Authentication"
 * )
 * 
 * @OA\Tag(
 *     name="Patients",
 *     description="Endpoints for managing patients"
 * )
 * 
 * @OA\Tag(
 *     name="Appointments",
 *     description="Endpoints for managing appointments"
 * )
 * 
 * @OA\Tag(
 *     name="Medical Records",
 *     description="Endpoints for managing medical records"
 * )
 * 
 * @OA\Tag(
 *     name="Organizations",
 *     description="Endpoints for managing organizations"
 * )
 */
class ApiDocumentationController extends Controller
{
    // This controller is used for Swagger documentation only
}
