<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import Modal from '@/Components/Modal.vue';
import {
    PencilIcon,
    XMarkIcon,
    CheckIcon,
    DocumentTextIcon,
} from '@heroicons/vue/24/outline';

const props = defineProps({
    appointment: Object,
});

const showCancelModal = ref(false);

const cancelAppointment = () => {
    router.patch(
        route('appointments.cancel', props.appointment.id),
        {},
        {
            onSuccess: () => {
                showCancelModal.value = false;
            },
        }
    );
};

const completeAppointment = () => {
    router.patch(route('appointments.complete', props.appointment.id));
};
</script>

<template>
    <Head :title="`Appointment #${appointment.id}`" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Détails du rendez-vous</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Rendez-vous #{{ appointment.id }}
                    </p>
                </div>
                <div class="flex space-x-4">
                    <Link
                        v-if="appointment.status === 'scheduled'"
                        :href="route('appointments.edit', appointment.id)"
                        class="btn-outline"
                    >
                        <PencilIcon class="h-5 w-5 mr-2" />
                        Modifier
                    </Link>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Appointment Information -->
                    <Card>
                        <template #header>
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900">Informations du rendez-vous</h2>
                                <StatusBadge :status="appointment.status" />
                            </div>
                        </template>

                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Patient</p>
                                <Link
                                    :href="route('patients.show', appointment.patient.id)"
                                    class="text-sm font-medium text-medicare-600 hover:text-medicare-900"
                                >
                                    {{ appointment.patient.full_name }}
                                </Link>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500">Médecin</p>
                                <p class="text-sm text-gray-900">
                                    <!-- Dr. {{ appointment.doctor.name }} -->
                                    {{ appointment.doctor.name }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Date & Heure</p>
                                    <p class="text-sm text-gray-900">{{ appointment.formatted_date_time }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Durée</p>
                                    <p class="text-sm text-gray-900">{{ appointment.duration_minutes }} minutes</p>
                                </div>
                            </div>

                            <div v-if="appointment.reason">
                                <p class="text-sm font-medium text-gray-500">Statut</p>
                                <p class="text-sm text-gray-900">{{ appointment.status }}</p>
                            </div>

                            <div v-if="appointment.notes">
                                <p class="text-sm font-medium text-gray-500">Notes</p>
                                <p class="text-sm text-gray-900 whitespace-pre-line">{{ appointment.notes }}</p>
                            </div>
                        </div>
                    </Card>

                    <!-- Medical Record -->
                    <Card v-if="appointment.medical_record">
                        <template #header>
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900">Dossier médical</h2>
                                <Link
                                    :href="route('medical-records.show', appointment.medical_record.id)"
                                    class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-medicare-600 hover:bg-medicare-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-medicare-500"
                                >
                                    Voir le dossier médical
                                </Link>
                            </div>
                        </template>

                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Problème principal</p>
                                <p class="text-sm text-gray-900">{{ appointment.medical_record.chief_complaint }}</p>
                            </div>

                            <div v-if="appointment.medical_record.diagnosis">
                                <p class="text-sm font-medium text-gray-500">Diagnostique</p>
                                <p class="text-sm text-gray-900">{{ appointment.medical_record.diagnosis }}</p>
                            </div>
                        </div>
                    </Card>

                    <Card v-else-if="appointment.status === 'completed'">
                        <div class="text-center py-8">
                            <DocumentTextIcon class="mx-auto h-12 w-12 text-gray-400" />
                            <h3 class="text-sm font-medium text-gray-900">Aucun dossier médical</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Aucun dossier médical n'a été créé pour ce rendez-vous.
                            </p>
                            <div class="mt-6">
                                <Link
                                    :href="route('medical-records.create', { appointment_id: appointment.id })"
                                    class="btn-primary"
                                >
                                    <DocumentTextIcon class="h-5 w-5 mr-2" />
                                    Ajouter un dossier médical
                                </Link>
                            </div>
                        </div>
                    </Card>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Actions -->
                    <Card v-if="appointment.status === 'scheduled'">
                        <template #header>
                            <h3 class="text-sm font-semibold text-gray-900">Actions</h3>
                        </template>

                        <div class="space-y-2">
                            <button
                                @click="completeAppointment"
                                class="btn-success w-full justify-center"
                            >
                                <CheckIcon class="h-5 w-5 mr-2" />
                                Marquer comme terminé
                            </button>
                            <button
                                v-if="appointment.can_be_cancelled"
                                @click="showCancelModal = true"
                                class="btn-danger w-full justify-center"
                            >
                                <XMarkIcon class="h-5 w-5 mr-2" />
                                Annuler le rendez-vous
                            </button>
                        </div>
                    </Card>

                    <!-- Patient Quick Info -->
                    <Card>
                        <template #header>
                            <h3 class="text-sm font-semibold text-gray-900">Informations du patient</h3>
                        </template>

                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Age</p>
                                <p class="text-sm text-gray-900">{{ appointment.patient.age }} ans</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Téléphone</p>
                                <p class="text-sm text-gray-900">{{ appointment.patient.phone }}</p>
                            </div>
                            <Link
                                :href="route('patients.show', appointment.patient.id)"
                                class="btn-outline w-full justify-center mt-4"
                            >
                                Voir le profil complet
                            </Link>
                        </div>
                    </Card>
                </div>
            </div>
        </div>

        <!-- Cancel Confirmation Modal -->
        <Modal :show="showCancelModal" @close="showCancelModal = false" title="Annuler le rendez-vous">
            <p class="text-sm text-gray-500">
                Êtes-vous sûr de vouloir annuler ce rendez-vous ? Cette action est irréversible.
            </p>

            <template #footer>
                <div class="flex items-center justify-end space-x-4">
                    <button @click="showCancelModal = false" class="btn-outline">
                        Non, garder le rendez-vous
                    </button>
                    <button @click="cancelAppointment" class="btn-danger">
                        Oui, annuler le rendez-vous
                    </button>
                </div>
            </template>
        </Modal>
    </AuthenticatedLayout>
</template>
