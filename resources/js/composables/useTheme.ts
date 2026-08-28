import { onMounted, onUnmounted, ref, type Ref } from "vue"

export type Theme = "dark" | "light"

const STORAGE_KEY = "theme"
const SYSTEM_THEME_QUERY = "(prefers-color-scheme: dark)"

function getStoredTheme(): Theme | null {
    if (typeof window === "undefined") {
        return null
    }

    try {
        const stored = window.localStorage.getItem(STORAGE_KEY)

        return stored === "dark" || stored === "light" ? stored : null
    } catch {
        return null
    }
}

function getDocumentTheme(): Theme {
    if (typeof document === "undefined") {
        return "light"
    }

    return document.documentElement.classList.contains("dark") ? "dark" : "light"
}

function updateThemeColor(theme: Theme): void {
    const meta = document.querySelector<HTMLMetaElement>('meta[name="theme-color"]')

    if (meta !== null) {
        meta.content = theme === "dark" ? "#07151c" : "#f8fcfd"
    }
}

export function useTheme(): { theme: Ref<Theme>; toggleTheme: () => void } {
    const theme = ref<Theme>(getDocumentTheme())
    let mediaQuery: MediaQueryList | null = null
    let mediaListener: ((event: MediaQueryListEvent) => void) | null = null
    let storageListener: ((event: StorageEvent) => void) | null = null

    function applyTheme(value: Theme, persist = true): void {
        theme.value = value

        if (typeof document !== "undefined") {
            document.documentElement.classList.toggle("dark", value === "dark")
            document.documentElement.dataset.theme = value
            document.documentElement.style.colorScheme = value
            updateThemeColor(value)
        }

        if (persist && typeof window !== "undefined") {
            try {
                window.localStorage.setItem(STORAGE_KEY, value)
            } catch {
                // The selected theme still applies when storage is unavailable.
            }
        }
    }

    function toggleTheme(): void {
        applyTheme(theme.value === "dark" ? "light" : "dark")
    }

    onMounted(() => {
        mediaQuery = window.matchMedia(SYSTEM_THEME_QUERY)
        applyTheme(getStoredTheme() ?? (mediaQuery.matches ? "dark" : "light"), false)

        mediaListener = (event: MediaQueryListEvent): void => {
            if (getStoredTheme() === null) {
                applyTheme(event.matches ? "dark" : "light", false)
            }
        }

        if (typeof mediaQuery.addEventListener === "function") {
            mediaQuery.addEventListener("change", mediaListener)
        } else {
            mediaQuery.addListener(mediaListener)
        }

        storageListener = (event: StorageEvent): void => {
            if (event.key !== STORAGE_KEY) {
                return
            }

            if (event.newValue === "dark" || event.newValue === "light") {
                applyTheme(event.newValue, false)

                return
            }

            if (event.newValue === null && mediaQuery !== null) {
                applyTheme(mediaQuery.matches ? "dark" : "light", false)
            }
        }
        window.addEventListener("storage", storageListener)
    })

    onUnmounted(() => {
        if (mediaQuery === null || mediaListener === null) {
            return
        }

        if (typeof mediaQuery.removeEventListener === "function") {
            mediaQuery.removeEventListener("change", mediaListener)
        } else {
            mediaQuery.removeListener(mediaListener)
        }

        if (storageListener !== null) {
            window.removeEventListener("storage", storageListener)
        }
    })

    return { theme, toggleTheme }
}
