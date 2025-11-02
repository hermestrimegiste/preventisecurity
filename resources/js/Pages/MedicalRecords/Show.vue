<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';
import { PencilIcon, CalendarIcon, DocumentTextIcon } from '@heroicons/vue/24/outline';

defineProps({
    record: Object,
});
</script>

<template>
    <Head title="Medical Record" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dossier médical</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ new Date(record.created_at).toLocaleDateString() }}
                    </p>
                </div>
                <Link :href="route('medical-records.edit', record.id)" class="btn-outline">
                    <PencilIcon class="h-5 w-5 mr-2" />
                    Edit
                </Link>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Patient & Appointment Info -->
                    <Card>
                        <template #header>
                            <h2 class="text-lg font-semibold text-gray-900">Informations du patient</h2>
                        </template>

                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Patient</p>
                                <Link
                                    :href="route('patients.show', record.patient.id)"
                                    class="text-sm font-medium text-medicare-600 hover:text-medicare-900"
                                >
                                    {{ record.patient.full_name }}
                                </Link>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date of Birth</p>
                                <p class="text-sm text-gray-900">{{ new Date(record.patient.date_of_birth).toLocaleDateString() }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Contact</p>
                                <p class="text-sm text-gray-900">{{ record.patient.phone_number }}</p>
                            </div>
                            <div v-if="record.appointment">
                                <p class="text-sm font-medium text-gray-500">Appointment</p>
                                <Link
                                    :href="route('appointments.show', record.appointment.id)"
                                    class="text-sm font-medium text-medicare-600 hover:text-medicare-900"
                                >
                                    View Appointment
                                </Link>
                            </div>
                        </div>
                    </Card>

                    <!-- Medical Details -->
                    <Card>
                        <template #header>
                            <h2 class="text-lg font-semibold text-gray-900">Détails médicaux</h2>
                        </template>

                        <div class="space-y-6">
                            <div>
                                <h3 class="text-md font-medium text-gray-900 mb-2">Chief Complaint</h3>
                                <p class="text-sm text-gray-700 whitespace-pre-line">{{ record.chief_complaint || 'Not specified' }}</p>
                            </div>

                            <div>
                                <h3 class="text-md font-medium text-gray-900 mb-2">Examination Notes</h3>
                                <p class="text-sm text-gray-700 whitespace-pre-line">{{ record.examination_notes || 'No examination notes recorded' }}</p>
                            </div>

                            <div>
                                <h3 class="text-md font-medium text-gray-900 mb-2">Diagnosis</h3>
                                <p class="text-sm text-gray-700 whitespace-pre-line">{{ record.diagnosis || 'No diagnosis recorded' }}</p>
                            </div>

                            <div>
                                <h3 class="text-md font-medium text-gray-900 mb-2">Treatment Plan</h3>
                                <p class="text-sm text-gray-700 whitespace-pre-line">{{ record.treatment_plan || 'No treatment plan specified' }}</p>
                            </div>

                            <div v-if="record.prescription">
                                <h3 class="text-md font-medium text-gray-900 mb-2">Prescription</h3>
                                <p class="text-sm text-gray-700 whitespace-pre-line">{{ record.prescription }}</p>
                            </div>

                            <div v-if="record.lab_tests">
                                <h3 class="text-md font-medium text-gray-900 mb-2">Lab Tests</h3>
                                <p class="text-sm text-gray-700 whitespace-pre-line">{{ record.lab_tests }}</p>
                            </div>
                        </div>
                    </Card>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Follow-up Information -->
                    <Card>
                        <template #header>
                            <h2 class="text-lg font-semibold text-gray-900">Suivi</h2>
                        </template>

                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Instructions de suivi</p>
                                <p class="text-sm text-gray-700 mt-1 whitespace-pre-line">
                                    {{ record.follow_up_instructions || 'No follow-up instructions provided' }}
                                </p>
                            </div>

                            <div v-if="record.follow_up_date">
                                <p class="text-sm font-medium text-gray-500">Follow-up Date</p>
                                <div class="flex items-center mt-1 text-sm text-gray-700">
                                    <CalendarIcon class="h-4 w-4 mr-2 text-gray-500" />
                                    {{ new Date(record.follow_up_date).toLocaleDateString() }}
                                </div>
                            </div>
                        </div>
                    </Card>

                    <!-- Record Metadata -->
                    <Card>
                        <template #header>
                            <h2 class="text-lg font-semibold text-gray-900">Détails du dossier</h2>
                        </template>

                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Créé le</p>
                                <p class="text-sm text-gray-700">
                                    {{ new Date(record.created_at).toLocaleString() }}
                                </p>
                            </div>
                            <div v-if="record.updated_at !== record.created_at">
                                <p class="text-sm font-medium text-gray-500">Dernière mise à jour</p>
                                <p class="text-sm text-gray-700">
                                    {{ new Date(record.updated_at).toLocaleString() }}
                                </p>
                            </div>
                            <div v-if="record.doctor">
                                <p class="text-sm font-medium text-gray-500">Médecin traitant</p>
                                <p class="text-sm text-gray-700">
                                    {{ record.doctor.name }}
                                </p>
                            </div>
                        </div>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

