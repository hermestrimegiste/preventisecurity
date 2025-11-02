<script setup>
import { ref, watch, onMounted } from 'vue';
import { MagnifyingGlassIcon, XMarkIcon } from '@heroicons/vue/20/solid';

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: 'Rechercher...',
    },
    debounce: {
        type: Number,
        default: 300,
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md', 'lg'].includes(value),
    },
    rounded: {
        type: String,
        default: 'full',
        validator: (value) => ['none', 'sm', 'md', 'lg', 'full'].includes(value),
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['update:modelValue', 'search', 'clear']);

const searchQuery = ref(props.modelValue);
let timeoutId = null;

const sizeClasses = {
    sm: 'px-3 py-1.5 text-sm',
    md: 'px-4 py-2',
    lg: 'px-6 py-3 text-lg',
};

const roundedClasses = {
    none: 'rounded-none',
    sm: 'rounded',
    md: 'rounded-md',
    lg: 'rounded-lg',
    full: 'rounded-full',
};

const clearSearch = () => {
    searchQuery.value = '';
    emit('update:modelValue', '');
    emit('clear');
};

const handleInput = () => {
    // Annule le debounce précédent s'il existe
    if (timeoutId) {
        clearTimeout(timeoutId);
    }

    // Met à jour la valeur immédiatement
    emit('update:modelValue', searchQuery.value);

    // Déclenche la recherche après le délai de debounce
    timeoutId = setTimeout(() => {
        emit('search', searchQuery.value);
    }, props.debounce);
};

// Met à jour la valeur interne si la prop change de l'extérieur
watch(() => props.modelValue, (newValue) => {
    searchQuery.value = newValue;
});

// Nettoie le timeout lors du démontage du composant
onMounted(() => {
    return () => {
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
    };
});
</script>

<template>
    <div class="relative">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" />
        </div>
        <input
            v-model="searchQuery"
            type="text"
            :placeholder="placeholder"
            :disabled="disabled"
            :class="[
                'block w-full border border-gray-300 bg-white py-2 pl-10 pr-10 text-gray-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500',
                sizeClasses[size],
                roundedClasses[rounded],
                { 'opacity-50 cursor-not-allowed': disabled }
            ]"
            @input="handleInput"
        >
        <button
            v-if="searchQuery"
            type="button"
            class="absolute inset-y-0 right-0 flex items-center pr-3"
            @click="clearSearch"
            :disabled="disabled"
        >
            <XMarkIcon class="h-5 w-5 text-gray-400 hover:text-gray-600" />
        </button>
    </div>
</template>