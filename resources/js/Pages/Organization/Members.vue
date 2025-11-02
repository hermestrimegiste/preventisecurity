<script setup>
import { ref } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import Modal from '@/Components/Modal.vue';
import Badge from '@/Components/Badge.vue';
import { PlusIcon, TrashIcon, UserCircleIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    organization: Object,
    members: Array,
});

const showInviteModal = ref(false);

const inviteForm = useForm({
    email: '',
    role: 'doctor',
});

const inviteMember = () => {
    inviteForm.post(route('organization.invite'), {
        preserveScroll: true,
        onSuccess: () => {
            showInviteModal.value = false;
            inviteForm.reset();
        },
    });
};

const removeMember = (user) => {
    if (confirm(`Are you sure you want to remove ${user.name} from ${props.organization.name}?`)) {
        router.delete(route('organization.remove-member', user.id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Team Members" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Membres de l'organisation</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Gestion des membres de l'organisation {{ organization.name }}
                    </p>
                </div>
                <button @click="showInviteModal = true" class="btn-primary">
                    <PlusIcon class="h-5 w-5 mr-2" />
                    Inviter un membre
                </button>
            </div>

            <!-- Members List -->
            <Card>
                <template #header>
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Membres actifs ({{ members.length }})
                        </h2>
                    </div>
                </template>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Membre
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="member in members" :key="member.id" class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-medicare-100 flex items-center justify-center">
                                                <UserCircleIcon class="h-6 w-6 text-medicare-600" />
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ member.name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ member.email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-1">
                                        <Badge
                                            v-for="role in member.roles"
                                            :key="role.id"
                                            :variant="role.name === 'admin' ? 'blue' : 'green'"
                                        >
                                            {{ role.name }}
                                        </Badge>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button
                                        @click="removeMember(member)"
                                        class="text-red-600 hover:text-red-900 transition-colors"
                                        title="Remove member"
                                    >
                                        <TrashIcon class="h-5 w-5" />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="members.length === 0" class="text-center py-12">
                    <UserCircleIcon class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun membre</h3>
                    <p class="mt-1 text-sm text-gray-500">Commencez par inviter un membre.</p>
                    <div class="mt-6">
                        <button @click="showInviteModal = true" class="btn-primary">
                            <PlusIcon class="h-5 w-5 mr-2" />
                            Inviter un membre
                        </button>
                    </div>
                </div>
            </Card>

            <!-- Roles Information -->
            <Card>
                <template #header>
                    <h3 class="text-lg font-semibold text-gray-900">Permissions des rôles</h3>
                </template>

                <div class="space-y-4">
                    <div class="border-l-4 border-blue-500 pl-4">
                        <div class="flex items-center mb-2">
                            <Badge variant="blue">Admin</Badge>
                            <span class="ml-2 text-sm font-medium text-gray-900">Administrateur</span>
                        </div>
                        <p class="text-sm text-gray-600">
                            Accès complet aux paramètres de l'organisation, peut inviter et supprimer des membres,
                            gérer tous les patients, rendez-vous et dossiers médicaux.
                        </p>
                    </div>

                    <div class="border-l-4 border-green-500 pl-4">
                        <div class="flex items-center mb-2">
                            <Badge variant="green">Médecin</Badge>
                            <span class="ml-2 text-sm font-medium text-gray-900">Médecin/Physician</span>
                        </div>
                        <p class="text-sm text-gray-600">
                            Peut gérer les patients, créer et afficher les rendez-vous, créer des dossiers médicaux,
                            mais ne peut pas accéder aux paramètres de l'organisation ou inviter des membres.
                        </p>
                    </div>
                </div>
            </Card>
        </div>

        <!-- Invite Modal -->
        <Modal :show="showInviteModal" @close="showInviteModal = false" title="Invite Team Member">
            <form @submit.prevent="inviteMember">
                <div class="space-y-4">
                    <div>
                        <label class="label">Email Address *</label>
                        <input
                            v-model="inviteForm.email"
                            type="email"
                            class="input"
                            placeholder="colleague@example.com"
                            required
                            autofocus
                        />
                        <div v-if="inviteForm.errors.email" class="error">
                            {{ inviteForm.errors.email }}
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            L'utilisateur doit déjà avoir un compte dans le système.
                        </p>
                    </div>

                    <div>
                        <label class="label">Role *</label>
                        <select v-model="inviteForm.role" class="input" required>
                            <option value="admin">Admin - Accès complet</option>
                            <option value="doctor">Doctor - Accès clinique</option>
                        </select>
                        <div v-if="inviteForm.errors.role" class="error">
                            {{ inviteForm.errors.role }}
                        </div>
                    </div>
                </div>

                <template id="footer">
                    <div class="flex items-center justify-end space-x-4">
                        <button @click="showInviteModal = false" type="button" class="btn-outline">
                            Annuler
                        </button>
                        <button
                            type="submit"
                            class="btn-primary"
                            :disabled="inviteForm.processing"
                        >
                            <span v-if="inviteForm.processing">Envoi...</span>
                            <span v-else>Envoyer l'invitation</span>
                        </button>
                    </div>
                </template>
            </form>
        </Modal>
    </AuthenticatedLayout>
</template>
