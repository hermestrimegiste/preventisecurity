<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import Badge from '@/Components/Badge.vue';
import SearchInput from '@/Components/SearchInput.vue';
import Pagination from '@/Components/Pagination.vue';
import {
    DocumentTextIcon,
    FunnelIcon,
    CalendarIcon,
    ExclamationTriangleIcon,
} from '@heroicons/vue/24/outline';

const props = defineProps({
    records: Object,
    filters: Object,
    doctors: Array,
});

const search = ref(props.filters.search || '');
const selectedDoctor = ref(props.filters.doctor_id || '');
const dateFrom = ref(props.filters.date_from || '');
const dateTo = ref(props.filters.date_to || '');

const applyFilters = () => {
    router.get(
        route('medical-records.index'),
        {
            search: search.value,
            doctor_id: selectedDoctor.value,
            date_from: dateFrom.value,
            date_to: dateTo.value,
        },
        {
            preserveState: true,
            replace: true,
        }
    );
};

const clearFilters = () => {
    search.value = '';
    selectedDoctor.value = '';
    dateFrom.value = '';
    dateTo.value = '';
    applyFilters();
};

const searchRecords = (value) => {
    search.value = value;
    applyFilters();
};
</script>

<template>
    <Head title="Dossiers médicaux" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dossiers médicaux</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Parcourez et recherchez tous les dossiers médicaux
                    </p>
                </div>
                <Link :href="route('medical-records.follow-ups')" class="btn-primary">
                    <ExclamationTriangleIcon class="h-5 w-5 mr-2" />
                    Voir les suivis
                </Link>
            </div>

            <!-- Filters -->
            <Card>
                <template #header>
                    <div class="flex items-center">
                        <FunnelIcon class="h-5 w-5 text-gray-400 mr-2" />
                        <h2 class="text-lg font-semibold text-gray-900">Filtres</h2>
                    </div>
                </template>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="label">Search</label>
                        <SearchInput
                            v-model="search"
                            placeholder="Rechercher par diagnostic, motif ou patient..."
                            @update:model-value="searchRecords"
                        />
                    </div>

                    <div>
                        <label class="label">Doctor</label>
                        <select v-model="selectedDoctor" class="input" @change="applyFilters">
                            <option value="">Tous les médecins</option>
                            <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">
                                Dr. {{ doctor.name }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="label">Période</label>
                        <div class="flex space-x-2">
                            <input
                                v-model="dateFrom"
                                type="date"
                                class="input"
                                @change="applyFilters"
                            />
                            <input
                                v-model="dateTo"
                                type="date"
                                class="input"
                                @change="applyFilters"
                            />
                        </div>
                    </div>
                </div>

                <div v-if="search || selectedDoctor || dateFrom || dateTo" class="mt-4 pt-4 border-t border-gray-200">
                    <button @click="clearFilters" class="text-sm text-medicare-600 hover:text-medicare-700">
                        Réinitialiser les filtres
                    </button>
                </div>
            </Card>

            <!-- Records List -->
            <Card>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Patient
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Médecin
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Motif de consultation
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Diagnostic
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Suivi
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="record in records.data" :key="record.id" class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <Link
                                        :href="route('patients.show', record.patient.id)"
                                        class="text-sm font-medium text-medicare-600 hover:text-medicare-900"
                                    >
                                        {{ record.patient.full_name }}
                                    </Link>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Dr. {{ record.doctor.name }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate">
                                        {{ record.chief_complaint }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate">
                                        {{ record.diagnosis || 'Not specified' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ new Date(record.created_at).toLocaleDateString() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <Badge
                                        v-if="record.follow_up_date"
                                        :variant="record.is_follow_up_overdue ? 'red' : 'blue'"
                                    >
                                        {{ record.formatted_follow_up_date }}
                                    </Badge>
                                    <span v-else class="text-sm text-gray-400">None</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link
                                        :href="route('medical-records.show', record.id)"
                                        class="text-medicare-600 hover:text-medicare-900"
                                    >
                                        Voir
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="records.data.length === 0" class="text-center py-12">
                    <DocumentTextIcon class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun dossier médical trouvé</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Essayez d'ajuster votre recherche ou vos critères de filtrage.
                    </p>
                </div>

                <div v-if="records.data.length > 0" class="mt-6">
                    <Pagination :links="records.links" />
                </div>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
