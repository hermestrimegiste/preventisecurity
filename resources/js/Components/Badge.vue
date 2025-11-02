<script setup>
defineProps({
    variant: {
        type: String,
        default: 'gray',
        validator: (value) => ['blue', 'green', 'red', 'yellow', 'gray'].includes(value),
    },
});

const classes = {
    blue: 'badge-blue',
    green: 'badge-green',
    red: 'badge-red',
    yellow: 'badge-yellow',
    gray: 'badge-gray',
};
</script>

<template>
    <span :class="classes[variant]">
        <slot />
    </span>
</template>

