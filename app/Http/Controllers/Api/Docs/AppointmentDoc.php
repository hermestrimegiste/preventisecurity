<?php

namespace App\Http\Controllers\Api\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Appointments",
 *     description="Endpoints for managing appointments.."
 * )
 */
class AppointmentDoc
{
    /**
     * @OA\Get(
     *     path="/api/appointments",
     *     summary="List all appointments",
     *     tags={"Appointments"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter by status",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="doctor_id",
     *         in="query",
     *         description="Filter by doctor ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Filter by date (YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of appointments",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Appointment")),
     *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
     *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function index()
    {
        // Documentation only
    }

    /**
     * @OA\Get(
     *     path="/api/appointments/upcoming",
     *     summary="List upcoming appointments",
     *     tags={"Appointments"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of upcoming appointments",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Appointment")),
     *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
     *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function upcoming()
    {
        // Documentation only
    }

    /**
     * @OA\Get(
     *     path="/api/appointments/today",
     *     summary="List today's appointments",
     *     tags={"Appointments"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of today's appointments",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Appointment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function today()
    {
        // Documentation only
    }

    /**
     * @OA\Get(
     *     path="/api/appointments/calendar",
     *     summary="Get appointments for calendar view",
     *     tags={"Appointments"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="start",
     *         in="query",
     *         description="Start date (YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="end",
     *         in="query",
     *         description="End date (YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of appointments for the specified date range",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Appointment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function calendar()
    {
        // Documentation only
    }

    /**
     * @OA\Post(
     *     path="/api/appointments",
     *     summary="Create a new appointment",
     *     tags={"Appointments"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreAppointmentRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Appointment created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Appointment")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store()
    {
        // Documentation only
    }

    /**
     * @OA\Get(
     *     path="/api/appointments/{appointment}",
     *     summary="Get a specific appointment",
     *     tags={"Appointments"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="appointment",
     *         in="path",
     *         description="ID of the appointment",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appointment details",
     *         @OA\JsonContent(ref="#/components/schemas/Appointment")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appointment not found"
     *     )
     * )
     */
    public function show()
    {
        // Documentation only
    }

    /**
     * @OA\Put(
     *     path="/api/appointments/{appointment}",
     *     summary="Update an appointment",
     *     tags={"Appointments"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="appointment",
     *         in="path",
     *         description="ID of the appointment to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateAppointmentRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appointment updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Appointment")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized action"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appointment not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update()
    {
        // Documentation only
    }

    /**
     * @OA\Delete(
     *     path="/api/appointments/{appointment}",
     *     summary="Delete an appointment",
     *     tags={"Appointments"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="appointment",
     *         in="path",
     *         description="ID of the appointment to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Appointment deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized action"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appointment not found"
     *     )
     * )
     */
    public function destroy()
    {
        // Documentation only
    }

    /**
     * @OA\Post(
     *     path="/api/appointments/{appointment}/cancel",
     *     summary="Cancel an appointment",
     *     tags={"Appointments"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="appointment",
     *         in="path",
     *         description="ID of the appointment to cancel",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appointment cancelled successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Appointment")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized action"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appointment not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Appointment cannot be cancelled"
     *     )
     * )
     */
    public function cancel()
    {
        // Documentation only
    }

    /**
     * @OA\Post(
     *     path="/api/appointments/{appointment}/complete",
     *     summary="Mark an appointment as completed",
     *     tags={"Appointments"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="appointment",
     *         in="path",
     *         description="ID of the appointment to mark as completed",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appointment marked as completed",
     *         @OA\JsonContent(ref="#/components/schemas/Appointment")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized action"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appointment not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Appointment cannot be marked as completed"
     *     )
     * )
     */
    public function complete()
    {
        // Documentation only
    }

    /**
     * @OA\Get(
     *     path="/api/doctors/{doctor}/appointments",
     *     summary="Get upcoming appointments for a specific doctor",
     *     tags={"Appointments"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="doctor",
     *         in="path",
     *         description="ID of the doctor",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of upcoming appointments for the doctor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Appointment")),
     *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
     *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Doctor not found"
     *     )
     * )
     */
    public function byDoctor()
    {
        // Documentation only
    }
}
