<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 *     version="1.0.0",
 *     title="MediCare API Documentation",
 *     description="API documentation for MediCare - A healthcare management system",
 *         email="support@medicare.com",
 *         name="MediCare Support"
 *     ),
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * 
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 * 
 *     type="http",
 *     scheme="bearer",
 *     securityScheme="bearerAuth",
 *     bearerFormat="JWT"
 * )
 * 
 *     "bearerAuth": {}
 * })
 * 
 *     name="Authentication",
 *     description="API Endpoints for Authentication"
 * )
 * 
 *     name="Patients",
 *     description="Endpoints for managing patients"
 * )
 * 
 *     name="Appointments",
 *     description="Endpoints for managing appointments"
 * )
 * 
 *     name="Medical Records",
 *     description="Endpoints for managing medical records"
 * )
 * 
 *     name="Organizations",
 *     description="Endpoints for managing organizations"
 * )
 */
class ApiDocumentationController extends Controller
{
    // This controller is used for Swagger documentation only
}
