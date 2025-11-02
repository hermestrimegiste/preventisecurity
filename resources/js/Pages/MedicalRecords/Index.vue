<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';
import { PencilIcon, CalendarIcon, DocumentTextIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    records: Array,
});
</script>

<template>
    <Head title="Medical Records" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900">Liste des dossiers médicaux</h1>
                <Link :href="route('medical-records.create')" class="btn-primary">
                    <PlusIcon class="h-5 w-5 mr-2" />
                    Ajouter un dossier médical
                </Link>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <Card v-for="record in records" :key="record.id">
                        <template #header>
                            <h2 class="text-lg font-semibold text-gray-900">{{ record.patient.full_name }}</h2>
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
                </div>

                <div class="space-y-6">
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
                                <p class="text-sm font-medium text-gray-500">Date de suivi</p>
                                <div class="flex items-center mt-1 text-sm text-gray-700">
                                    <CalendarIcon class="h-4 w-4 mr-2 text-gray-500" />
                                    {{ new Date(record.follow_up_date).toLocaleDateString() }}
                                </div>
                            </div>
                        </div>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
