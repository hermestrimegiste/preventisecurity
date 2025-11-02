<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

// Animation state
const animated = ref(false);

// Start animations when component is mounted
onMounted(() => {
    setTimeout(() => {
        animated.value = true;
    }, 100);
});
</script>

<template>
    <Head title="Bienvenue sur MediCare" />
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-white dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100 transition-colors duration-300">
        <!-- Animated background elements -->
        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 opacity-10 dark:opacity-5">
                <div class="absolute -top-1/2 -left-1/2 w-full h-full bg-gradient-to-br from-blue-200 to-transparent rounded-full filter blur-3xl animate-float"></div>
                <div class="absolute top-1/2 -right-1/4 w-1/2 h-1/2 bg-gradient-to-tl from-green-200 to-transparent rounded-full filter blur-3xl animate-float animation-delay-2000"></div>
                <div class="absolute -bottom-1/4 left-1/4 w-1/3 h-1/3 bg-gradient-to-tr from-purple-200 to-transparent rounded-full filter blur-3xl animate-float animation-delay-4000"></div>
            </div>
        </div>

        <div class="relative z-10 min-h-screen flex flex-col">
            <!-- Navigation -->
            <header class="container mx-auto px-4 py-6">
                <nav class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-teal-500 bg-clip-text text-transparent">MediCare</span>
                    </div>

                    <div v-if="canLogin" class="flex items-center space-x-4">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors duration-300 transform hover:scale-105"
                        >
                            Tableau de bord
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="px-4 py-2 rounded-lg text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-gray-800 transition-colors duration-300"
                            >
                                Connexion
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors duration-300 transform hover:scale-105"
                            >
                                S'inscrire
                            </Link>
                        </template>
                    </div>
                </nav>
            </header>

            <!-- Hero Section -->
            <main class="flex-grow flex items-center">
                <div class="container mx-auto px-4 py-16">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <!-- Left column -->
                        <div :class="['space-y-8 transform transition-all duration-1000',
                                   animated ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10']">
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                                Votre santé,<br>
                                <span class="bg-gradient-to-r from-blue-600 to-teal-500 bg-clip-text text-transparent">notre priorité</span>
                            </h1>

                            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300">
                                Gestion simplifiée des dossiers médicaux, prise de rendez-vous en ligne et suivi personnalisé pour une meilleure expérience de soins.
                            </p>

                            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                                <Link
                                    :href="route('register')"
                                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-teal-500 text-white rounded-lg font-semibold text-center transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl"
                                >
                                    Commencer maintenant
                                </Link>

                            </div>

                            <div class="flex items-center space-x-4 pt-4">
                                <div class="flex -space-x-2">
                                    <div class="w-10 h-10 rounded-full border-2 border-white dark:border-gray-800 bg-blue-500"></div>
                                    <div class="w-10 h-10 rounded-full border-2 border-white dark:border-gray-800 bg-green-500 -ml-2"></div>
                                    <div class="w-10 h-10 rounded-full border-2 border-white dark:border-gray-800 bg-purple-500 -ml-2"></div>
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <p class="font-semibold">+10 000 patients</p>
                                    <p>font déjà confiance à nos services</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right column -->
                        <div :class="['relative transform transition-all duration-1000 delay-200',
                                    animated ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10']">
                            <div class="relative">
                                <!-- Main card -->
                                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-2xl transform rotate-1">
                                    <div class="flex items-center space-x-3 mb-4">
                                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="flex items-center space-x-3 p-3 bg-blue-50 dark:bg-gray-700 rounded-lg">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Prochain rendez-vous</p>
                                                <p class="font-semibold">Dr. Martin Dupont</p>
                                                <p class="text-sm text-blue-600 dark:text-blue-400">Demain, 14h30</p>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4 transition-all duration-500 hover:scale-105">
                                            <div class="bg-green-50 dark:bg-green-900/30 p-3 rounded-lg">
                                                <p class="text-xs text-green-600 dark:text-green-400">Médecins</p>
                                                <p class="text-2xl font-bold">24/7</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Disponibles</p>
                                            </div>
                                            <div class="bg-blue-50 dark:bg-blue-900/30 p-3 rounded-lg">
                                                <p class="text-xs text-blue-600 dark:text-blue-400">Patients</p>
                                                <p class="text-2xl font-bold">10K+</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Satisfaits</p>
                                            </div>
                                        </div>

                                        <div class="bg-gradient-to-r from-blue-600 to-teal-500 text-white p-4 rounded-lg flex items-center justify-between">
                                            <div>
                                                <p class="text-sm">Votre dossier médical</p>
                                                <p class="text-xs opacity-80">Toujours à jour</p>
                                            </div>
                                            <button class="bg-white/20 p-2 rounded-full">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Decorative elements -->
                                <div class="absolute -z-10 w-full h-full -bottom-4 -right-4 bg-blue-100 dark:bg-blue-900/30 rounded-2xl"></div>
                                <div class="absolute -z-20 w-full h-full -bottom-8 -right-8 bg-blue-50 dark:bg-blue-900/10 rounded-2xl"></div>
                            </div>

                            <!-- Floating elements -->
                            <div class="absolute -top-8 -left-8 w-20 h-20 bg-yellow-400 rounded-full opacity-20 filter blur-xl animate-pulse"></div>
                            <div class="absolute -bottom-10 right-10 w-16 h-16 bg-blue-400 rounded-full opacity-20 filter blur-xl animate-pulse animation-delay-2000"></div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Features Section -->
            <section class="py-16 bg-white dark:bg-gray-900/50 mt-16">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">Des solutions adaptées à vos besoins</h2>
                        <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Découvrez comment MediCare peut transformer votre expérience de soins de santé</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div :class="['bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg transform transition-all duration-500 hover:scale-105',
                                    animated ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10']">
                            <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Dossier Médical Numérique</h3>
                            <p class="text-gray-600 dark:text-gray-400">Accédez à votre dossier médical complet en quelques clics, où que vous soyez.</p>
                        </div>

                        <div :class="['bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg transform transition-all duration-500 hover:scale-105 delay-100',
                                    animated ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10']">
                            <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Rendez-vous en Ligne</h3>
                            <p class="text-gray-600 dark:text-gray-400">Prenez rendez-vous avec nos professionnels de santé en quelques secondes.</p>
                        </div>

                        <div :class="['bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg transform transition-all duration-500 hover:scale-105 delay-200',
                                    animated ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10']">
                            <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Application Mobile</h3>
                            <p class="text-gray-600 dark:text-gray-400">Gérez votre santé depuis votre smartphone avec notre application dédiée.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="py-16 bg-gradient-to-r from-blue-600 to-teal-500 text-white">
                <div class="container mx-auto px-4 text-center">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">Prêt à commencer ?</h2>
                    <p class="text-xl mb-8 max-w-2xl mx-auto opacity-90">Rejoignez des milliers de patients qui font déjà confiance à MediCare pour leur santé.</p>
                    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <Link
                            :href="route('register')"
                            class="px-8 py-3 bg-white text-blue-600 rounded-lg font-semibold text-center transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl"
                        >
                            Créer un compte
                        </Link>

                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="bg-gray-900 text-gray-400 py-12">
                <div class="container mx-auto px-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div>
                            <div class="flex items-center space-x-2 mb-4">
                                <span class="text-2xl font-bold text-white">MediCare</span>
                            </div>
                            <p class="text-sm">Votre partenaire santé de confiance pour des soins accessibles et de qualité.</p>
                        </div>

                        <div>
                            <h4 class="text-white font-semibold mb-4">Liens rapides</h4>
                            <ul class="space-y-2">
                                <li><Link href="#" class="hover:text-white transition-colors">Accueil</Link></li>
                                <li><Link href="#" class="hover:text-white transition-colors">Services</Link></li>
                                <li><Link href="#" class="hover:text-white transition-colors">Médecins</Link></li>
                                <li><Link href="#" class="hover:text-white transition-colors">À propos</Link></li>
                                <li><Link href="#" class="hover:text-white transition-colors">Contact</Link></li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="text-white font-semibold mb-4">Services</h4>
                            <ul class="space-y-2">
                                <li><Link href="#" class="hover:text-white transition-colors">Médecine générale</Link></li>
                                <li><Link href="#" class="hover:text-white transition-colors">Spécialistes</Link></li>
                                <li><Link href="#" class="hover:text-white transition-colors">Urgences</Link></li>
                                <li><Link href="#" class="hover:text-white transition-colors">Téléconsultation</Link></li>
                                <li><Link href="#" class="hover:text-white transition-colors">Bilans de santé</Link></li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="text-white font-semibold mb-4">Contact</h4>
                            <ul class="space-y-2">
                                <li class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>123 Rue de la Santé, 75000 Lomé</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span>+228 91 91 55 20</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>contact@medicare.fr</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                        <p>&copy; 2023 MediCare. Tous droits réservés.</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>

<style>
@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

/* Responsive design */
@media (max-width: 768px) {
    .text-4xl {
        font-size: 2.25rem;
        line-height: 2.5rem;
    }

    .text-5xl {
        font-size: 2.5rem;
        line-height: 2.75rem;
    }

    .text-6xl {
        font-size: 3rem;
        line-height: 1;
    }

    .py-16 {
        padding-top: 4rem;
        padding-bottom: 4rem;
    }

    .px-4 {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .space-y-8 > :not([hidden]) ~ :not([hidden]) {
        --tw-space-y-reverse: 0;
        margin-top: calc(2rem * calc(1 - var(--tw-space-y-reverse)));
        margin-bottom: calc(2rem * var(--tw-space-y-reverse));
    }
}
</style>
