<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import {
    UsersIcon,
    CalendarIcon,
    ClockIcon,
    CheckCircleIcon,
    ArrowTrendingUpIcon,
} from '@heroicons/vue/24/outline';

defineProps({
    stats: {
        type: Object,
        default: () => ({
            total_patients: 0,
            total_appointments: 0,
            appointments_today: 0,
            upcoming_appointments: 0,
            completed_this_week: 0,
            pending_follow_ups: 0,
        }),
    },
    todayAppointments: {
        type: Array,
        default: () => [],
    },
    upcomingAppointments: {
        type: Array,
        default: () => [],
    },
    recentPatients: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Bon retour ! Voici ce qui se passe aujourd'hui.
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Total Patients -->
                <Card>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-medicare-100 rounded-lg">
                                <UsersIcon class="h-8 w-8 text-medicare-600" />
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-500">Total Patients</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ stats.total_patients }}</p>
                            <p class="text-xs text-green-600 mt-1">
                                <ArrowTrendingUpIcon class="inline h-3 w-3 mr-1" />
                                Dossiers actifs
                            </p>
                        </div>
                    </div>
                </Card>

                <!-- Today's Appointments -->
                <Card>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-yellow-100 rounded-lg">
                                <ClockIcon class="h-8 w-8 text-yellow-600" />
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-500">RDV aujourd'hui</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ stats.appointments_today }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                Planifiés pour aujourd'hui
                            </p>
                        </div>
                    </div>
                </Card>

                <!-- Upcoming -->
                <Card>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <CalendarIcon class="h-8 w-8 text-blue-600" />
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-500">Prochains RDV</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ stats.upcoming_appointments }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                7 prochains jours
                            </p>
                        </div>
                    </div>
                </Card>

                <!-- Completed This Week -->
                <Card>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-3 bg-green-100 rounded-lg">
                                <CheckCircleIcon class="h-8 w-8 text-green-600" />
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-500"> RDV Complétés</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ stats.completed_this_week }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                Cette semaine
                            </p>
                        </div>
                    </div>
                </Card>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Today's Appointments -->
                <div class="lg:col-span-2">
                    <Card>
                        <template #header>
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900">RDV aujourd'hui</h2>
                                <Link
                                    :href="route('appointments.index', { date: new Date().toISOString().split('T')[0] })"
                                    class="text-sm font-medium text-medicare-600 hover:text-medicare-700"
                                >
                                    Voir tous
                                </Link>
                            </div>
                        </template>

                        <div v-if="todayAppointments.length > 0" class="divide-y divide-gray-200">
                            <div
                                v-for="appointment in todayAppointments"
                                :key="appointment.id"
                                class="py-4 flex items-center justify-between hover:bg-gray-50 px-2 rounded-lg transition-colors"
                            >
                                <div class="flex items-center space-x-4 flex-1">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-medicare-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-medicare-600">
                                                {{ appointment.patient.first_name.charAt(0) }}{{ appointment.patient.last_name.charAt(0) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ appointment.patient.full_name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ new Date(appointment.appointment_date).toLocaleTimeString('en-US', {
                                                hour: '2-digit',
                                                minute: '2-digit'
                                            }) }}
                                            <!-- • Dr. {{ appointment.doctor.name }} -->
                                            • {{ appointment.doctor.name }}
                                        </p>
                                    </div>
                                    <StatusBadge :status="appointment.status" />
                                </div>
                                <Link
                                    :href="route('appointments.show', appointment.id)"
                                    class="btn-outline text-sm ml-4"
                                >
                                    Voir
                                </Link>
                            </div>
                        </div>
                        <div v-else class="text-center py-12">
                            <CalendarIcon class="mx-auto h-12 w-12 text-gray-400" />
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun rendez-vous aujourd'hui</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Votre calendrier est clair pour aujourd'hui.
                            </p>
                        </div>
                    </Card>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <Card>
                        <template #header>
                            <h3 class="text-sm font-semibold text-gray-900">Actions rapides</h3>
                        </template>

                        <div class="space-y-2">
                            <Link :href="route('patients.create')" class="btn-outline w-full justify-center">
                                <UsersIcon class="h-5 w-5 mr-2" />
                                Ajouter un patient
                            </Link>
                            <Link :href="route('appointments.create')" class="btn-primary w-full justify-center">
                                <CalendarIcon class="h-5 w-5 mr-2" />
                                Planifier un rendez-vous
                            </Link>
                            <!-- <Link :href="route('appointments.calendar')" class="btn-outline w-full justify-center">
                                <CalendarIcon class="h-5 w-5 mr-2" />
                                Voir le calendrier
                            </Link> -->
                        </div>
                    </Card>

                    <!-- Upcoming Appointments -->
                    <Card>
                        <template #header>
                            <h3 class="text-sm font-semibold text-gray-900">À venir cette semaine</h3>
                        </template>

                        <div v-if="upcomingAppointments.length > 0" class="space-y-3">
                            <div
                                v-for="appointment in upcomingAppointments.slice(0, 5)"
                                :key="appointment.id"
                                class="text-sm"
                            >
                                <Link
                                    :href="route('appointments.show', appointment.id)"
                                    class="font-medium text-gray-900 hover:text-medicare-600"
                                >
                                    {{ appointment.patient.full_name }}
                                </Link>
                                <p class="text-gray-500 text-xs mt-1">
                                    {{ new Date(appointment.appointment_date).toLocaleDateString('en-US', {
                                        weekday: 'short',
                                        month: 'short',
                                        day: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    }) }}
                                </p>
                            </div>
                            <Link
                                :href="route('appointments.index')"
                                class="block text-sm text-medicare-600 hover:text-medicare-700 font-medium pt-2 border-t border-gray-200"
                            >
                                Voir tous →
                            </Link>
                        </div>
                        <div v-else class="text-center py-6 text-sm text-gray-500">
                            Aucun rendez-vous à venir
                        </div>
                    </Card>

                    <!-- Pending Follow-ups -->
                    <Card v-if="stats.pending_follow_ups > 0">
                        <template #header>
                            <h3 class="text-sm font-semibold text-gray-900">Pending Follow-ups</h3>
                        </template>

                        <div class="text-center py-4">
                            <p class="text-3xl font-bold text-orange-600">{{ stats.pending_follow_ups }}</p>
                            <p class="text-sm text-gray-500 mt-1">Patients need follow-up</p>
                            <Link
                                :href="route('medical-records.follow-ups')"
                                class="btn-outline w-full mt-4"
                            >
                                Voir les suivi
                            </Link>
                        </div>
                    </Card>

                    <!-- Recent Patients -->
                    <Card>
                        <template #header>
                            <h3 class="text-sm font-semibold text-gray-900">Patients récents</h3>
                        </template>

                        <div v-if="recentPatients.length > 0" class="space-y-3">
                            <div
                                v-for="patient in recentPatients.slice(0, 5)"
                                :key="patient.id"
                                class="flex items-center space-x-3"
                            >
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                        <span class="text-xs font-medium text-gray-600">
                                            {{ patient.first_name.charAt(0) }}{{ patient.last_name.charAt(0) }}
                                        </span>
                                    </div>
                                </div>
                                <Link
                                    :href="route('patients.show', patient.id)"
                                    class="flex-1 text-sm font-medium text-gray-900 hover:text-medicare-600 truncate"
                                >
                                    {{ patient.first_name }} {{ patient.last_name }}
                                </Link>
                            </div>
                            <Link
                                :href="route('patients.index')"
                                class="block text-sm text-medicare-600 hover:text-medicare-700 font-medium pt-2 border-t border-gray-200"
                            >
                                Tous les patients →
                            </Link>
                        </div>
                        <div v-else>
                            <p class="text-sm text-gray-500">Aucun patient récent.</p>
                        </div>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
