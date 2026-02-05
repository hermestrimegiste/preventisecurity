<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    assessment: Object,
    questions: Array,
    existingAnswers: Object,
    level: String,
    progress: Number,
});

const currentQuestionIndex = ref(0);
const answers = ref({});

// Initialize answers from existing data
props.questions.forEach((question) => {
    const existingAnswer = props.existingAnswers[question.id]?.[0];
    if (existingAnswer) {
        if (question.answer_type === 'multiple_choice') {
            answers.value[question.id] = existingAnswer.value ? existingAnswer.value.split(',') : [];
        } else {
            answers.value[question.id] = existingAnswer.value;
        }
    } else {
        answers.value[question.id] = question.answer_type === 'multiple_choice' ? [] : '';
    }
});

const currentQuestion = computed(() => props.questions[currentQuestionIndex.value]);
const isFirstQuestion = computed(() => currentQuestionIndex.value === 0);
const isLastQuestion = computed(() => currentQuestionIndex.value === props.questions.length - 1);
const canGoNext = computed(() => {
    const answer = answers.value[currentQuestion.value.id];
    if (currentQuestion.value.answer_type === 'multiple_choice') {
        return Array.isArray(answer) && answer.length > 0;
    }
    return answer && answer.trim() !== '';
});

// Auto-save timer
let autoSaveTimer = null;
const isSaving = ref(false);
const lastSaved = ref(null);

const saveAnswer = async (questionId, value) => {
    clearTimeout(autoSaveTimer);
    
    autoSaveTimer = setTimeout(async () => {
        isSaving.value = true;
        try {
            const response = await fetch(route('assessment.answer', props.assessment.id), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    question_id: questionId,
                    value: Array.isArray(value) ? value.join(',') : value,
                }),
            });
            
            lastSaved.value = new Date();
            isSaving.value = false;
        } catch (error) {
            console.error('Save error:', error);
            isSaving.value = false;
        }
    }, 1000); // Auto-save after 1 second of inactivity
};

const handleAnswerChange = (questionId, value) => {
    answers.value[questionId] = value;
    saveAnswer(questionId, value);
};

const goNext = () => {
    if (!isLastQuestion.value) {
        currentQuestionIndex.value++;
    }
};

const goPrevious = () => {
    if (!isFirstQuestion.value) {
        currentQuestionIndex.value--;
    }
};

const submitAssessment = () => {
    if (confirm('Êtes-vous sûr de vouloir soumettre votre diagnostic ? Vous ne pourrez plus le modifier.')) {
        router.post(route('assessment.submit', props.assessment.id));
    }
};

const progressPercentage = computed(() => {
    return Math.round(((currentQuestionIndex.value + 1) / props.questions.length) * 100);
});
</script>

<template>
    <Head title="Diagnostic Express" />

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header with Progress -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Diagnostic Express</h1>
                        <p class="text-gray-400 text-sm">{{ assessment.respondent.email }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-400 mb-1">
                            Question {{ currentQuestionIndex + 1 }} / {{ questions.length }}
                        </div>
                        <div v-if="isSaving" class="flex items-center text-xs text-yellow-400">
                            <svg class="animate-spin w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Sauvegarde...
                        </div>
                        <div v-else-if="lastSaved" class="flex items-center text-xs text-green-400">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Sauvegardé
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden">
                    <div 
                        class="h-full bg-gradient-to-r from-blue-600 to-cyan-600 transition-all duration-500"
                        :style="{ width: progressPercentage + '%' }"
                    ></div>
                </div>
            </div>

            <!-- Question Card -->
            <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-2xl p-8 shadow-2xl mb-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-white mb-3">
                        {{ currentQuestion.question_text }}
                    </h2>
                    <p v-if="currentQuestion.help_text" class="text-gray-400 text-sm">
                        💡 {{ currentQuestion.help_text }}
                    </p>
                </div>

                <!-- Single Choice -->
                <div v-if="currentQuestion.answer_type === 'single_choice'" class="space-y-3">
                    <label
                        v-for="option in currentQuestion.options"
                        :key="option.value"
                        class="flex items-center p-4 bg-slate-900/50 border border-slate-700 rounded-lg cursor-pointer hover:border-blue-500 transition"
                        :class="{ 'border-blue-500 bg-blue-900/20': answers[currentQuestion.id] === option.value }"
                    >
                        <input
                            type="radio"
                            :value="option.value"
                            :checked="answers[currentQuestion.id] === option.value"
                            @change="handleAnswerChange(currentQuestion.id, option.value)"
                            class="w-4 h-4 text-blue-600 bg-slate-900 border-slate-600 focus:ring-blue-500"
                        />
                        <span class="ml-3 text-white">{{ option.label }}</span>
                    </label>
                </div>

                <!-- Multiple Choice -->
                <div v-else-if="currentQuestion.answer_type === 'multiple_choice'" class="space-y-3">
                    <label
                        v-for="option in currentQuestion.options"
                        :key="option.value"
                        class="flex items-center p-4 bg-slate-900/50 border border-slate-700 rounded-lg cursor-pointer hover:border-blue-500 transition"
                        :class="{ 'border-blue-500 bg-blue-900/20': answers[currentQuestion.id]?.includes(option.value) }"
                    >
                        <input
                            type="checkbox"
                            :value="option.value"
                            :checked="answers[currentQuestion.id]?.includes(option.value)"
                            @change="(e) => {
                                const checked = e.target.checked;
                                let newValue = [...(answers[currentQuestion.id] || [])];
                                if (checked) {
                                    newValue.push(option.value);
                                } else {
                                    newValue = newValue.filter(v => v !== option.value);
                                }
                                handleAnswerChange(currentQuestion.id, newValue);
                            }"
                            class="w-4 h-4 text-blue-600 bg-slate-900 border-slate-600 rounded focus:ring-blue-500"
                        />
                        <span class="ml-3 text-white">{{ option.label }}</span>
                    </label>
                </div>

                <!-- Text Input -->
                <div v-else-if="currentQuestion.answer_type === 'text'" class="space-y-3">
                    <textarea
                        :value="answers[currentQuestion.id]"
                        @input="handleAnswerChange(currentQuestion.id, $event.target.value)"
                        rows="4"
                        class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-lg text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                        placeholder="Entrez votre réponse..."
                    ></textarea>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex items-center justify-between gap-4">
                <button
                    v-if="!isFirstQuestion"
                    @click="goPrevious"
                    class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-medium rounded-lg border border-slate-600 transition"
                >
                    ← Précédent
                </button>
                <div v-else></div>

                <button
                    v-if="!isLastQuestion"
                    @click="goNext"
                    :disabled="!canGoNext"
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-lg shadow-lg transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Suivant →
                </button>
                
                <button
                    v-else
                    @click="submitAssessment"
                    :disabled="!canGoNext"
                    class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-lg shadow-lg shadow-green-500/50 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Soumettre le diagnostic
                    </span>
                </button>
            </div>

            <!-- Estimated Time -->
            <div class="text-center mt-6 text-gray-500 text-sm">
                ⏱️ Temps estimé restant : {{ Math.max(1, 6 - currentQuestionIndex - 1) }} min
            </div>
        </div>
    </div>
</template>
