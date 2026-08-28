<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'

import AppShell from '@/layouts/AppShell.vue'

defineOptions({ layout: AppShell })

defineProps<{
    path: string
}>()
</script>

<template>
    <Head title="Page not found" />

    <article class="page-frame not-found-page">
        <p class="section-kicker">Error 404</p>
        <div class="not-found-code" aria-hidden="true">404</div>
        <h1>This page does not exist.</h1>
        <p>
            Yii could not match <code>{{ path }}</code>. Return to the application home page.
        </p>
        <Link class="button button-primary" href="/">Return home</Link>
    </article>
</template>
