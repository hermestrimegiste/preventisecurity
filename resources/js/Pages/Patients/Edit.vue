<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';

const props = defineProps({
    patient: Object,
});

const form = useForm({
    first_name: props.patient.first_name,
    last_name: props.patient.last_name,
    date_of_birth: props.patient.date_of_birth,
    gender: props.patient.gender,
    email: props.patient.email,
    phone: props.patient.phone,
    address: props.patient.address,
    emergency_contact_name: props.patient.emergency_contact_name,
    emergency_contact_phone: props.patient.emergency_contact_phone,
    medical_history: props.patient.medical_history,
    allergies: props.patient.allergies,
    blood_group: props.patient.blood_group,
});

const submit = () => {
    form.patch(route('patients.update', props.patient.id));
};
</script>

<template>
    <Head :title="`Edit Patient: ${patient.full_name}`" />

    <AuthenticatedLayout>
        <div class="max-w-3xl mx-auto space-y-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Modifier le patient</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Modifier les informations du patient {{ patient.full_name }}
                </p>
            </div>

            <form @submit.prevent="submit">
                <Card>
                    <div class="space-y-6">
                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informations personnelles</h3>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="label">Prénom *</label>
                                    <input
                                        v-model="form.first_name"
                                        type="text"
                                        class="input"
                                        required
                                    />
                                    <div v-if="form.errors.first_name" class="error">
                                        {{ form.errors.first_name }}
                                    </div>
                                </div>

                                <div>
                                    <label class="label">Nom *</label>
                                    <input
                                        v-model="form.last_name"
                                        type="text"
                                        class="input"
                                        required
                                    />
                                    <div v-if="form.errors.last_name" class="error">
                                        {{ form.errors.last_name }}
                                    </div>
                                </div>

                                <div>
                                    <label class="label">Date de naissance *</label>
                                    <input
                                        v-model="form.date_of_birth"
                                        type="date"
                                        class="input"
                                        required
                                    />
                                    <div v-if="form.errors.date_of_birth" class="error">
                                        {{ form.errors.date_of_birth }}
                                    </div>
                                </div>

                                <div>
                                    <label class="label">Genre *</label>
                                    <select v-model="form.gender" class="input" required>
                                        <option value="">Select gender</option>
                                        <option value="male">Masculin</option>
                                        <option value="female">Feminin</option>
                                        <option value="other">Autre</option>
                                    </select>
                                    <div v-if="form.errors.gender" class="error">
                                        {{ form.errors.gender }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informations de contact</h3>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="label">Numéro de téléphone *</label>
                                    <input
                                        v-model="form.phone"
                                        type="tel"
                                        class="input"
                                        required
                                    />
                                    <div v-if="form.errors.phone" class="error">
                                        {{ form.errors.phone }}
                                    </div>
                                </div>

                                <div>
                                    <label class="label">Email</label>
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        class="input"
                                    />
                                    <div v-if="form.errors.email" class="error">
                                        {{ form.errors.email }}
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="label">Address</label>
                                    <textarea
                                        v-model="form.address"
                                        rows="3"
                                        class="input"
                                    />
                                    <div v-if="form.errors.address" class="error">
                                        {{ form.errors.address }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Contact d'urgence</h3>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="label">Nom</label>
                                    <input
                                        v-model="form.emergency_contact_name"
                                        type="text"
                                        class="input"
                                    />
                                </div>

                                <div>
                                    <label class="label">Numéro de téléphone</label>
                                    <input
                                        v-model="form.emergency_contact_phone"
                                        type="tel"
                                        class="input"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Medical Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Information médicale</h3>
                            <div class="space-y-6">
                                <div>
                                    <label class="label">Groupe sanguin</label>
                                    <select v-model="form.blood_group" class="input">
                                        <option value="">Sélectionner le groupe sanguin</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="label">Allergies</label>
                                    <textarea
                                        v-model="form.allergies"
                                        rows="3"
                                        class="input"
                                        placeholder="Liste des allergies connues..."
                                    />
                                </div>

                                <div>
                                    <label class="label">Histoire médicale</label>
                                    <textarea
                                        v-model="form.medical_history"
                                        rows="4"
                                        class="input"
                                        placeholder="Conditions antérieures, chirurgies, médicaments..."
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <template #footer>
                        <div class="flex items-center justify-end space-x-4">
                            <Link :href="route('patients.show', patient.id)" class="btn-outline">
                                Annuler
                            </Link>
                            <button
                                type="submit"
                                class="btn-primary"
                                :disabled="form.processing"
                            >
                                Mettre à jour le patient
                            </button>
                        </div>
                    </template>
                </Card>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
