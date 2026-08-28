<script setup lang="ts">
import type { EcosystemDiagnostics } from "@/types";

defineProps<{
    diagnostics: EcosystemDiagnostics;
}>();
</script>

<template>
    <div class="diagnostics-content">
        <div class="diagnostics-summary">
            <span>stack checks</span>
            <strong>{{
                diagnostics.packages.toString().padStart(2, "0")
            }}</strong>
            <p>{{ diagnostics.state }}</p>
        </div>
        <ul>
            <li v-for="check in diagnostics.checks" :key="check">
                <span aria-hidden="true">✓</span>
                {{ check }}
            </li>
        </ul>
    </div>
</template>
