<script setup>
import { computed } from 'vue';
import { 
    CheckCircleIcon, 
    ClockIcon, 
    XCircleIcon, 
    ExclamationCircleIcon,
    UserIcon,
    CalendarIcon
} from '@heroicons/vue/24/outline';

const props = defineProps({
    status: {
        type: String,
        required: true,
        validator: (value) => [
            'scheduled',    // Planifié
            'confirmed',    // Confirmé
            'in_progress',  // En cours
            'completed',    // Terminé
            'cancelled',    // Annulé
            'no_show',      // Non présent
            'pending',      // En attente
        ].includes(value),
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md', 'lg'].includes(value),
    },
    showIcon: {
        type: Boolean,
        default: true,
    },
    showText: {
        type: Boolean,
        default: true,
    },
    pill: {
        type: Boolean,
        default: true,
    },
});

const statusConfig = computed(() => {
    const configs = {
        scheduled: {
            text: 'Planifié',
            icon: ClockIcon,
            iconClass: 'text-blue-500',
            bgClass: 'bg-blue-100',
            textClass: 'text-blue-800',
        },
        confirmed: {
            text: 'Confirmé',
            icon: CheckCircleIcon,
            iconClass: 'text-green-500',
            bgClass: 'bg-green-100',
            textClass: 'text-green-800',
        },
        in_progress: {
            text: 'En cours',
            icon: UserIcon,
            iconClass: 'text-indigo-500',
            bgClass: 'bg-indigo-100',
            textClass: 'text-indigo-800',
        },
        completed: {
            text: 'Terminé',
            icon: CheckCircleIcon,
            iconClass: 'text-green-600',
            bgClass: 'bg-green-50',
            textClass: 'text-green-700',
        },
        cancelled: {
            text: 'Annulé',
            icon: XCircleIcon,
            iconClass: 'text-red-500',
            bgClass: 'bg-red-100',
            textClass: 'text-red-800',
        },
        no_show: {
            text: 'Non présent',
            icon: UserIcon,
            iconClass: 'text-amber-500',
            bgClass: 'bg-amber-100',
            textClass: 'text-amber-800',
        },
        pending: {
            text: 'En attente',
            icon: ClockIcon,
            iconClass: 'text-yellow-500',
            bgClass: 'bg-yellow-100',
            textClass: 'text-yellow-800',
        },
    };

    return configs[props.status] || {
        text: 'Inconnu',
        icon: ExclamationCircleIcon,
        iconClass: 'text-gray-500',
        bgClass: 'bg-gray-100',
        textClass: 'text-gray-800',
    };
});

const sizeClasses = {
    sm: {
        container: 'px-2 py-0.5 text-xs',
        icon: 'h-3 w-3',
    },
    md: {
        container: 'px-2.5 py-1 text-sm',
        icon: 'h-4 w-4',
    },
    lg: {
        container: 'px-3 py-1.5 text-base',
        icon: 'h-5 w-5',
    },
};
</script>

<template>
    <span 
        class="inline-flex items-center font-medium whitespace-nowrap"
        :class="[
            sizeClasses[size].container,
            statusConfig.bgClass,
            statusConfig.textClass,
            pill ? 'rounded-full' : 'rounded-md',
        ]"
    >
        <component 
            v-if="showIcon" 
            :is="statusConfig.icon" 
            :class="[
                statusConfig.iconClass, 
                sizeClasses[size].icon, 
                showText ? 'mr-1.5' : ''
            ]" 
            aria-hidden="true" 
        />
        <span v-if="showText">
            {{ statusConfig.text }}
        </span>
    </span>
</template>

<style scoped>
.whitespace-nowrap {
    white-space: nowrap;
}
</style>