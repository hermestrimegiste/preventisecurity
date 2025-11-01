<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Patients",
 *     description="API Endpoints for managing patients"
 * )
 */
class PatientController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/patients",
     *      operationId="getPatientsList",
     *      tags={"Patients"},
     *      summary="Get list of patients",
     *      description="Returns list of patients",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Patient")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function index()
    {
        // Implementation will go here
        return response()->json([]);
    }

    /**
     * @OA\Get(
     *      path="/api/patients/{id}",
     *      operationId="getPatientById",
     *      tags={"Patients"},
     *      summary="Get patient information",
     *      description="Returns patient data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Patient id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Patient")
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show($id)
    {
        // Implementation will go here
        return response()->json([]);
    }
}
