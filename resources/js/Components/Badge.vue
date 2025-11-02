<script setup>
const props = defineProps({
    variant: {
        type: String,
        default: 'gray',
        validator: (value) => ['blue', 'green', 'red', 'yellow', 'indigo', 'purple', 'pink', 'gray'].includes(value),
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md', 'lg'].includes(value),
    },
    pill: {
        type: Boolean,
        default: false,
    },
    withDot: {
        type: Boolean,
        default: false,
    },
});

const sizeClasses = {
    sm: 'text-xs px-2 py-0.5',
    md: 'text-sm px-2.5 py-0.5',
    lg: 'text-base px-3 py-1',
};

const variantClasses = {
    blue: 'bg-blue-100 text-blue-800',
    green: 'bg-green-100 text-green-800',
    red: 'bg-red-100 text-red-800',
    yellow: 'bg-yellow-100 text-yellow-800',
    indigo: 'bg-indigo-100 text-indigo-800',
    purple: 'bg-purple-100 text-purple-800',
    pink: 'bg-pink-100 text-pink-800',
    gray: 'bg-gray-100 text-gray-800',
};
</script>

<template>
    <span 
        :class="[
            'inline-flex items-center font-medium',
            sizeClasses[size],
            variantClasses[variant],
            pill ? 'rounded-full' : 'rounded-md',
        ]"
    >
        <span 
            v-if="withDot" 
            class="w-1.5 h-1.5 rounded-full mr-1.5"
            :class="{
                'bg-blue-500': variant === 'blue',
                'bg-green-500': variant === 'green',
                'bg-red-500': variant === 'red',
                'bg-yellow-500': variant === 'yellow',
                'bg-indigo-500': variant === 'indigo',
                'bg-purple-500': variant === 'purple',
                'bg-pink-500': variant === 'pink',
                'bg-gray-500': variant === 'gray',
            }"
        ></span>
        <slot />
    </span>
</template>
