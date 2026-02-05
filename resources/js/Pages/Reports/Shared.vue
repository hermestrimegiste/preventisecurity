<script setup>
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    assessment: Object,
    report: Object,
    scores: Array,
    recommendations: Array,
    isPublic: Boolean,
});

const getRiskColor = (score) => {
    if (score >= 70) return 'text-green-400';
    if (score >= 50) return 'text-yellow-400';
    if (score >= 30) return 'text-orange-400';
    return 'text-red-400';
};

const getProgressColor = (score) => {
    if (score >= 70) return 'bg-green-500';
    if (score >= 50) return 'bg-yellow-500';
    if (score >= 30) return 'bg-orange-500';
    return 'bg-red-500';
};

const getImpactBadge = (impact) => {
    const colors = {
        high: 'bg-red-900/50 text-red-300 border-red-700',
        medium: 'bg-yellow-900/50 text-yellow-300 border-yellow-700',
        low: 'bg-blue-900/50 text-blue-300 border-blue-700',
    };
    return colors[impact] || colors.medium;
};

const getEffortBadge = (effort) => {
    const colors = {
        small: 'bg-green-900/50 text-green-300',
        medium: 'bg-yellow-900/50 text-yellow-300',
        large: 'bg-red-900/50 text-red-300',
    };
    return colors[effort] || colors.medium;
};
</script>

<template>
    <Head title="Rapport Partagé - vCISO" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900">
        <!-- Header -->
        <header class="border-b border-slate-700 bg-slate-900/50 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="text-2xl font-bold text-white">vCISO</span>
                    </div>
                    <div class="text-sm text-gray-400">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        Rapport partagé • Expire le {{ new Date(report.expires_at).toLocaleDateString('fr-FR') }}
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 py-12">
            <!-- Page Header -->
            <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-2xl p-8 mb-6">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-white mb-2">
                        Rapport de Diagnostic Cybersécurité
                    </h1>
                    <p class="text-xl text-gray-400">
                        {{ assessment.respondent.company_name || assessment.respondent.email }}
                    </p>
                    <p class="text-sm text-gray-500 mt-2">
                        Généré le {{ new Date(report.generated_at).toLocaleDateString('fr-FR') }}
                    </p>
                </div>
            </div>

            <!-- Executive Summary -->
            <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-2xl p-8 mb-6">
                <h2 class="text-3xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Résumé Exécutif
                </h2>
                <p class="text-gray-300 text-lg leading-relaxed">
                    {{ report.json_blob.executive_summary }}
                </p>
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-slate-900/50 rounded-lg p-6 text-center">
                        <div class="text-sm text-gray-400 mb-2">Niveau de Risque</div>
                        <div class="text-3xl font-bold" :class="getRiskColor(scores.reduce((sum, s) => sum + s.score, 0) / scores.length)">
                            {{ report.json_blob.risk_level }}
                        </div>
                    </div>
                    <div class="bg-slate-900/50 rounded-lg p-6 text-center">
                        <div class="text-sm text-gray-400 mb-2">Maturité Globale</div>
                        <div class="text-3xl font-bold text-blue-400">
                            {{ report.json_blob.maturity_overall }}/5
                        </div>
                    </div>
                    <div class="bg-slate-900/50 rounded-lg p-6 text-center">
                        <div class="text-sm text-gray-400 mb-2">Quick Wins</div>
                        <div class="text-3xl font-bold text-purple-400">
                            {{ recommendations.filter(r => r.horizon === '0-30j').length }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scores by Domain -->
            <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-2xl p-8 mb-6">
                <h2 class="text-3xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Scores par Domaine de Sécurité
                </h2>
                <div class="space-y-5">
                    <div v-for="score in scores" :key="score.id" class="bg-slate-900/50 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h3 class="text-xl font-bold text-white">{{ score.domain }}</h3>
                                <p class="text-sm text-gray-400 mt-1">
                                    Niveau de maturité: {{ score.maturity_level }}/5
                                </p>
                            </div>
                            <div class="text-4xl font-bold" :class="getRiskColor(score.score)">
                                {{ Math.round(score.score) }}/100
                            </div>
                        </div>
                        <div class="w-full bg-slate-700 rounded-full h-4 overflow-hidden">
                            <div 
                                :class="getProgressColor(score.score)"
                                class="h-full transition-all duration-500 rounded-full"
                                :style="{ width: score.score + '%' }"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recommendations -->
            <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-2xl p-8 mb-6">
                <h2 class="text-3xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Recommandations Prioritaires
                </h2>
                <div class="space-y-5">
                    <div 
                        v-for="(rec, index) in recommendations" 
                        :key="rec.id"
                        class="bg-slate-900/50 border border-slate-700 rounded-lg p-6 hover:border-blue-500 transition"
                    >
                        <div class="mb-4">
                            <div class="flex items-start gap-3 mb-3">
                                <span class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ index + 1 }}
                                </span>
                                <h3 class="text-xl font-bold text-white flex-1">
                                    {{ rec.title }}
                                </h3>
                            </div>
                            <p class="text-gray-300 leading-relaxed ml-11">
                                {{ rec.description }}
                            </p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 ml-11">
                            <span :class="getImpactBadge(rec.impact)" class="px-3 py-1 rounded-full text-sm font-medium border">
                                Impact: {{ rec.impact }}
                            </span>
                            <span :class="getEffortBadge(rec.effort)" class="px-3 py-1 rounded-full text-sm font-medium">
                                Effort: {{ rec.effort }}
                            </span>
                            <span class="px-3 py-1 bg-purple-900/50 text-purple-300 rounded-full text-sm font-medium">
                                Délai: {{ rec.horizon }}
                            </span>
                            <span class="px-3 py-1 bg-gray-700 text-gray-300 rounded-full text-sm font-medium">
                                Budget: {{ rec.cost_range }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Footer -->
            <div class="bg-gradient-to-r from-blue-900/50 to-purple-900/50 border border-blue-700 rounded-2xl p-8 text-center">
                <h3 class="text-2xl font-bold text-white mb-3">
                    Besoin d'accompagnement pour sécuriser votre infrastructure ?
                </h3>
                <p class="text-gray-300 mb-6">
                    Prenez rendez-vous avec un consultant cybersécurité pour discuter de ces recommandations.
                </p>
                <a 
                    href="/" 
                    class="inline-block px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/50 transition-all transform hover:scale-105"
                >
                    Commencer mon diagnostic
                </a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="border-t border-slate-700 bg-slate-900/50 mt-12 py-6">
            <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
                <p>&copy; 2026 vCISO Platform. Rapport généré automatiquement par IA.</p>
                <p class="mt-1">Confidentiel • RGPD Conforme • Chiffré SSL/TLS</p>
            </div>
        </footer>
    </div>
</template>
