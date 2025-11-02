<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';

const props = defineProps({
    appointment: Object,
    patient: Object,
});

const form = useForm({
    patient_id: props.patient?.id || props.appointment?.patient.id || '',
    appointment_id: props.appointment?.id || '',
    chief_complaint: '',
    diagnosis: '',
    examination_notes: '',
    treatment_plan: '',
    prescription: '',
    lab_tests: '',
    follow_up_instructions: '',
    follow_up_date: '',
});

const submit = () => {
    form.post(route('medical-records.store'));
};
</script>

<template>
    <Head title="Create Medical Record" />

    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto space-y-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Ajouter un dossier médical</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Patient: {{ patient?.full_name || appointment?.patient.full_name }}
                </p>
            </div>

            <form @submit.prevent="submit">
                <Card>
                    <div class="space-y-6">
                        <!-- Chief Complaint -->
                        <div>
                            <label class="label">Problème principal *</label>
                            <textarea
                                v-model="form.chief_complaint"
                                rows="3"
                                class="input"
                                placeholder="Primary reason for visit..."
                                required
                            />
                            <div v-if="form.errors.chief_complaint" class="error">
                                {{ form.errors.chief_complaint }}
                            </div>
                        </div>

                        <!-- Examination Notes -->
                        <div>
                            <label class="label">Examen médical</label>
                            <textarea
                                v-model="form.examination_notes"
                                rows="4"
                                class="input"
                                placeholder="Physical examination findings..."
                            />
                            <div v-if="form.errors.examination_notes" class="error">
                                {{ form.errors.examination_notes }}
                            </div>
                        </div>

                        <!-- Diagnosis -->
                        <div>
                            <label class="label">Diagnostique</label>
                            <textarea
                                v-model="form.diagnosis"
                                rows="3"
                                class="input"
                                placeholder="Medical diagnosis..."
                            />
                            <div v-if="form.errors.diagnosis" class="error">
                                {{ form.errors.diagnosis }}
                            </div>
                        </div>

                        <!-- Treatment Plan -->
                        <div>
                            <label class="label">Plan de traitement</label>
                            <textarea
                                v-model="form.treatment_plan"
                                rows="4"
                                class="input"
                                placeholder="Recommended treatment..."
                            />
                            <div v-if="form.errors.treatment_plan" class="error">
                                {{ form.errors.treatment_plan }}
                            </div>
                        </div>

                        <!-- Prescription -->
                        <div>
                            <label class="label">Ordonnance</label>
                            <textarea
                                v-model="form.prescription"
                                rows="4"
                                class="input"
                                placeholder="Medications prescribed..."
                            />
                            <div v-if="form.errors.prescription" class="error">
                                {{ form.errors.prescription }}
                            </div>
                        </div>

                        <!-- Lab Tests -->
                        <div>
                            <label class="label">Tests de laboratoire</label>
                            <textarea
                                v-model="form.lab_tests"
                                rows="3"
                                class="input"
                                placeholder="Laboratory tests ordered..."
                            />
                            <div v-if="form.errors.lab_tests" class="error">
                                {{ form.errors.lab_tests }}
                            </div>
                        </div>

                        <!-- Follow-up -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Suivi</h3>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label class="label">Instructions de suivi</label>
                                    <textarea
                                        v-model="form.follow_up_instructions"
                                        rows="3"
                                        class="input"
                                        placeholder="Instructions for next visit..."
                                    />
                                </div>

                                <div>
                                    <label class="label">Date de suivi</label>
                                    <input
                                        v-model="form.follow_up_date"
                                        type="date"
                                        class="input"
                                    />
                                    <div v-if="form.errors.follow_up_date" class="error">
                                        {{ form.errors.follow_up_date }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <template #footer>
                        <div class="flex items-center justify-end space-x-4">
                            <Link :href="route('dashboard')" class="btn-outline">
                                Annuler
                            </Link>
                            <button
                                type="submit"
                                class="btn-primary"
                                :disabled="form.processing"
                            >
                                Ajouter le dossier médical
                            </button>
                        </div>
                    </template>
                </Card>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
