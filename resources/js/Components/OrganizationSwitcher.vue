<script setup>
import { router } from '@inertiajs/vue3';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import { ChevronUpDownIcon, CheckIcon, BuildingOfficeIcon } from '@heroicons/vue/20/solid';

defineProps({
    organizations: {
        type: Array,
        required: true,
    },
    currentOrganizationId: {
        type: Number,
        required: true,
    },
});

const switchOrganization = (organizationId) => {
    router.post(
        route('organization.switch', organizationId),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                // Optional: Show success message
                console.log('Organization switched successfully');
            },
        }
    );
};

const currentOrganization = (organizations, currentOrganizationId) => {
    return organizations.find(org => org.id === currentOrganizationId);
};
</script>

<template>
    <Menu v-if="organizations.length > 1" as="div" class="relative inline-block text-left">
        <MenuButton class="inline-flex w-full justify-between items-center gap-x-2 rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
            <BuildingOfficeIcon class="h-5 w-5 text-gray-400 flex-shrink-0" />
            <span class="truncate max-w-[150px]">
                {{ currentOrganization(organizations, currentOrganizationId)?.name || 'Select Organization' }}
            </span>
            <ChevronUpDownIcon class="h-5 w-5 text-gray-400 flex-shrink-0" />
        </MenuButton>

        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <MenuItems class="absolute right-0 z-10 mt-2 w-64 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                <div class="py-1">
                    <div class="px-4 py-2 border-b border-gray-200">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Changer d'organisation
                        </p>
                    </div>
                    <MenuItem
                        v-for="organization in organizations"
                        :key="organization.id"
                        v-slot="{ active }"
                    >
                        <button
                            type="button"
                            :class="[
                                active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
                                'group flex w-full items-center px-4 py-3 text-sm transition-colors',
                            ]"
                            @click="switchOrganization(organization.id)"
                        >
                            <CheckIcon
                                v-if="organization.id === currentOrganizationId"
                                class="mr-3 h-5 w-5 text-medicare-600 flex-shrink-0"
                            />
                            <span :class="organization.id === currentOrganizationId ? '' : 'ml-8'" class="flex-1 text-left">
                                <span class="block font-medium truncate">{{ organization.name }}</span>
                                <span class="block text-xs text-gray-500 truncate">{{ organization.slug }}</span>
                            </span>
                        </button>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
    <div v-else-if="organizations.length === 1" class="inline-flex items-center gap-x-2 px-3 py-2 text-sm font-semibold text-gray-900">
        <BuildingOfficeIcon class="h-5 w-5 text-gray-400" />
        <span class="truncate">
            {{ organizations[0]?.name }}
        </span>
    </div>
</template>
