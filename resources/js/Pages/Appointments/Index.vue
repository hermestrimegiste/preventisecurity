<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import Pagination from '@/Components/Pagination.vue';
import { PlusIcon, CalendarIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    appointments: Object,
    doctors: Array,
    filters: Object,
});

const selectedStatus = ref(props.filters.status || '');
const selectedDoctor = ref(props.filters.doctor_id || '');

const filterAppointments = () => {
    router.get(
        route('appointments.index'),
        {
            status: selectedStatus.value,
            doctor_id: selectedDoctor.value,
        },
        {
            preserveState: true,
            replace: true,
        }
    );
};
</script>

<template>
    <Head title="Appointments" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Rendez-vous</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Gérer les rendez-vous des patients
                    </p>
                </div>
                <div class="flex space-x-4">
                    <Link :href="route('appointments.calendar')" class="btn-outline">
                        <CalendarIcon class="h-5 w-5 mr-2" />
                        Vue Calendrier
                    </Link>
                    <Link :href="route('appointments.create')" class="btn-primary">
                        <PlusIcon class="h-5 w-5 mr-2" />
                        Nouveau Rendez-vous
                    </Link>
                </div>
            </div>

            <Card>
                <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="label">Filtrer par statut</label>
                        <select v-model="selectedStatus" class="input" @change="filterAppointments">
                            <option value="">Tous les statuts</option>
                            <option value="scheduled">Planifié</option>
                            <option value="completed">Terminé</option>
                            <option value="cancelled">Annulé</option>
                            <option value="no_show">Pas venu</option>
                        </select>
                    </div>
                    <div>
                        <label class="label">Filtrer par médecin</label>
                        <select v-model="selectedDoctor" class="input" @change="filterAppointments">
                            <option value="">Tous les médecins</option>
                            <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">
                                <!-- Dr. {{ doctor.name }} -->
                                {{ doctor.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Patient
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Docteur
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date & Heure
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Durée
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="appointment in appointments.data" :key="appointment.id" class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <Link
                                        :href="route('patients.show', appointment.patient.id)"
                                        class="text-sm font-medium text-medicare-600 hover:text-medicare-900"
                                    >
                                        {{ appointment.patient.first_name }} {{ appointment.patient.last_name }}
                                    </Link>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <!-- Dr. {{ appointment.doctor.name }} -->
                                    {{ appointment.doctor.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ appointment.formatted_date_time }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ appointment.duration_minutes }} min
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <StatusBadge :status="appointment.status" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link
                                        :href="route('appointments.show', appointment.id)"
                                        class="text-medicare-600 hover:text-medicare-900"
                                    >
                                        Voir
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="appointments.data.length === 0" class="text-center py-12">
                    <CalendarIcon class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun rendez-vous trouvé</h3>
                    <p class="mt-1 text-sm text-gray-500">Commencez par créer un nouveau rendez-vous.</p>
                    <div class="mt-6">
                        <Link :href="route('appointments.create')" class="btn-primary">
                            <PlusIcon class="h-5 w-5 mr-2" />
                            Nouveau rendez-vous
                        </Link>
                    </div>
                </div>

                <div v-if="appointments.data.length > 0" class="mt-6">
                    <Pagination :links="appointments.links" />
                </div>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
