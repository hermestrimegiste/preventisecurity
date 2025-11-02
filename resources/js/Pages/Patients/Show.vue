<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    UserIcon,
    EnvelopeIcon,
    PhoneIcon,
    HomeIcon,
    MapPinIcon,
    CalendarIcon,
    IdentificationIcon,
    CakeIcon,
    FlagIcon,
    PencilIcon,
    ClockIcon,
    BriefcaseIcon,
    ExclamationTriangleIcon,
    ClipboardDocumentListIcon,
    ClipboardDocumentCheckIcon,
    UserPlusIcon
} from '@heroicons/vue/24/outline';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';
import Button from '@/Components/Button.vue';

const props = defineProps({
    patient: {
        type: Object,
        required: true,
    },
    recentAppointments: {
        type: Array,
        default: () => [],
    },
    medicalRecords: {
        type: Array,
        default: () => [],
    },
});

const formatDate = (dateString) => {
    if (!dateString) return 'Non spécifié';
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('fr-FR', options);
};

const calculateAge = (birthDate) => {
    if (!birthDate) return null;
    const today = new Date();
    const birth = new Date(birthDate);
    let age = today.getFullYear() - birth.getFullYear();
    const monthDiff = today.getMonth() - birth.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
    }

    return age;
};

const age = calculateAge(props.patient.birth_date);
</script>

<template>
    <Head :title="`${patient.first_name} ${patient.last_name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <span class="text-blue-600 text-xl font-medium">
                            {{ patient.first_name.charAt(0) }}{{ patient.last_name.charAt(0) }}
                        </span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">
                            {{ patient.first_name }} {{ patient.last_name }}
                            <Badge v-if="patient.status" :variant="patient.status === 'active' ? 'green' : 'gray'" class="ml-2">
                                {{ patient.status === 'active' ? 'Actif' : 'Inactif' }}
                            </Badge>
                        </h1>
                        <p class="text-sm text-gray-500">
                            Membre depuis {{ formatDate(patient.created_at) }}
                        </p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <Link
                        :href="route('patients.edit', patient.id)"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <PencilIcon class="h-4 w-4 mr-2" />
                        Modifier
                    </Link>
                    <Link
                        :href="route('appointments.create', { patient_id: patient.id })"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <CalendarIcon class="h-4 w-4 mr-2" />
                        Nouveau rendez-vous
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Informations principales -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Colonne de gauche - Informations personnelles -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Carte d'information personnelle -->
                        <Card>
                            <template #header>
                                <h3 class="text-lg font-medium text-gray-900">
                                    <UserIcon class="h-5 w-5 inline-block mr-2 text-blue-500" />
                                    Informations personnelles
                                </h3>
                            </template>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Nom complet</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ patient.first_name }} {{ patient.last_name }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Date de naissance</h4>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ formatDate(patient.birth_date) }}
                                        <span v-if="age" class="text-gray-500"> ({{ age }} ans)</span>
                                    </p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Genre</h4>
                                    <p class="mt-1 text-sm text-gray-900 capitalize">
                                        {{ patient.gender || 'Non spécifié' }}
                                    </p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Profession</h4>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ patient.occupation || 'Non spécifiée' }}
                                    </p>
                                </div>
                            </div>
                        </Card>

                        <!-- Coordonnées -->
                        <Card>
                            <template #header>
                                <h3 class="text-lg font-medium text-gray-900">
                                    <MapPinIcon class="h-5 w-5 inline-block mr-2 text-blue-500" />
                                    Coordonnées
                                </h3>
                            </template>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Email</h4>
                                    <div class="mt-1 flex items-center">
                                        <EnvelopeIcon class="h-4 w-4 text-gray-400 mr-2" />
                                        <a
                                            v-if="patient.email"
                                            :href="`mailto:${patient.email}`"
                                            class="text-sm text-blue-600 hover:underline"
                                        >
                                            {{ patient.email }}
                                        </a>
                                        <span v-else class="text-sm text-gray-500">Non spécifié</span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Téléphone</h4>
                                    <div class="mt-1 flex items-center">
                                        <PhoneIcon class="h-4 w-4 text-gray-400 mr-2" />
                                        <a
                                            v-if="patient.phone"
                                            :href="`tel:${patient.phone}`"
                                            class="text-sm text-blue-600 hover:underline"
                                        >
                                            {{ patient.phone }}
                                        </a>
                                        <span v-else class="text-sm text-gray-500">Non spécifié</span>
                                    </div>
                                </div>
                                <div class="md:col-span-2">
                                    <h4 class="text-sm font-medium text-gray-500">Adresse</h4>
                                    <div class="mt-1 flex">
                                        <HomeIcon class="h-4 w-4 text-gray-400 mr-2 mt-0.5 flex-shrink-0" />
                                        <div>
                                            <p class="text-sm text-gray-900">{{ patient.address || 'Non spécifiée' }}</p>
                                            <p class="text-sm text-gray-900">
                                                <template v-if="patient.postal_code || patient.city">
                                                    {{ patient.postal_code }} {{ patient.city }}
                                                </template>
                                                <template v-else>
                                                    Code postal et ville non spécifiés
                                                </template>
                                            </p>
                                            <p v-if="patient.country" class="text-sm text-gray-900">
                                                {{ patient.country }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </Card>

                        <!-- Informations médicales -->
                        <Card>
                            <template #header>
                                <h3 class="text-lg font-medium text-gray-900">
                                    <IdentificationIcon class="h-5 w-5 inline-block mr-2 text-blue-500" />
                                    Informations médicales
                                </h3>
                            </template>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Groupe sanguin</h4>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ patient.blood_type || 'Non spécifié' }}
                                    </p>
                                </div>
                                <div class="md:col-span-2">
                                    <h4 class="text-sm font-medium text-gray-500">Allergies connues</h4>
                                    <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                                        {{ patient.allergies || 'Aucune allergie connue' }}
                                    </p>
                                </div>
                                <div class="md:col-span-2">
                                    <h4 class="text-sm font-medium text-gray-500">Traitements en cours</h4>
                                    <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                                        {{ patient.medications || 'Aucun traitement en cours' }}
                                    </p>
                                </div>
                            </div>
                        </Card>

                        <!-- Contact d'urgence -->
                        <Card v-if="patient.emergency_contact_name || patient.emergency_contact_phone">
                            <template #header>
                                <h3 class="text-lg font-medium text-gray-900">
                                    <ExclamationTriangleIcon class="h-5 w-5 inline-block mr-2 text-red-500" />
                                    Contact d'urgence
                                </h3>
                            </template>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Nom du contact</h4>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ patient.emergency_contact_name || 'Non spécifié' }}
                                    </p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Téléphone du contact</h4>
                                    <div class="mt-1 flex items-center">
                                        <PhoneIcon class="h-4 w-4 text-gray-400 mr-2" />
                                        <a
                                            v-if="patient.emergency_contact_phone"
                                            :href="`tel:${patient.emergency_contact_phone}`"
                                            class="text-sm text-blue-600 hover:underline"
                                        >
                                            {{ patient.emergency_contact_phone }}
                                        </a>
                                        <span v-else class="text-sm text-gray-500">Non spécifié</span>
                                    </div>
                                </div>
                            </div>
                        </Card>
                    </div>

                    <!-- Colonne de droite - Rendez-vous et historique -->
                    <div class="space-y-6">
                        <!-- Prochains rendez-vous -->
                        <Card>
                            <template #header>
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        <CalendarIcon class="h-5 w-5 inline-block mr-2 text-blue-500" />
                                        Prochains rendez-vous
                                    </h3>
                                    <Link
                                        :href="route('appointments.create', { patient_id: patient.id })"
                                        class="text-sm text-blue-600 hover:text-blue-800"
                                    >
                                        + Ajouter
                                    </Link>
                                </div>
                            </template>

                            <div v-if="recentAppointments.length > 0" class="space-y-4">
                                <div
                                    v-for="appointment in recentAppointments"
                                    :key="appointment.id"
                                    class="border-l-4 border-blue-500 pl-4 py-2"
                                >
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <Link
                                                :href="route('appointments.show', appointment.id)"
                                                class="text-sm font-medium text-gray-900 hover:text-blue-600"
                                            >
                                                {{ appointment.title }}
                                            </Link>
                                            <p class="text-xs text-gray-500">
                                                {{ formatDate(appointment.start_time) }}
                                            </p>
                                        </div>
                                        <Badge
                                            :variant="appointment.status === 'confirmed' ? 'green' : 'yellow'"
                                            size="xs"
                                        >
                                            {{ appointment.status === 'confirmed' ? 'Confirmé' : 'En attente' }}
                                        </Badge>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center py-4">
                                <p class="text-sm text-gray-500">Aucun rendez-vous à venir</p>
                                <Link
                                    :href="route('appointments.create', { patient_id: patient.id })"
                                    class="mt-2 inline-flex items-center text-sm text-blue-600 hover:text-blue-800"
                                >
                                    <CalendarIcon class="h-4 w-4 mr-1" />
                                    Planifier un rendez-vous
                                </Link>
                            </div>
                        </Card>

                        <!-- Derniers dossiers médicaux -->
                        <Card>
                            <template #header>
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        <ClipboardDocumentListIcon class="h-5 w-5 inline-block mr-2 text-blue-500" />
                                        Dernières consultations
                                    </h3>
                                    <Link
                                        :href="route('medical-records.create', { patient_id: patient.id })"
                                        class="text-sm text-blue-600 hover:text-blue-800"
                                    >
                                        + Ajouter
                                    </Link>
                                </div>
                            </template>

                            <div v-if="medicalRecords.length > 0" class="space-y-4">
                                <div
                                    v-for="record in medicalRecords"
                                    :key="record.id"
                                    class="border-l-4 border-green-500 pl-4 py-2"
                                >
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <Link
                                                :href="route('medical-records.show', record.id)"
                                                class="text-sm font-medium text-gray-900 hover:text-blue-600"
                                            >
                                                {{ record.diagnosis || 'Consultation' }}
                                            </Link>
                                            <p class="text-xs text-gray-500">
                                                {{ formatDate(record.visit_date) }} - {{ record.doctor_name }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center py-4">
                                <p class="text-sm text-gray-500">Aucun dossier médical récent</p>
                                <Link
                                    :href="route('medical-records.create', { patient_id: patient.id })"
                                    class="mt-2 inline-flex items-center text-sm text-blue-600 hover:text-blue-800"
                                >
                                    <ClipboardDocumentCheckIcon class="h-4 w-4 mr-1" />
                                    Nouvelle consultation
                                </Link>
                            </div>
                        </Card>

                        <!-- Notes -->
                        <Card v-if="patient.notes">
                            <template #header>
                                <h3 class="text-lg font-medium text-gray-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Notes
                                </h3>
                            </template>

                            <p class="text-sm text-gray-700 whitespace-pre-line">
                                {{ patient.notes }}
                            </p>
                        </Card>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
