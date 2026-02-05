<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    assessment: Object,
    report: Object,
    scores: Array,
    recommendations: Array,
});

const shareUrl = ref(null);
const showShareModal = ref(false);

const generateShareLink = async () => {
    try {
        const response = await fetch(route('reports.share', props.assessment.id), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });
        
        const data = await response.json();
        shareUrl.value = data.share_url;
        showShareModal.value = true;
    } catch (error) {
        console.error('Share error:', error);
    }
};

const copyToClipboard = () => {
    navigator.clipboard.writeText(shareUrl.value);
    alert('Lien copié dans le presse-papier !');
};

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
    <AuthenticatedLayout>
        <Head title="Rapport de Diagnostic" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                                    Rapport de Diagnostic Cybersécurité
                                </h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-2">
                                    {{ assessment.respondent.company_name || assessment.respondent.email }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-500">
                                    Soumis le {{ new Date(assessment.submitted_at).toLocaleDateString('fr-FR') }}
                                </p>
                            </div>
                            <div class="flex gap-3">
                                <button
                                    @click="generateShareLink"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition"
                                >
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                    Partager
                                </button>
                                <Link
                                    :href="route('reports.pdf', assessment.id)"
                                    class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition"
                                >
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Télécharger PDF
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Executive Summary -->
                <div v-if="report" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                            Résumé Exécutif
                        </h2>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ report.json_blob.executive_summary }}
                        </p>
                        <div class="mt-6 grid grid-cols-3 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <div class="text-sm text-gray-600 dark:text-gray-400">Niveau de Risque</div>
                                <div class="text-2xl font-bold" :class="getRiskColor(scores.reduce((sum, s) => sum + s.score, 0) / scores.length)">
                                    {{ report.json_blob.risk_level }}
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <div class="text-sm text-gray-600 dark:text-gray-400">Maturité Globale</div>
                                <div class="text-2xl font-bold text-blue-600">
                                    {{ report.json_blob.maturity_overall }}/5
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <div class="text-sm text-gray-600 dark:text-gray-400">Actions Prioritaires</div>
                                <div class="text-2xl font-bold text-purple-600">
                                    {{ recommendations.filter(r => r.horizon === '0-30j').length }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scores by Domain -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                            Scores par Domaine
                        </h2>
                        <div class="space-y-4">
                            <div v-for="score in scores" :key="score.id" class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ score.domain }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Maturité: {{ score.maturity_level }}/5
                                        </p>
                                    </div>
                                    <div class="text-3xl font-bold" :class="getRiskColor(score.score)">
                                        {{ Math.round(score.score) }}/100
                                    </div>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                    <div 
                                        :class="getProgressColor(score.score)"
                                        class="h-full transition-all duration-500"
                                        :style="{ width: score.score + '%' }"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                            Recommandations Prioritaires
                        </h2>
                        <div class="space-y-4">
                            <div 
                                v-for="(rec, index) in recommendations" 
                                :key="rec.id"
                                class="border border-gray-200 dark:border-gray-700 rounded-lg p-5 hover:border-blue-500 transition"
                            >
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="text-lg font-bold text-gray-900 dark:text-white">
                                                {{ index + 1 }}. {{ rec.title }}
                                            </span>
                                        </div>
                                        <p class="text-gray-700 dark:text-gray-300">
                                            {{ rec.description }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 mt-4">
                                    <span :class="getImpactBadge(rec.impact)" class="px-3 py-1 rounded-full text-xs font-medium border">
                                        Impact: {{ rec.impact }}
                                    </span>
                                    <span :class="getEffortBadge(rec.effort)" class="px-3 py-1 rounded-full text-xs font-medium">
                                        Effort: {{ rec.effort }}
                                    </span>
                                    <span class="px-3 py-1 bg-purple-900/50 text-purple-300 rounded-full text-xs font-medium">
                                        {{ rec.horizon }}
                                    </span>
                                    <span class="px-3 py-1 bg-gray-700 text-gray-300 rounded-full text-xs font-medium">
                                        {{ rec.cost_range }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Share Modal -->
                <div v-if="showShareModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click="showShareModal = false">
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4" @click.stop>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                            Lien de Partage Généré
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Ce lien permet d'accéder au rapport sans authentification. Il expire dans 30 jours.
                        </p>
                        <div class="bg-gray-100 dark:bg-gray-900 p-3 rounded-lg mb-4 break-all">
                            <code class="text-sm text-blue-600">{{ shareUrl }}</code>
                        </div>
                        <div class="flex gap-3">
                            <button
                                @click="copyToClipboard"
                                class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition"
                            >
                                Copier le lien
                            </button>
                            <button
                                @click="showShareModal = false"
                                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition"
                            >
                                Fermer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
