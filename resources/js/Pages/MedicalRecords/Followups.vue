<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import Modal from '@/Components/Modal.vue';
import {
    PencilIcon,
    CalendarIcon,
    DocumentTextIcon,
    UserIcon,
    PhoneIcon,
    EnvelopeIcon,
    MapPinIcon,
    ExclamationCircleIcon,
    HeartIcon,
    BeakerIcon,
    TrashIcon,
} from '@heroicons/vue/24/outline';

const props = defineProps({
    patient: Object,
});

const showDeleteModal = ref(false);

const deletePatient = () => {
    router.delete(route('patients.destroy', props.patient.id), {
        onSuccess: () => {
            showDeleteModal.value = false;
        },
    });
};
</script>

<template>
    <Head :title="`Patient : ${patient.full_name}`" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="h-16 w-16 bg-medicare-100 rounded-full flex items-center justify-center">
                        <UserIcon class="h-8 w-8 text-medicare-600" />
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ patient.full_name }}</h1>
                        <p class="text-sm text-gray-500 mt-1">
                            <span class="capitalize">{{ patient.gender === 'male' ? 'Homme' : 'Femme' }}</span>
                            <span class="mx-2">•</span>
                            {{ patient.age }} ans
                            <span class="mx-2">•</span>
                            ID Patient : #{{ patient.id }}
                        </p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <button
                        @click="showDeleteModal = true"
                        class="btn-outline text-red-600 hover:bg-red-50"
                    >
                        <TrashIcon class="h-5 w-5 mr-2" />
                        Supprimer
                    </button>
                    <Link :href="route('patients.edit', patient.id)" class="btn-primary">
                        <PencilIcon class="h-5 w-5 mr-2" />
                        Modifier
                    </Link>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Contact Information -->
                    <Card>
                        <template #header>
                            <h2 class="text-lg font-semibold text-gray-900">Informations de contact</h2>
                        </template>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-start space-x-3">
                                <PhoneIcon class="h-5 w-5 text-gray-400 mt-0.5" />
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Téléphone</p>
                                    <p class="text-sm text-gray-900 mt-1">{{ patient.phone }}</p>
                                </div>
                            </div>

                            <div v-if="patient.email" class="flex items-start space-x-3">
                                <EnvelopeIcon class="h-5 w-5 text-gray-400 mt-0.5" />
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Email</p>
                                    <p class="text-sm text-gray-900 mt-1">{{ patient.email }}</p>
                                </div>
                            </div>

                            <div v-if="patient.address" class="flex items-start space-x-3 md:col-span-2">
                                <MapPinIcon class="h-5 w-5 text-gray-400 mt-0.5" />
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Adresse</p>
                                    <p class="text-sm text-gray-900 mt-1">{{ patient.address }}</p>
                                </div>
                            </div>
                        </div>

                        <div v-if="patient.emergency_contact_name" class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-900 mb-4">Contact d'urgence</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Nom</p>
                                    <p class="text-sm text-gray-900 mt-1">{{ patient.emergency_contact_name }}</p>
                                </div>
                                <div v-if="patient.emergency_contact_phone">
                                    <p class="text-sm font-medium text-gray-500">Téléphone</p>
                                    <p class="text-sm text-gray-900 mt-1">{{ patient.emergency_contact_phone }}</p>
                                </div>
                            </div>
                        </div>
                    </Card>

                    <!-- Medical Information -->
                    <Card>
                        <template #header>
                            <h2 class="text-lg font-semibold text-gray-900">Informations médicales</h2>
                        </template>

                        <div class="space-y-6">
                            <div v-if="patient.blood_group" class="flex items-start space-x-3">
                                <BeakerIcon class="h-5 w-5 text-red-500 mt-0.5" />
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Groupe sanguin</p>
                                    <p class="text-sm font-semibold text-gray-900 mt-1">{{ patient.blood_group }}</p>
                                </div>
                            </div>

                            <div v-if="patient.allergies" class="flex items-start space-x-3">
                                <ExclamationCircleIcon class="h-5 w-5 text-orange-500 mt-0.5" />
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-500">Allergies</p>
                                    <div class="mt-2 p-3 bg-orange-50 border border-orange-200 rounded-lg">
                                        <p class="text-sm text-gray-900 whitespace-pre-line">{{ patient.allergies }}</p>
                                    </div>
                                </div>
                            </div>

                            <div v-if="patient.medical_history" class="flex items-start space-x-3">
                                <HeartIcon class="h-5 w-5 text-blue-500 mt-0.5" />
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-500">Antécédents médicaux</p>
                                    <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                        <p class="text-sm text-gray-900 whitespace-pre-line">{{ patient.medical_history }}</p>
                                    </div>
                                </div>
                            </div>

                            <div v-if="!patient.allergies && !patient.medical_history && !patient.blood_group" class="text-center py-8 text-gray-500">
                                <p class="text-sm">Aucune information médicale enregistrée</p>
                            </div>
                        </div>
                    </Card>

                    <!-- Recent Appointments -->
                    <Card>
                        <template #header>
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900">Historique des rendez-vous</h2>
                                <Link
                                    :href="route('appointments.create', { patient_id: patient.id })"
                                    class="btn-primary text-sm"
                                >
                                    <CalendarIcon class="h-4 w-4 mr-2" />
                                    Nouveau rendez-vous
                                </Link>
                            </div>
                        </template>

                        <div v-if="patient.appointments && patient.appointments.length > 0" class="divide-y divide-gray-200">
                            <div
                                v-for="appointment in patient.appointments"
                                :key="appointment.id"
                                class="py-4 hover:bg-gray-50 px-2 rounded-lg transition-colors"
                            >
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <p class="text-sm font-medium text-gray-900">
                                                Dr. {{ appointment.doctor.name }}
                                            </p>
                                            <StatusBadge :status="appointment.status" />
                                        </div>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ appointment.formatted_date_time }}
                                        </p>
                                        <p v-if="appointment.reason" class="text-sm text-gray-600 mt-1">
                                            {{ appointment.reason }}
                                        </p>
                                    </div>
                                    <Link
                                        :href="route('appointments.show', appointment.id)"
                                        class="btn-outline text-sm"
                                    >
                                        Voir
                                    </Link>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center py-12">
                            <CalendarIcon class="mx-auto h-12 w-12 text-gray-400" />
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun rendez-vous pour le moment</h3>
                            <p class="mt-1 text-sm text-gray-500">Planifiez le premier rendez-vous pour ce patient.</p>
                            <div class="mt-6">
                                <Link
                                    :href="route('appointments.create', { patient_id: patient.id })"
                                    class="btn-primary"
                                >
                                    <CalendarIcon class="h-5 w-5 mr-2" />
                                    Planifier un rendez-vous
                                </Link>
                            </div>
                        </div>
                    </Card>

                    <!-- Recent Medical Records -->
                    <Card v-if="patient.medical_records && patient.medical_records.length > 0">
                        <template #header>
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900">Dossiers médicaux</h2>
                                <Link
                                    :href="route('patients.medicalrecords', patient.id)"
                                    class="text-sm font-medium text-medicare-600 hover:text-medicare-700"
                                >
                                    Voir tout
                                </Link>
                            </div>
                        </template>

                        <div class="divide-y divide-gray-200">
                            <div
                                v-for="record in patient.medical_records.slice(0, 5)"
                                :key="record.id"
                                class="py-4 hover:bg-gray-50 px-2 rounded-lg transition-colors"
                            >
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ record.diagnosis || record.chief_complaint }}
                                        </p>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Dr. {{ record.doctor.name }}
                                            <span class="mx-2">•</span>
                                            {{ new Date(record.created_at).toLocaleDateString() }}
                                        </p>
                                    </div>
                                    <Link
                                        :href="route('medicalrecords.show', record.id)"
                                        class="btn-outline text-sm"
                                    >
                                        Voir
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </Card>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Next Appointment -->
                    <Card v-if="patient.next_appointment">
                        <template #header>
                            <h3 class="text-sm font-semibold text-gray-900">Prochain rendez-vous</h3>
                        </template>

                        <div class="space-y-3">
                            <div class="p-4 bg-medicare-50 border border-medicare-200 rounded-lg">
                                <p class="text-sm font-medium text-medicare-900">
                                    {{ patient.next_appointment.formatted_date_time }}
                                </p>
                                <p class="text-sm text-medicare-700 mt-1">
                                    avec Dr. {{ patient.next_appointment.doctor.name }}
                                </p>
                                <p v-if="patient.next_appointment.reason" class="text-sm text-gray-600 mt-2">
                                    {{ patient.next_appointment.reason }}
                                </p>
                            </div>
                            <Link
                                :href="route('appointments.show', patient.next_appointment.id)"
                                class="btn-outline w-full justify-center"
                            >
                                Voir les détails
                            </Link>
                        </div>
                    </Card>

                    <!-- Patient Stats -->
                    <Card>
                        <template #header>
                            <h3 class="text-sm font-semibold text-gray-900">Statistiques du patient</h3>
                        </template>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Total des rendez-vous</span>
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ patient.appointments?.length || 0 }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Dossiers médicaux</span>
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ patient.medical_records?.length || 0 }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-600">Membre depuis</span>
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ new Date(patient.created_at).toLocaleDateString() }}
                                </span>
                            </div>
                        </div>
                    </Card>

                    <!-- Quick Actions -->
                    <Card>
                        <template #header>
                            <h3 class="text-sm font-semibold text-gray-900">Actions rapides</h3>
                        </template>

                        <div class="space-y-2">
                            <Link
                                :href="route('appointments.create', { patient_id: patient.id })"
                                class="btn-primary w-full justify-center"
                            >
                                <CalendarIcon class="h-5 w-5 mr-2" />
                                Planifier un rendez-vous
                            </Link>
                            <Link
                                :href="route('patients.medicalrecords', patient.id)"
                                class="btn-outline w-full justify-center"
                            >
                                <DocumentTextIcon class="h-5 w-5 mr-2" />
                                Voir les dossiers médicaux
                            </Link>
                            <Link
                                :href="route('patients.appointments', patient.id)"
                                class="btn-outline w-full justify-center"
                            >
                                <CalendarIcon class="h-5 w-5 mr-2" />
                                Voir tous les rendez-vous
                            </Link>
                        </div>
                    </Card>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <Modal :show="showDeleteModal" @close="showDeleteModal = false" title="Supprimer le patient">
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <ExclamationCircleIcon class="h-6 w-6 text-red-600" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-900 font-medium">
                            Êtes-vous sûr de vouloir supprimer {{ patient.full_name }} ?
                        </p>
                        <p class="text-sm text-gray-500 mt-2">
                            Cette action est irréversible. Tous les rendez-vous et dossiers médicaux associés seront également supprimés.
                        </p>
                    </div>
                </div>
            </div>

            <template #footer>
                <div class="flex items-center justify-end space-x-4">
                    <button @click="showDeleteModal = false" class="btn-outline">
                        Annuler
                    </button>
                    <button @click="deletePatient" class="btn-danger">
                        Oui, supprimer le patient
                    </button>
                </div>
            </template>
        </Modal>
    </AuthenticatedLayout>
</template>
