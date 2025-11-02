<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import SearchInput from '@/Components/SearchInput.vue';
import Pagination from '@/Components/Pagination.vue';
import { PlusIcon, UserIcon } from '@heroicons/vue/24/outline';

//import moment
import moment from 'moment';
import 'moment/locale/fr';
moment.locale('fr');


const props = defineProps({
    patients: Object,
    filters: Object,
});

const search = ref(props.filters.search || '');

const searchPatients = (value) => {
    router.get(
        route('patients.index'),
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    );
};
const calculateAge = (birthDate) => {
  return moment(birthDate).fromNow(true, true);
};
</script>

<template>
    <Head title="Patients" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Patients</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Gestion des patients
                    </p>
                </div>
                <Link :href="route('patients.create')" class="btn-primary">
                    <PlusIcon class="h-5 w-5 mr-2" />
                    Ajouter un patient
                </Link>
            </div>

            <Card>
                <div class="mb-4">
                    <SearchInput
                        v-model="search"
                        placeholder="Rechercher les patients par nom, email ou téléphone..."
                        @update:model-value="searchPatients"
                    />
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Patient
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Age
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Prochain rendez-vous
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="patient in patients.data" :key="patient.id" class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center">
                                            <UserIcon class="h-6 w-6 text-gray-400" />
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ patient.full_name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ patient.gender }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ patient.phone }}</div>
                                    <div class="text-sm text-gray-500">{{ patient.email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ calculateAge(patient.date_of_birth) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span v-if="patient.next_appointment">
                                        {{ patient.next_appointment.formatted_date_time }}
                                    </span>
                                    <span v-else class="text-gray-400">Aucun rendez-vous</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link
                                        :href="route('patients.show', patient.id)"
                                        class="text-medicare-600 hover:text-medicare-900 mr-4"
                                    >
                                        Voir
                                    </Link>
                                    <Link
                                        :href="route('patients.edit', patient.id)"
                                        class="text-gray-600 hover:text-gray-900"
                                    >
                                        Modifier
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="patients.data.length === 0" class="text-center py-12">
                    <UserIcon class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun patient trouvé</h3>
                    <p class="mt-1 text-sm text-gray-500">Commencez par créer un nouveau patient.</p>
                    <div class="mt-6">
                        <Link :href="route('patients.create')" class="btn-primary">
                            <PlusIcon class="h-5 w-5 mr-2" />
                            Ajouter un patient
                        </Link>
                    </div>
                </div>

                <div v-if="patients.data.length > 0" class="mt-6">
                    <Pagination :links="patients.links" />
                </div>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
