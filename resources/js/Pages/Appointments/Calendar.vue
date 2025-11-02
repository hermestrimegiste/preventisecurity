<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import { Calendar } from 'v-calendar';
// import 'v-calendar/dist/style.css';
import {
    PlusIcon,
    ChevronLeftIcon,
    ChevronRightIcon,
    ListBulletIcon,
} from '@heroicons/vue/24/outline';

const props = defineProps({
    appointments: Array,
    currentMonth: String,
});

const selectedDate = ref(new Date());
const viewMode = ref('month'); // month, week, day

// Filter appointments for selected date
const selectedDateAppointments = computed(() => {
    const dateStr = selectedDate.value.toISOString().split('T')[0];
    return props.appointments.filter(appointment => {
        const appointmentDate = new Date(appointment.appointment_date).toISOString().split('T')[0];
        return appointmentDate === dateStr;
    });
});

// Create calendar attributes for v-calendar
const calendarAttributes = computed(() => {
    return props.appointments.map(appointment => {
        const statusColors = {
            scheduled: 'blue',
            completed: 'green',
            cancelled: 'red',
            no_show: 'yellow',
        };

        return {
            key: appointment.id,
            dates: new Date(appointment.appointment_date),
            dot: {
                color: statusColors[appointment.status] || 'gray',
            },
            popover: {
                label: `${appointment.patient.full_name} - ${new Date(appointment.appointment_date).toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit'
                })}`,
            },
        };
    });
});

// Get appointments by hour for day view
const appointmentsByHour = computed(() => {
    const hours = {};
    for (let i = 0; i < 24; i++) {
        hours[i] = [];
    }

    selectedDateAppointments.value.forEach(appointment => {
        const hour = new Date(appointment.appointment_date).getHours();
        hours[hour].push(appointment);
    });

    return hours;
});

const onDateSelect = (date) => {
    selectedDate.value = date;
};

const navigateMonth = (direction) => {
    const newDate = new Date(selectedDate.value);
    newDate.setMonth(newDate.getMonth() + direction);
    selectedDate.value = newDate;

    // Load appointments for new month
    loadAppointments(newDate);
};

const loadAppointments = (date) => {
    const startOfMonth = new Date(date.getFullYear(), date.getMonth(), 1);
    const endOfMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0);

    router.get(
        route('appointments.calendar'),
        {
            start: startOfMonth.toISOString().split('T')[0],
            end: endOfMonth.toISOString().split('T')[0],
        },
        {
            preserveState: true,
            replace: true,
        }
    );
};

const goToToday = () => {
    selectedDate.value = new Date();
};
</script>

<template>
    <Head title="Calendrier des rendez-vous" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Calendrier des rendez-vous</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Visualisez et gérez les rendez-vous par date
                    </p>
                </div>
                <div class="flex space-x-4">
                    <Link :href="route('appointments.index')" class="btn-outline">
                        <ListBulletIcon class="h-5 w-5 mr-2" />
                        Vue liste
                    </Link>
                    <Link :href="route('appointments.create')" class="btn-primary">
                        <PlusIcon class="h-5 w-5 mr-2" />
                        Nouveau rendez-vous
                    </Link>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Calendar -->
                <div class="lg:col-span-2">
                    <Card>
                        <template #header>
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900">
                                    {{ selectedDate.toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' }) }}
                                </h2>
                                <div class="flex items-center space-x-2">
                                    <button
                                        @click="goToToday"
                                        class="btn-outline text-sm"
                                    >
                                        Aujourd'hui
                                    </button>
                                    <button
                                        @click="navigateMonth(-1)"
                                        class="p-2 hover:bg-gray-100 rounded-lg transition-colors"
                                    >
                                        <ChevronLeftIcon class="h-5 w-5" />
                                    </button>
                                    <button
                                        @click="navigateMonth(1)"
                                        class="p-2 hover:bg-gray-100 rounded-lg transition-colors"
                                    >
                                        <ChevronRightIcon class="h-5 w-5" />
                                    </button>
                                </div>
                            </div>
                        </template>

                        <Calendar
                            v-model="selectedDate"
                            :attributes="calendarAttributes"
                            @dayclick="onDateSelect"
                            expanded
                            borderless
                            transparent
                            class="w-full"
                        />

                        <!-- Legend -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-center space-x-6 text-sm">
                                <div class="flex items-center">
                                    <div class="h-3 w-3 rounded-full bg-blue-500 mr-2"></div>
                                    <span class="text-gray-600">Planifié</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="h-3 w-3 rounded-full bg-green-500 mr-2"></div>
                                    <span class="text-gray-600">Terminé</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="h-3 w-3 rounded-full bg-red-500 mr-2"></div>
                                    <span class="text-gray-600">Annulé</span>
                                </div>
                            </div>
                        </div>
                    </Card>
                </div>

                <!-- Selected Date Appointments -->
                <div>
                    <Card>
                        <template #header>
                            <h2 class="text-lg font-semibold text-gray-900">
                                {{ selectedDate.toLocaleDateString('fr-FR', {
                                    weekday: 'long',
                                    month: 'long',
                                    day: 'numeric'
                                }) }}
                            </h2>
                        </template>

                        <div v-if="selectedDateAppointments.length > 0" class="space-y-4 max-h-[600px] overflow-y-auto">
                            <div
                                v-for="appointment in selectedDateAppointments"
                                :key="appointment.id"
                                class="border-l-4 pl-4 py-3 hover:bg-gray-50 rounded-r-lg transition-colors"
                                :class="{
                                    'border-blue-500': appointment.status === 'scheduled',
                                    'border-green-500': appointment.status === 'completed',
                                    'border-red-500': appointment.status === 'cancelled',
                                    'border-yellow-500': appointment.status === 'no_show',
                                }"
                            >
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 truncate">
                                            {{ appointment.patient.full_name }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Dr. {{ appointment.doctor.name }}
                                        </p>
                                        <div class="flex items-center mt-2 space-x-2">
                                            <p class="text-sm font-medium text-medicare-600">
                                                {{ new Date(appointment.appointment_date).toLocaleTimeString('en-US', {
                                                    hour: '2-digit',
                                                    minute: '2-digit'
                                                }) }}
                                            </p>
                                            <span class="text-gray-400">•</span>
                                            <p class="text-sm text-gray-500">
                                                {{ appointment.duration_minutes }} min
                                            </p>
                                        </div>
                                        <p v-if="appointment.reason" class="text-sm text-gray-600 mt-2 line-clamp-2">
                                            {{ appointment.reason }}
                                        </p>
                                        <StatusBadge :status="appointment.status" class="mt-2" />
                                    </div>
                                </div>
                                <Link
                                    :href="route('appointments.show', appointment.id)"
                                    class="btn-outline text-sm mt-3 w-full"
                                >
                                    Voir les détails
                                </Link>
                            </div>
                        </div>

                        <div v-else class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <ListBulletIcon class="h-8 w-8 text-gray-400" />
                            </div>
                            <h3 class="text-sm font-medium text-gray-900">Aucun rendez-vous</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Aucun rendez-vous prévu pour cette date
                            </p>
                            <Link
                                :href="route('appointments.create')"
                                class="btn-primary text-sm mt-4"
                            >
                                <PlusIcon class="h-4 w-4 mr-2" />
                                Planifier un rendez-vous
                            </Link>
                        </div>
                    </Card>

                    <!-- Quick Stats -->
                    <Card class="mt-6">
                        <template #header>
                            <h3 class="text-sm font-semibold text-gray-900">Statistiques rapides</h3>
                        </template>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Total ce mois-ci</span>
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ appointments.length }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Date sélectionnée</span>
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ selectedDateAppointments.length }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-600">Planifiés</span>
                                <span class="text-sm font-semibold text-blue-600">
                                    {{ appointments.filter(a => a.status === 'scheduled').length }}
                                </span>
                            </div>
                        </div>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
:deep(.vc-container) {
    --vc-bg: theme('colors.white');
    --vc-border: theme('colors.gray.200');
    --vc-focus-ring: theme('colors.medicare.500');
    font-family: inherit;
}

:deep(.vc-day-content:hover) {
    background-color: theme('colors.medicare.50');
}

:deep(.vc-highlight) {
    background-color: theme('colors.medicare.500') !important;
}
</style>
