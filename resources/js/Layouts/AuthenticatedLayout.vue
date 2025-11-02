<script setup>
import { ref, computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
    Menu,
    MenuButton,
    MenuItems,
    MenuItem,
} from '@headlessui/vue';
import {
    Bars3Icon,
    HomeIcon,
    UsersIcon,
    CalendarIcon,
    DocumentTextIcon,
    Cog6ToothIcon,
    XMarkIcon,
    ChevronDownIcon,
    ArrowRightOnRectangleIcon,
    UserCircleIcon,
} from '@heroicons/vue/24/outline';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import OrganizationSwitcher from '@/Components/OrganizationSwitcher.vue';

const sidebarOpen = ref(false);
const page = usePage();

const user = computed(() => page.props.auth.user);
const organizations = computed(() => page.props.auth.user.organizations || []);
const currentOrganizationId = computed(() => page.props.auth.user.current_organization_id);

const navigation = [
    { name: 'Dashboard', href: 'dashboard', icon: HomeIcon },
    { name: 'Patients', href: 'patients.index', icon: UsersIcon },
    { name: 'Rendez-vous', href: 'appointments.index', icon: CalendarIcon },
    { name: 'Suivi', href: 'medical-records.follow-ups', icon: DocumentTextIcon },
];

const isCurrentRoute = (routeName) => {
    return route().current(routeName + '*');
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <!-- Mobile sidebar -->
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog as="div" class="relative z-50 lg:hidden" @close="sidebarOpen = false">
                <TransitionChild
                    as="template"
                    enter="transition-opacity ease-linear duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="transition-opacity ease-linear duration-300"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-gray-900/80" />
                </TransitionChild>

                <div class="fixed inset-0 flex">
                    <TransitionChild
                        as="template"
                        enter="transition ease-in-out duration-300 transform"
                        enter-from="-translate-x-full"
                        enter-to="translate-x-0"
                        leave="transition ease-in-out duration-300 transform"
                        leave-from="translate-x-0"
                        leave-to="-translate-x-full"
                    >
                        <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                            <TransitionChild
                                as="template"
                                enter="ease-in-out duration-300"
                                enter-from="opacity-0"
                                enter-to="opacity-100"
                                leave="ease-in-out duration-300"
                                leave-from="opacity-100"
                                leave-to="opacity-0"
                            >
                                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                                    <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                                        <span class="sr-only">Close sidebar</span>
                                        <XMarkIcon class="h-6 w-6 text-white" />
                                    </button>
                                </div>
                            </TransitionChild>
                            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
                                <div class="flex h-16 shrink-0 items-center">
                                    <ApplicationLogo class="h-8 w-auto text-medicare-600" />
                                </div>
                                <nav class="flex flex-1 flex-col">
                                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                        <li>
                                            <ul role="list" class="-mx-2 space-y-1">
                                                <li v-for="item in navigation" :key="item.name">
                                                    <Link
                                                        :href="route(item.href)"
                                                        :class="[
                                                            isCurrentRoute(item.href)
                                                                ? 'bg-gray-50 text-medicare-600'
                                                                : 'text-gray-700 hover:text-medicare-600 hover:bg-gray-50',
                                                            'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-colors',
                                                        ]"
                                                    >
                                                        <component
                                                            :is="item.icon"
                                                            :class="[
                                                                isCurrentRoute(item.href)
                                                                    ? 'text-medicare-600'
                                                                    : 'text-gray-400 group-hover:text-medicare-600',
                                                                'h-6 w-6 shrink-0',
                                                            ]"
                                                        />
                                                        {{ item.name }}
                                                    </Link>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
            <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-blue-100 px-6 pb-4">
                <div class="flex h-16 shrink-0 items-center">
                    <ApplicationLogo class="h-8 w-auto text-medicare-600" />
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li v-for="item in navigation" :key="item.name">
                                    <Link
                                        :href="route(item.href)"
                                        :class="[
                                            isCurrentRoute(item.href)
                                                ? 'bg-gray-50 text-medicare-600'
                                                : 'text-gray-700 hover:text-medicare-600 hover:bg-gray-50',
                                            'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-colors',
                                        ]"
                                    >
                                        <component
                                            :is="item.icon"
                                            :class="[
                                                isCurrentRoute(item.href)
                                                    ? 'text-medicare-600'
                                                    : 'text-gray-400 group-hover:text-medicare-600',
                                                'h-6 w-6 shrink-0',
                                            ]"
                                        />
                                        {{ item.name }}
                                    </Link>
                                </li>
                            </ul>
                        </li>
                        <li class="mt-auto">
                            <Link
                                :href="route('organization.settings')"
                                class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-medicare-600 transition-colors"
                            >
                                <Cog6ToothIcon class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-medicare-600" />
                                Paramètres
                            </Link>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="lg:pl-64">
            <!-- Top bar -->
            <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <button
                    type="button"
                    class="-m-2.5 p-2.5 text-gray-700 lg:hidden"
                    @click="sidebarOpen = true"
                >
                    <span class="sr-only">Menu</span>
                    <Bars3Icon class="h-6 w-6" />
                </button>

                <div class="h-6 w-px bg-gray-200 lg:hidden" />

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <div class="relative flex flex-1"></div>
                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <!-- Organization Switcher -->
                        <OrganizationSwitcher
                            v-if="organizations.length > 0"
                            :organizations="organizations"
                            :current-organization-id="currentOrganizationId"
                        />

                        <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200" />

                        <!-- User Menu -->
                        <Menu as="div" class="relative">
                            <MenuButton class="-m-1.5 flex items-center p-1.5 hover:bg-gray-50 rounded-lg transition-colors">
                                <span class="sr-only">Menu Utilisateur</span>
                                <div class="h-8 w-8 rounded-full bg-medicare-100 flex items-center justify-center">
                                    <UserCircleIcon class="h-5 w-5 text-medicare-600" />
                                </div>
                                <span class="hidden lg:flex lg:items-center">
                                    <span class="ml-4 text-sm font-semibold leading-6 text-gray-900">
                                        {{ user.name }}
                                    </span>
                                    <ChevronDownIcon class="ml-2 h-5 w-5 text-gray-400" />
                                </span>
                            </MenuButton>
                            <transition
                                enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <MenuItems class="absolute right-0 z-10 mt-2.5 w-64 origin-top-right rounded-lg bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                                    <MenuItem v-slot="{ active }">
                                        <Link
                                            :href="route('profile.edit')"
                                            :class="[
                                                active ? 'bg-gray-50' : '',
                                                'block px-3 py-2 text-sm leading-6 text-gray-900 transition-colors',
                                            ]"
                                        >
                                            Votre profil
                                        </Link>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <Link
                                            :href="route('organization.settings')"
                                            :class="[
                                                active ? 'bg-gray-50' : '',
                                                'block px-3 py-2 text-sm leading-6 text-gray-900 transition-colors',
                                            ]"
                                        >
                                            Paramètres de l'organisation
                                        </Link>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <button
                                            @click="logout"
                                            :class="[
                                                active ? 'bg-gray-50' : '',
                                                'flex w-full items-center px-3 py-2 text-sm leading-6 text-gray-900 transition-colors',
                                            ]"
                                        >
                                            <ArrowRightOnRectangleIcon class="h-5 w-5 mr-2 text-gray-400" />
                                            Se deconnecter
                                        </button>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>

            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
