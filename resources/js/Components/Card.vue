<script setup>
const props = defineProps({
    padding: {
        type: String,
        default: 'md',
        validator: (value) => ['none', 'sm', 'md', 'lg'].includes(value),
    },
    variant: {
        type: String,
        default: 'default',
        validator: (value) => ['default', 'outline', 'elevated', 'flat'].includes(value),
    },
    rounded: {
        type: String,
        default: 'lg',
        validator: (value) => ['none', 'sm', 'md', 'lg', 'xl', '2xl', 'full'].includes(value),
    },
    hoverEffect: {
        type: Boolean,
        default: false,
    },
    noShadow: {
        type: Boolean,
        default: false,
    },
});

const paddingClasses = {
    none: '',
    sm: 'p-4',
    md: 'p-6',
    lg: 'p-8',
};

const variantClasses = {
    default: 'bg-white',
    outline: 'bg-white border border-gray-200',
    elevated: 'bg-white shadow-md',
    flat: 'bg-gray-50',
};

const roundedClasses = {
    none: 'rounded-none',
    sm: 'rounded-sm',
    md: 'rounded-md',
    lg: 'rounded-lg',
    xl: 'rounded-xl',
    '2xl': 'rounded-2xl',
    full: 'rounded-full',
};
</script>

<template>
    <div 
        class="transition-all duration-200"
        :class="[
            variantClasses[variant],
            roundedClasses[rounded],
            { 'hover:shadow-lg': hoverEffect && !noShadow },
            { 'shadow-sm': !noShadow && variant === 'elevated' },
        ]"
    >
        <!-- Header -->
        <div 
            v-if="$slots.header" 
            class="px-6 py-4 border-b border-gray-200"
            :class="{
                'rounded-t-lg': rounded !== 'none',
                'bg-gray-50': variant === 'outline' || variant === 'default',
            }"
        >
            <slot name="header" />
        </div>

        <!-- Body -->
        <div 
            class="w-full"
            :class="[
                paddingClasses[padding],
                { 'rounded-t-lg': !$slots.header && rounded !== 'none' },
                { 'rounded-b-lg': !$slots.footer && rounded !== 'none' },
            ]"
        >
            <slot />
        </div>

        <!-- Footer -->
        <div 
            v-if="$slots.footer" 
            class="px-6 py-4 border-t border-gray-200"
            :class="{
                'rounded-b-lg': rounded !== 'none',
                'bg-gray-50': variant === 'outline' || variant === 'default',
            }"
        >
            <slot name="footer" />
        </div>
    </div>
</template>
