<script setup>
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    assessment: Object,
    message: String,
});
</script>

<template>
    <Head title="Diagnostic Soumis" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 flex items-center justify-center px-4 py-12">
        <div class="max-w-2xl w-full text-center">
            <!-- Success Icon -->
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-green-500/20 rounded-full mb-6">
                    <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-white mb-4">
                    Diagnostic Soumis !
                </h1>
                <p class="text-xl text-gray-300 mb-8">
                    {{ message }}
                </p>
            </div>

            <!-- Info Card -->
            <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-2xl p-8 mb-6">
                <div class="space-y-4 text-left">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-400 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h3 class="font-semibold text-white mb-1">Rapport en Génération</h3>
                            <p class="text-gray-400 text-sm">
                                Notre IA analyse vos réponses pour générer un rapport exécutif personnalisé (< 60 secondes).
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-purple-400 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <h3 class="font-semibold text-white mb-1">Email de Confirmation</h3>
                            <p class="text-gray-400 text-sm">
                                Vous recevrez un email à <strong class="text-white">{{ assessment.respondent.email }}</strong> avec le lien vers votre rapport.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-cyan-400 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <h3 class="font-semibold text-white mb-1">Consultation Gratuite</h3>
                            <p class="text-gray-400 text-sm">
                                Profitez d'un rendez-vous de 30 minutes avec un consultant cybersécurité pour discuter de vos résultats.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assessment Info -->
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="bg-slate-800/30 border border-slate-700 rounded-lg p-4">
                    <div class="text-gray-400 text-sm">Niveau</div>
                    <div class="text-white font-semibold capitalize">{{ assessment.assessment_level }}</div>
                </div>
                <div class="bg-slate-800/30 border border-slate-700 rounded-lg p-4">
                    <div class="text-gray-400 text-sm">Soumis le</div>
                    <div class="text-white font-semibold">
                        {{ new Date(assessment.submitted_at).toLocaleDateString('fr-FR') }}
                    </div>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a
                    href="/"
                    class="px-8 py-3 bg-slate-800 hover:bg-slate-700 text-white font-medium rounded-lg border border-slate-600 transition"
                >
                    Retour à l'accueil
                </a>
                
                <Link
                    :href="route('reports.show', assessment.id)"
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-lg shadow-lg transition-all transform hover:scale-105"
                >
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Voir mon rapport
                    </span>
                </Link>
            </div>

            <!-- Help Text -->
            <p class="mt-8 text-gray-500 text-sm">
                En cas de problème, contactez-nous à <a href="mailto:support@vciso.com" class="text-blue-400 hover:text-blue-300">support@vciso.com</a>
            </p>
        </div>
    </div>
</template>
