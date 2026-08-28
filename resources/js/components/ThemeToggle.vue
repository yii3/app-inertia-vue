<script setup lang="ts">
import type { Theme } from "@/composables/useTheme"

defineProps<{
    theme: Theme
}>()

const emit = defineEmits<{
    toggle: []
}>()
</script>

<template>
    <button
        type="button"
        class="theme-switch"
        :aria-label="theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
        :title="theme === 'dark' ? 'Use light mode' : 'Use dark mode'"
        @click="emit('toggle')"
    >
        <span class="theme-switch__label">
            {{ theme === "dark" ? "Light" : "Dark" }}
        </span>
        <span class="theme-switch__track" aria-hidden="true">
            <span :class="{ 'theme-switch__thumb--dark': theme === 'dark' }"></span>
        </span>
    </button>
</template>
