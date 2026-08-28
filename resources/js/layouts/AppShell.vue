<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3"
import { onBeforeUnmount, ref, watch } from "vue"

import ThemeToggle from "@/components/ThemeToggle.vue"
import { useTheme } from "@/composables/useTheme"
import type { SharedPageProps } from "@/types"

const page = usePage<SharedPageProps>()
const menuOpen = ref(false)
const menuButton = ref<HTMLButtonElement | null>(null)
const { theme, toggleTheme } = useTheme()
const yiiLogoDark = "/images/yii3_logo_dark.svg"
const yiiLogoLight = "/images/yii3_logo_light.svg"

const landingLinks = [
    { href: "/#architecture", label: "Architecture" },
    { href: "/#stack", label: "Stack" },
    { href: "/#scroll", label: "Scroll" },
]

const year = new Date().getFullYear()

function closeMenu(): void {
    menuOpen.value = false
}

function handleDocumentKeydown(event: KeyboardEvent): void {
    if (event.key !== "Escape") {
        return
    }

    closeMenu()
    menuButton.value?.focus()
}

watch(menuOpen, (open) => {
    if (typeof document === "undefined") {
        return
    }

    if (open) {
        document.addEventListener("keydown", handleDocumentKeydown)
    } else {
        document.removeEventListener("keydown", handleDocumentKeydown)
    }
})

onBeforeUnmount(() => {
    if (typeof document !== "undefined") {
        document.removeEventListener("keydown", handleDocumentKeydown)
    }
})
</script>

<template>
    <div class="site-shell">
        <a class="skip-link" href="#main-content">Skip to main content</a>

        <header class="site-header">
            <nav class="site-nav" aria-label="Primary navigation">
                <div class="site-nav__inner">
                    <Link class="site-brand" href="/" aria-label="Yii 3 application home" @click="closeMenu">
                        <img class="site-brand__logo site-brand__logo--light" :src="yiiLogoLight" alt="">
                        <img class="site-brand__logo site-brand__logo--dark" :src="yiiLogoDark" alt="">
                        <span class="site-brand__badge">Reference</span>
                    </Link>

                    <div class="site-nav__desktop">
                        <Link v-for="item in landingLinks" :key="item.href" class="site-nav__link" :href="item.href">
                            {{ item.label }}
                        </Link>
                        <a
                            class="site-nav__link"
                            href="https://yiisoft.github.io/docs/guide/intro/upgrade-from-v2.html"
                            rel="noopener noreferrer"
                            target="_blank"
                        >
                            Upgrade
                        </a>
                        <ThemeToggle :theme="theme" @toggle="toggleTheme" />
                        <a
                            class="site-nav__primary"
                            href="https://yiisoft.github.io/docs/guide/"
                            rel="noopener noreferrer"
                            target="_blank"
                        >
                            Guide
                        </a>
                    </div>

                    <div class="site-nav__mobile-actions">
                        <ThemeToggle :theme="theme" @toggle="toggleTheme" />
                        <button
                            ref="menuButton"
                            type="button"
                            class="site-nav__menu-button"
                            :aria-expanded="menuOpen"
                            aria-controls="mobile-navigation"
                            :aria-label="menuOpen ? 'Close navigation' : 'Open navigation'"
                            @click="menuOpen = !menuOpen"
                        >
                            <span
                                class="site-nav__menu-icon"
                                :class="{ 'site-nav__menu-icon--open': menuOpen }"
                                aria-hidden="true"
                            >
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>
                    </div>
                </div>

                <div v-show="menuOpen" id="mobile-navigation" class="site-nav__mobile">
                    <Link v-for="item in landingLinks" :key="item.href" :href="item.href" @click="closeMenu">
                        {{ item.label }}
                    </Link>
                    <a
                        href="https://yiisoft.github.io/docs/guide/intro/upgrade-from-v2.html"
                        rel="noopener noreferrer"
                        target="_blank"
                        @click="closeMenu"
                    >
                        Upgrade
                    </a>
                    <a
                        class="site-nav__mobile-primary"
                        href="https://yiisoft.github.io/docs/guide/"
                        rel="noopener noreferrer"
                        target="_blank"
                        @click="closeMenu"
                    >
                        Read the guide
                    </a>
                </div>
            </nav>
        </header>

        <main id="main-content" tabindex="-1">
            <slot />
        </main>

        <footer class="site-footer">
            <div class="site-footer__inner">
                <div class="site-footer__brand">
                    <a
                        class="site-footer__wordmark"
                        href="https://www.yiiframework.com/"
                        rel="noopener noreferrer"
                        target="_blank"
                        aria-label="Yii Framework website"
                    >
                        <img class="site-footer__logo site-footer__logo--light" :src="yiiLogoLight" alt="">
                        <img class="site-footer__logo site-footer__logo--dark" :src="yiiLogoDark" alt="">
                    </a>
                    <p>A working reference for {{ page.props.app.edition }}.</p>
                </div>

                <nav class="site-footer__links" aria-label="Project links">
                    <a
                        href="https://www.yiiframework.com/news/777/yii3-is-released"
                        rel="noopener noreferrer"
                        target="_blank"
                    >
                        Yii 3 release
                    </a>
                    <a
                        href="https://yiisoft.github.io/docs/guide/intro/upgrade-from-v2.html"
                        rel="noopener noreferrer"
                        target="_blank"
                    >
                        Upgrade guide
                    </a>
                    <a href="https://github.com/yiisoft" rel="noopener noreferrer" target="_blank">
                        Yii packages
                    </a>
                </nav>

                <div class="site-footer__status">
                    <span><i aria-hidden="true"></i> Reference app ready</span>
                    <small>&copy; {{ year }} Terabytesoftw · BSD-3-Clause</small>
                </div>
            </div>
        </footer>
    </div>
</template>
