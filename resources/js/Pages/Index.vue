<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="vCISO - Auto-Diagnostic Cybersécurité PME" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900">
        <!-- Header -->
        <header class="absolute top-0 left-0 right-0 z-50">
            <nav class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="text-2xl font-bold text-white">vCISO</span>
                    </div>
                    
                    <div v-if="canLogin" class="flex items-center space-x-4">
                        <Link
                            :href="route('login')"
                            class="text-gray-300 hover:text-white transition"
                        >
                            Connexion
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition"
                        >
                            Créer un compte
                        </Link>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 px-6">
            <div class="container mx-auto text-center max-w-4xl">
                <div class="mb-8">
                    <span class="inline-block px-4 py-2 bg-blue-500/20 rounded-full text-blue-300 text-sm font-medium mb-4">
                        🔒 Gratuit • Confidentiel • IA-Powered
                    </span>
                </div>
                
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                    Évaluez votre cybersécurité<br />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">
                        en 5 minutes
                    </span>
                </h1>
                
                <p class="text-xl text-gray-300 mb-12 max-w-2xl mx-auto">
                    Auto-diagnostic cybersécurité pour PME. Rapport exécutif généré par IA avec recommandations personnalisées.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
                    <Link
                        :href="route('assessment.start', { level: 'express' })"
                        class="group w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-xl shadow-xl shadow-blue-500/50 transition-all transform hover:scale-105"
                    >
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Diagnostic Express (5 min)
                        </span>
                    </Link>
                    
                    <Link
                        :href="route('assessment.start', { level: 'detailed' })"
                        class="group w-full sm:w-auto px-8 py-4 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl border-2 border-slate-600 transition-all"
                    >
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Auto-diagnostic Complet (20 min)
                        </span>
                    </Link>
                </div>

                <!-- Trust Badges -->
                <div class="flex flex-wrap items-center justify-center gap-6 text-sm text-gray-400">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        RGPD Conforme
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        100% Gratuit
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Rapport Immédiat
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 px-6 bg-slate-800/50">
            <div class="container mx-auto max-w-6xl">
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-slate-900/50 p-8 rounded-2xl border border-slate-700 hover:border-blue-500/50 transition">
                        <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Rapide & Simple</h3>
                        <p class="text-gray-400">
                            6 questions stratégiques suffisent pour obtenir votre premier diagnostic cybersécurité.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-slate-900/50 p-8 rounded-2xl border border-slate-700 hover:border-blue-500/50 transition">
                        <div class="w-12 h-12 bg-cyan-500/20 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">IA-Powered</h3>
                        <p class="text-gray-400">
                            Rapport exécutif généré automatiquement avec recommandations personnalisées par IA.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-slate-900/50 p-8 rounded-2xl border border-slate-700 hover:border-blue-500/50 transition">
                        <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Accompagnement Expert</h3>
                        <p class="text-gray-400">
                            Prenez rendez-vous avec un consultant cybersécurité pour aller plus loin.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-12 px-6 bg-slate-900 border-t border-slate-800">
            <div class="container mx-auto text-center">
                <p class="text-gray-400 text-sm">
                    &copy; 2026 vCISO Platform. Conforme RGPD. Vos données sont chiffrées et confidentielles.
                </p>
                <p class="text-gray-500 text-xs mt-2">
                    Plateforme propulsée par Laravel + Vue.js
                </p>
            </div>
        </footer>
    </div>
</template>
