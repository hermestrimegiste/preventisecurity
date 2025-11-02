<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import { BuildingOfficeIcon, EnvelopeIcon, PhoneIcon, MapPinIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    organization: Object,
});

const form = useForm({
    name: props.organization.name,
    email: props.organization.email || '',
    phone: props.organization.phone || '',
    address: props.organization.address || '',
});

const submit = () => {
    form.patch(route('organization.update-settings'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Organization Settings" />

    <AuthenticatedLayout>
        <div class="max-w-3xl mx-auto space-y-6">
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Paramètres de l'organisation</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Gestion des paramètres de l'organisation
                </p>
            </div>

            <!-- Current Organization Info -->
            <Card>
                <template #header>
                    <div class="flex items-center">
                        <BuildingOfficeIcon class="h-6 w-6 text-gray-400 mr-2" />
                        <h2 class="text-lg font-semibold text-gray-900">Informations de l'organisation</h2>
                    </div>
                </template>

                <form @submit.prevent="submit">
                    <div class="space-y-6">
                        <!-- Organization Name -->
                        <div>
                            <label class="label">
                                <BuildingOfficeIcon class="h-4 w-4 inline mr-1" />
                                Nom de l'organisation *
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="input"
                                required
                                placeholder="Enter organization name"
                            />
                            <div v-if="form.errors.name" class="error">
                                {{ form.errors.name }}
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                Ce nom sera visible pour tous les membres de votre organisation.
                            </p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="label">
                                <EnvelopeIcon class="h-4 w-4 inline mr-1" />
                                Email
                            </label>
                            <input
                                v-model="form.email"
                                type="email"
                                class="input"
                                placeholder="organization@example.com"
                            />
                            <div v-if="form.errors.email" class="error">
                                {{ form.errors.email }}
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                Email de contact principal pour l'organisation.
                            </p>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="label">
                                <PhoneIcon class="h-4 w-4 inline mr-1" />
                                Numéro de téléphone
                            </label>
                            <input
                                v-model="form.phone"
                                type="tel"
                                class="input"
                                placeholder="+1 (555) 123-4567"
                            />
                            <div v-if="form.errors.phone" class="error">
                                {{ form.errors.phone }}
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                Numéro de téléphone de contact principal.
                            </p>
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="label">
                                <MapPinIcon class="h-4 w-4 inline mr-1" />
                                Adresse
                            </label>
                            <textarea
                                v-model="form.address"
                                rows="3"
                                class="input"
                                placeholder="123 Medical Street&#10;Health City, HC 12345"
                            />
                            <div v-if="form.errors.address" class="error">
                                {{ form.errors.address }}
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                Adresse physique de l'organisation.
                            </p>
                        </div>
                    </div>

                    <template id="footer">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500">
                                Mis à jour le: {{ new Date(organization.updated_at).toLocaleDateString() }}
                            </p>
                            <div class="flex space-x-4">
                                <Link :href="route('dashboard')" class="btn-outline">
                                    Annuler
                                </Link>
                                <button
                                    type="submit"
                                    class="btn-primary"
                                    :disabled="form.processing"
                                >
                                    <span v-if="form.processing">Enregistrement...</span>
                                    <span v-else>Enregistrer les modifications</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </form>
            </Card>

            <!-- Additional Settings -->
            <Card>
                <template #header>
                    <h2 class="text-lg font-semibold text-gray-900">Paramètres supplémentaires</h2>
                </template>

                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Organization ID</p>
                            <p class="text-sm text-gray-500">{{ organization.id }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Slug</p>
                            <p class="text-sm text-gray-500">{{ organization.slug }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-3">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Status</p>
                            <p class="text-sm text-gray-500">
                                <template v-if="organization.is_active">
                                    <span class="badge-green">Active</span>
                                </template>
                                <template v-else>
                                    <span class="badge-red">Inactive</span>
                                </template>
                            </p>
                        </div>
                    </div>
                </div>
            </Card>

            <!-- Members Link -->
            <Card>
                <template #header>
                    <h2 class="text-lg font-semibold text-gray-900">Gestion des membres</h2>
                </template>

                <div class="py-4">
                    <p class="text-sm text-gray-600 mb-4">
                        Gestion des membres et de leur accès à votre organisation.
                    </p>
                    <Link :href="route('organization.members')" class="btn-primary">
                        Gestion des membres
                    </Link>
                </div>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
