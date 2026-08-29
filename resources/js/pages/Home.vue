<script setup lang="ts">
import { Deferred, Head, InfiniteScroll, router, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

import DeferredDiagnostics from "@/components/DeferredDiagnostics.vue";
import AppShell from "@/layouts/AppShell.vue";
import type {
    EcosystemDiagnostics,
    RequestFeed,
    RuntimeSnapshot,
} from "@/types";

interface ExploreItem {
    description: string;
    external?: boolean;
    eyebrow: string;
    href: string;
    label: string;
    title: string;
}

defineOptions({ layout: AppShell });

const props = defineProps<{
    ecosystem?: EcosystemDiagnostics;
    requestFeed: RequestFeed;
    runtime: RuntimeSnapshot;
}>();

const page = usePage();
const refreshing = ref(false);
const runtimeHost =
    typeof window === "undefined" ? "local runtime" : window.location.host;

const architectureProofs = [
    {
        id: "invokable-action",
        index: "01",
        area: "Invokable HTTP action",
        title: "One route. One focused class.",
        description:
            "The router selects a final invokable action. Yii's container supplies the Inertia response service through constructor injection, and the action returns the PSR-7 contract directly.",
        signal: "PSR-7 RESPONSE",
        accent: "orange",
        href: "https://yiisoft.github.io/docs/guide/structure/action.html",
        file: "src/Web/Workbench/HomeAction.php",
        request: "GET /",
        code: [
            { text: "final readonly class HomeAction", emphasis: true },
            { text: "{" },
            { text: "    public function __construct(" },
            { text: "        private Inertia $inertia," },
            { text: "    ) {}" },
            { text: "" },
            {
                text: "    public function __invoke(): ResponseInterface",
                emphasis: true,
            },
            { text: "    {" },
            { text: "        return $this->inertia->render('Home');" },
            { text: "    }" },
            { text: "}" },
        ],
        note: "The action has no framework base class and exposes the response type at its boundary.",
        facts: [
            { label: "Dispatch", value: "Invokable" },
            { label: "Dependency", value: "Constructor DI" },
        ],
    },
    {
        id: "middleware-pipeline",
        index: "02",
        area: "PSR-15 middleware pipeline",
        title: "The request path is explicit configuration.",
        description:
            "HTTP behavior is composed as an ordered PSR-15 pipeline. Session, parsers, CSRF protection, request capture, and routing are configured in one visible sequence.",
        signal: "ORDERED PIPELINE",
        accent: "green",
        href: "https://yiisoft.github.io/docs/guide/structure/middleware.html",
        file: "config/params.php",
        request: "PSR-15",
        code: [
            { text: "'middlewares' => [", emphasis: true },
            { text: "    InertiaMiddleware::class," },
            { text: "    ErrorCatcher::class," },
            { text: "    SessionMiddleware::class," },
            { text: "    RequestBodyParser::class," },
            { text: "    CsrfTokenCookieMiddleware::class," },
            { text: "    CsrfTokenMiddleware::class," },
            { text: "    RequestCatcherMiddleware::class," },
            { text: "    Router::class,", emphasis: true },
            { text: "]," },
        ],
        note: "The array is the executable request topology used by this application.",
        facts: [
            { label: "Contract", value: "PSR-15" },
            { label: "Terminal", value: "Router" },
        ],
    },
];

const foundationChanges = [
    {
        area: "Composition",
        title: "Use the packages you need.",
        description:
            "Yii 3 provides focused Composer packages that can work together as a framework or independently in PHP applications.",
        signal: "PACKAGES / CONFIG",
        accent: "blue",
    },
    {
        area: "Interoperability",
        title: "Work with PHP standards.",
        description:
            "PSR-7 messages and a PSR-15 pipeline keep framework and application boundaries explicit and replaceable.",
        signal: "PSR-7 / PSR-15",
        accent: "green",
    },
    {
        area: "State + DI",
        title: "Make dependencies explicit.",
        description:
            "Constructor injection and immutable actions keep each dependency visible at the point where it is used.",
        signal: "FINAL / READONLY",
        accent: "orange",
    },
];

const stack = [
    {
        name: "PHP 8.3+",
        role: "Runtime",
        detail: "A typed baseline for readonly application services and explicit contracts.",
    },
    {
        name: "Yii 3 packages",
        role: "Application",
        detail: "Router, middleware, DI, security, and configuration composed by need.",
    },
    {
        name: "Inertia 3",
        role: "Navigation",
        detail: "Server-selected page objects without maintaining a parallel client API.",
    },
    {
        name: "Vue 3.5 + Vite 8",
        role: "Interface",
        detail: "Typed pages, a persistent shell, lazy imports, and a production manifest.",
    },
];

const exploreItems: ExploreItem[] = [
    {
        eyebrow: "Upgrade guide",
        title: "Plan the move from Yii 2",
        description:
            "Use the official guide to rebuild one verified application flow at a time while keeping mature Yii 2 applications running.",
        href: "https://yiisoft.github.io/docs/guide/intro/upgrade-from-v2.html",
        label: "Read the upgrade guide",
        external: true,
    },
    {
        eyebrow: "Authoritative guide",
        title: "Build with Yii 3",
        description:
            "Read the official application guide for configuration, dependency injection, middleware, and package conventions.",
        href: "https://yiisoft.github.io/docs/guide/",
        label: "Read the Yii 3 guide",
        external: true,
    },
    {
        eyebrow: "Application source",
        title: "Start from a working app",
        description:
            "Explore the complete Yii, Inertia, Vue, and Vite application structure on GitHub.",
        href: "https://github.com/yii3/app-inertia-vue",
        label: "View the source",
        external: true,
    },
];

function replayRequest(): void {
    router.reload({
        only: ["runtime"],
        onStart: () => {
            refreshing.value = true;
        },
        onFinish: () => {
            refreshing.value = false;
        },
    });
}
</script>

<template>
    <Head title="">
        <meta
            head-key="description"
            name="description"
            content="A working Yii 3 application with Inertia 3, Vue 3.5, and Vite 8."
        />
    </Head>

    <article class="landing-page">
        <section class="release-hero" aria-labelledby="release-heading">
            <div class="release-hero__copy">
                <div class="release-kicker">
                    <span
                        class="release-kicker__mark"
                        aria-hidden="true"
                    ></span>
                    Yii 3 · Inertia · Vue
                </div>

                <h1 id="release-heading" class="release-title">
                    Build modern apps.
                    <span>With Yii and Vue.</span>
                </h1>

                <p class="release-lede">
                    A package-based PHP application with server-driven pages, a
                    responsive Vue interface, and Vite-powered assets.
                </p>

                <div class="release-actions">
                    <a
                        class="release-button release-button--primary"
                        href="#architecture"
                        >See the architecture</a
                    >
                    <a
                        class="release-button release-button--quiet"
                        href="https://yiisoft.github.io/docs/guide/start/creating-project.html"
                        rel="noopener noreferrer"
                        target="_blank"
                    >
                        Get started
                    </a>
                </div>

                <p class="release-note">
                    A working reference for Yii 3, Inertia 3, Vue 3.5, and Vite
                    8.
                </p>
            </div>

            <div class="runtime-window" aria-label="Application request flow">
                <div class="runtime-window__bar">
                    <div class="runtime-window__status">
                        <span aria-hidden="true"></span>
                        Runtime connected
                    </div>
                    <span>{{ runtimeHost }}</span>
                </div>

                <div class="runtime-window__body">
                    <div class="runtime-request">
                        <span>GET</span>
                        <strong>/</strong>
                        <small>PSR-7 response</small>
                    </div>

                    <div class="runtime-path" aria-hidden="true">
                        <span
                            class="runtime-path__line runtime-path__line--blue"
                        ></span>
                        <span
                            class="runtime-path__line runtime-path__line--green"
                        ></span>
                        <span
                            class="runtime-path__line runtime-path__line--orange"
                        ></span>
                    </div>

                    <ol class="runtime-stack">
                        <li>
                            <span>01</span>
                            <strong>PHP 8.3+</strong>
                            <small>runtime</small>
                        </li>
                        <li>
                            <span>02</span>
                            <strong>PSR-15</strong>
                            <small>pipeline</small>
                        </li>
                        <li>
                            <span>03</span>
                            <strong>Inertia 3</strong>
                            <small>navigation</small>
                        </li>
                        <li>
                            <span>04</span>
                            <strong>Vue 3.5</strong>
                            <small>interface</small>
                        </li>
                    </ol>

                    <div class="runtime-window__footer">
                        <code
                            >return $this-&gt;inertia-&gt;render('Home');</code
                        >
                        <span>Vite 8 ready</span>
                    </div>
                </div>
            </div>
        </section>

        <div class="release-spec" aria-label="Technology versions">
            <div>
                <span>Framework</span>
                <strong>{{ props.runtime.framework }}</strong>
            </div>
            <div>
                <span>Runtime</span>
                <strong>PHP {{ props.runtime.php }}</strong>
            </div>
            <div>
                <span>Contract</span>
                <strong>PSR-7 / PSR-15</strong>
            </div>
            <div>
                <span>Navigation</span>
                <strong>Inertia 3</strong>
            </div>
            <div>
                <span>Tooling</span>
                <strong>Vue 3.5 / Vite 8</strong>
            </div>
        </div>

        <section
            id="architecture"
            class="landing-section architecture-section"
            aria-labelledby="architecture-heading"
        >
            <div class="section-intro">
                <div>
                    <span class="section-label">Application architecture</span>
                    <h2 id="architecture-heading">Architecture, in code.</h2>
                </div>
                <p>
                    Two real files show how Yii receives a request, resolves an
                    action, and returns the Inertia page that Vue mounts.
                </p>
            </div>

            <div class="release-dossier">
                <header class="release-dossier__masthead">
                    <div class="release-dossier__branch">
                        <span aria-hidden="true"></span>
                        <strong>Yii 3 application flow</strong>
                    </div>
                    <code>2 request proofs · 3 foundation choices</code>
                    <a
                        href="https://www.yiiframework.com/news/777/yii3-is-released"
                        rel="noopener noreferrer"
                        target="_blank"
                    >
                        Read the release
                        <span aria-hidden="true">↗</span>
                    </a>
                </header>

                <div class="release-dossier__proofs">
                    <article
                        v-for="proof in architectureProofs"
                        :id="proof.id"
                        :key="proof.id"
                        class="release-proof"
                        :data-accent="proof.accent"
                    >
                        <div class="release-proof__index" aria-hidden="true">
                            {{ proof.index }}
                        </div>

                        <div class="release-proof__copy">
                            <div class="release-proof__meta">
                                <span>{{ proof.area }}</span>
                                <code>{{ proof.signal }}</code>
                            </div>
                            <h3>{{ proof.title }}</h3>
                            <p>{{ proof.description }}</p>

                            <dl class="release-proof__facts">
                                <div
                                    v-for="fact in proof.facts"
                                    :key="fact.label"
                                >
                                    <dt>{{ fact.label }}</dt>
                                    <dd>{{ fact.value }}</dd>
                                </div>
                            </dl>

                            <a
                                class="release-proof__reference"
                                :href="proof.href"
                                rel="noopener noreferrer"
                                target="_blank"
                            >
                                Read the authoritative reference
                                <span aria-hidden="true">↗</span>
                            </a>
                        </div>

                        <figure class="release-code">
                            <figcaption>
                                <span>{{ proof.file }}</span>
                                <code>{{ proof.request }}</code>
                            </figcaption>
                            <pre
                                :aria-label="`${proof.area} code example`"
                            ><code><span
                                v-for="(line, lineIndex) in proof.code"
                                :key="`${proof.id}-${lineIndex}`"
                                class="release-code__line"
                                :class="{ 'release-code__line--emphasis': line.emphasis }"
                                :data-line="String(lineIndex + 1).padStart(2, '0')"
                            >{{ line.text }}</span></code></pre>
                            <p>{{ proof.note }}</p>
                        </figure>
                    </article>
                </div>

                <div class="release-foundation">
                    <div class="release-foundation__intro">
                        <span>Foundation</span>
                        <strong>Focused packages. Clear contracts.</strong>
                    </div>

                    <article
                        v-for="change in foundationChanges"
                        :key="change.area"
                        :data-accent="change.accent"
                    >
                        <div class="release-foundation__meta">
                            <span>{{ change.area }}</span>
                            <code>{{ change.signal }}</code>
                        </div>
                        <h3>{{ change.title }}</h3>
                        <p>{{ change.description }}</p>
                    </article>
                </div>
            </div>
        </section>

        <section
            id="stack"
            class="landing-section stack-section"
            aria-labelledby="stack-heading"
        >
            <div class="section-intro section-intro--stack">
                <div>
                    <span class="section-label">One request, end to end</span>
                    <h2 id="stack-heading">Server-driven.<br />Vue-powered.</h2>
                </div>
                <p>
                    Yii owns routes and page data. Inertia carries each page
                    response. Vue updates the interface without adding a second
                    application API.
                </p>
            </div>

            <div class="stack-workbench">
                <ol class="stack-rail">
                    <li v-for="(layer, index) in stack" :key="layer.name">
                        <div class="stack-rail__index">0{{ index + 1 }}</div>
                        <div class="stack-rail__copy">
                            <span>{{ layer.role }}</span>
                            <strong>{{ layer.name }}</strong>
                            <p>{{ layer.detail }}</p>
                        </div>
                    </li>
                </ol>

                <div class="request-proof">
                    <div class="request-proof__header">
                        <div>
                            <span class="request-proof__eyebrow"
                                >Live partial reload</span
                            >
                            <h3>Refresh one server prop.</h3>
                        </div>
                        <button
                            type="button"
                            :disabled="refreshing"
                            :aria-busy="refreshing"
                            @click="replayRequest"
                        >
                            {{ refreshing ? "Requesting…" : "Replay request" }}
                        </button>
                    </div>

                    <div class="request-proof__readout" aria-live="polite">
                        <div>
                            <span>Request ID</span>
                            <code>{{ props.runtime.requestId }}</code>
                        </div>
                        <div>
                            <span>Served at</span>
                            <code>{{ props.runtime.servedAt }}</code>
                        </div>
                        <div>
                            <span>Requested prop</span>
                            <code>runtime</code>
                        </div>
                    </div>

                    <pre
                        class="request-proof__code"
                    ><code><span class="code-muted">// Home.vue</span>
<span class="code-blue">router</span>.reload({
    only: [<span class="code-green">"runtime"</span>],
})</code></pre>

                    <p class="request-proof__note">
                        Only the <code>runtime</code> page prop is refreshed.
                        Protected shared props, the shell, diagnostics, and
                        scroll position stay in place.
                    </p>
                </div>
            </div>

            <div class="deferred-proof">
                <div class="deferred-proof__copy">
                    <span class="deferred-proof__eyebrow"
                        >Deferred group / diagnostics</span
                    >
                    <h3>
                        Load secondary data after first paint.
                    </h3>
                    <p>
                        The initial page object records
                        <code>ecosystem</code> in the diagnostics group. Inertia
                        asks for it after the first response and Vue replaces
                        the accessible loading state in place.
                    </p>
                    <pre><code><span class="code-white">'ecosystem'</span> =&gt; <span class="code-blue">Prop</span>::defer(
    <span class="code-blue">static fn</span>(): <span class="code-green">array</span> =&gt; <span class="code-white">$diagnostics</span>,
    group: <span class="code-green">'diagnostics'</span>,
),</code></pre>
                </div>

                <div class="deferred-proof__result">
                    <div class="deferred-proof__bar">
                        <span><i aria-hidden="true"></i> Deferred prop</span>
                        <code>ecosystem</code>
                    </div>
                    <Deferred data="ecosystem">
                        <template #fallback>
                            <div class="diagnostics-loading" role="status">
                                <span aria-hidden="true"></span>
                                Inspecting the local package graph…
                            </div>
                        </template>

                        <DeferredDiagnostics
                            v-if="ecosystem"
                            :diagnostics="ecosystem"
                        />
                    </Deferred>
                </div>
            </div>

            <div
                id="scroll"
                class="scroll-proof"
                aria-labelledby="scroll-proof-title"
            >
                <div class="scroll-proof__copy">
                    <span class="scroll-proof__eyebrow"
                        >Inertia 3 · live scroll</span
                    >
                    <h3 id="scroll-proof-title">Load more. Stay in place.</h3>
                    <p>
                        Scroll inside the feed. When the boundary enters view,
                        Inertia requests the next slice, appends it, and
                        remembers this region in browser history.
                    </p>

                    <div class="scroll-proof__contract">
                        <span>Server contract</span>
                        <pre><code><span class="code-blue">Prop</span>::scroll(
    <span class="code-white">$feed</span>,
    <span class="code-blue">new</span> <span class="code-green">ScrollMetadata</span>(
        pageName: <span class="code-green">'feed'</span>,
        nextPage: <span class="code-white">$nextPage</span>,
    ),
);</code></pre>
                    </div>

                    <dl class="scroll-proof__meta">
                        <div>
                            <dt>Prop</dt>
                            <dd><code>requestFeed</code></dd>
                        </div>
                        <div>
                            <dt>Merge path</dt>
                            <dd><code>requestFeed.data</code></dd>
                        </div>
                    </dl>
                </div>

                <div class="scroll-feed">
                    <div class="scroll-feed__bar">
                        <div id="request-feed-label">
                            <span aria-hidden="true"></span>
                            Request flow
                        </div>
                        <code>
                            {{ props.requestFeed.data.length }} /
                            {{ props.requestFeed.total }} events
                        </code>
                    </div>

                    <div
                        class="scroll-feed__viewport"
                        scroll-region
                        tabindex="0"
                        role="region"
                        aria-labelledby="request-feed-label"
                    >
                        <InfiniteScroll
                            data="requestFeed"
                            as="ol"
                            class="scroll-feed__items"
                            :buffer="24"
                            only-next
                        >
                            <li
                                v-for="event in props.requestFeed.data"
                                :key="event.id"
                                class="scroll-feed__item"
                                :data-accent="event.accent"
                            >
                                <div class="scroll-feed__index">
                                    {{ String(event.id).padStart(2, "0") }}
                                </div>
                                <div>
                                    <span>{{ event.layer }}</span>
                                    <strong>{{ event.title }}</strong>
                                    <p>{{ event.detail }}</p>
                                </div>
                            </li>

                            <template #next="{ loading, hasMore }">
                                <div
                                    class="scroll-feed__status"
                                    role="status"
                                    aria-live="polite"
                                >
                                    <span aria-hidden="true"></span>
                                    <template v-if="loading">
                                        Loading the next slice…
                                    </template>
                                    <template v-else-if="hasMore">
                                        Keep scrolling
                                    </template>
                                    <template v-else>Flow complete</template>
                                </div>
                            </template>
                        </InfiniteScroll>
                    </div>

                    <div class="scroll-feed__footer">
                        <code>{{ page.url }}</code>
                        <code>
                            page {{ props.requestFeed.page }} /
                            {{ props.requestFeed.pages }}
                        </code>
                    </div>
                </div>
            </div>
        </section>

        <section
            id="explore"
            class="landing-section explore-section"
            aria-labelledby="explore-heading"
        >
            <div class="section-intro">
                <div>
                    <span class="section-label">Working reference app</span>
                    <h2 id="explore-heading">Explore the working app.</h2>
                </div>
                <p>
                    Inspect local diagnostics when your IP is allowed, read the
                    official guide, or use the source as a map for your own
                    application.
                </p>
            </div>

            <div class="explore-grid">
                <article
                    v-for="item in exploreItems"
                    :key="item.title"
                    class="explore-card"
                >
                    <span>{{ item.eyebrow }}</span>
                    <h3>{{ item.title }}</h3>
                    <p>{{ item.description }}</p>
                    <a
                        :href="item.href"
                        :rel="item.external ? 'noopener noreferrer' : undefined"
                        :target="item.external ? '_blank' : undefined"
                    >
                        {{ item.label }}
                        <span aria-hidden="true">{{
                            item.external ? "↗" : "→"
                        }}</span>
                    </a>
                </article>
            </div>
        </section>

        <section class="release-cta" aria-labelledby="release-cta-heading">
            <div>
                <span class="section-label">Build your application</span>
                <h2 id="release-cta-heading">Start with a clear foundation.</h2>
            </div>
            <p>
                Follow the official guide, add the packages your application
                needs, and use this reference to inspect the Inertia integration
                end to end.
            </p>
            <div class="release-actions">
                <a
                    class="release-button release-button--light"
                    href="https://yiisoft.github.io/docs/guide/start/creating-project.html"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    Get started with Yii 3
                </a>
                <a
                    class="release-button release-button--outline-light"
                    href="https://github.com/yii3/app-inertia-vue"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    View the source
                </a>
            </div>
        </section>
    </article>
</template>
