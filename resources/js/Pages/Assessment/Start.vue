<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    level: {
        type: String,
        default: 'express'
    }
});

const form = useForm({
    email: '',
    company_name: '',
    role: '',
    locale: 'fr',
    assessment_level: props.level,
    consent_gdpr: false,
});

const submit = () => {
    form.post(route('assessment.store'));
};

const isExpress = props.level === 'express';
</script>

<template>
    <Head :title="`Démarrer - ${isExpress ? 'Express' : 'Complet'}`" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 flex items-center justify-center px-4 py-12">
        <div class="max-w-2xl w-full">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-500/20 rounded-full mb-4">
                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path v-if="isExpress" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">
                    {{ isExpress ? 'Diagnostic Express' : 'Auto-diagnostic Complet' }}
                </h1>
                <p class="text-gray-400">
                    {{ isExpress ? '6 questions stratégiques • 5 minutes' : '8 sections techniques • 15-20 minutes' }}
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-2xl p-8 shadow-2xl">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            Email professionnel *
                        </label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="votre.nom@entreprise.com"
                        />
                        <p v-if="form.errors.email" class="mt-1 text-sm text-red-400">{{ form.errors.email }}</p>
                    </div>

                    <!-- Company Name -->
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-300 mb-2">
                            Nom de l'entreprise
                        </label>
                        <input
                            id="company_name"
                            v-model="form.company_name"
                            type="text"
                            class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Ma Société SAS"
                        />
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-300 mb-2">
                            Votre fonction
                        </label>
                        <select
                            id="role"
                            v-model="form.role"
                            class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        >
                            <option value="">-- Sélectionnez --</option>
                            <option value="CEO">CEO / Dirigeant</option>
                            <option value="CFO">CFO / DAF</option>
                            <option value="CIO">CIO / DSI</option>
                            <option value="CISO">CISO / RSSI</option>
                            <option value="IT">Responsable IT</option>
                            <option value="Other">Autre</option>
                        </select>
                    </div>

                    <!-- GDPR Consent -->
                    <div class="bg-blue-900/20 border border-blue-800 rounded-lg p-4">
                        <label class="flex items-start cursor-pointer">
                            <input
                                v-model="form.consent_gdpr"
                                type="checkbox"
                                required
                                class="mt-1 w-4 h-4 text-blue-600 bg-slate-900 border-slate-600 rounded focus:ring-blue-500"
                            />
                            <span class="ml-3 text-sm text-gray-300">
                                J'accepte que mes données soient traitées conformément au 
                                <a href="#" class="text-blue-400 hover:text-blue-300 underline">RGPD</a> 
                                pour générer mon rapport cybersécurité. Mes données sont chiffrées et confidentielles.
                            </span>
                        </label>
                        <p v-if="form.errors.consent_gdpr" class="mt-2 text-sm text-red-400">
                            {{ form.errors.consent_gdpr }}
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/50 transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                    >
                        <span v-if="!form.processing" class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                            </svg>
                            Commencer le diagnostic
                        </span>
                        <span v-else class="flex items-center justify-center">
                            <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Création en cours...
                        </span>
                    </button>

                    <!-- Security Notice -->
                    <div class="flex items-center justify-center gap-4 text-xs text-gray-500">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                            Chiffré SSL/TLS
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            RGPD Conforme
                        </div>
                    </div>
                </form>
            </div>

            <!-- Back to home -->
            <div class="text-center mt-6">
                <a href="/" class="text-gray-400 hover:text-white transition text-sm">
                    ← Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</template>
