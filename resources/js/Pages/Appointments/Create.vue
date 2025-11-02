<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';

defineProps({
    patients: Array,
    doctors: Array,
});

const form = useForm({
    patient_id: '',
    doctor_id: '',
    appointment_date: '',
    duration_minutes: 30,
    reason: '',
    notes: '',
});

const submit = () => {
    form.post(route('appointments.store'));
};
</script>

<template>
    <Head title="Créer un rendez-vous" />

    <AuthenticatedLayout>
        <div class="max-w-3xl mx-auto space-y-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Planifier un nouveau rendez-vous</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Remplissez les détails du rendez-vous ci-dessous
                </p>
            </div>

            <form @submit.prevent="submit">
                <Card>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label class="label">Patient *</label>
                                <select v-model="form.patient_id" class="input" required>
                                    <option value="">Sélectionner un patient</option>
                                    <option v-for="patient in patients" :key="patient.id" :value="patient.id">
                                        {{ patient.first_name }} {{ patient.last_name }}
                                    </option>
                                </select>
                                <div v-if="form.errors.patient_id" class="error">
                                    {{ form.errors.patient_id }}
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="label">Médecin *</label>
                                <select v-model="form.doctor_id" class="input" required>
                                    <option value="">Sélectionner un médecin</option>
                                    <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">
                                        <!-- Dr. {{ doctor.name }} -->
                                        {{ doctor.name }}
                                    </option>
                                </select>
                                <div v-if="form.errors.doctor_id" class="error">
                                    {{ form.errors.doctor_id }}
                                </div>
                            </div>

                            <div>
                                <label class="label">Date et heure *</label>
                                <input
                                    v-model="form.appointment_date"
                                    type="datetime-local"
                                    class="input"
                                    required
                                />
                                <div v-if="form.errors.appointment_date" class="error">
                                    {{ form.errors.appointment_date }}
                                </div>
                            </div>

                            <div>
                                <label class="label">Durée (minutes) *</label>
                                <select v-model="form.duration_minutes" class="input" required>
                                    <option :value="15">15 minutes</option>
                                    <option :value="30">30 minutes</option>
                                    <option :value="45">45 minutes</option>
                                    <option :value="60">1 heure</option>
                                    <option :value="90">1h30</option>
                                    <option :value="120">2 heures</option>
                                </select>
                                <div v-if="form.errors.duration_minutes" class="error">
                                    {{ form.errors.duration_minutes }}
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="label">Motif de la visite</label>
                                <input
                                    v-model="form.reason"
                                    type="text"
                                    class="input"
                                    placeholder="e.g., Annual checkup, Follow-up consultation..."
                                />
                                <div v-if="form.errors.reason" class="error">
                                    {{ form.errors.reason }}
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="label">Notes</label>
                                <textarea
                                    v-model="form.notes"
                                    rows="4"
                                    class="input"
                                    placeholder="Additional notes or special instructions..."
                                />
                                <div v-if="form.errors.notes" class="error">
                                    {{ form.errors.notes }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <template #footer>
                        <div class="flex items-center justify-end space-x-4">
                            <Link :href="route('appointments.index')" class="btn-outline">
                                Annuler
                            </Link>
                            <button
                                type="submit"
                                class="btn-primary"
                                :disabled="form.processing"
                            >
                                Créer le rendez-vous
                            </button>
                        </div>
                    </template>
                </Card>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
