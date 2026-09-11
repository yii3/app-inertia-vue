<!-- markdownlint-disable MD041 -->
<p align="center">
    <picture>
        <source media="(prefers-color-scheme: dark)" srcset="https://www.yiiframework.com/image/design/logo/yii3_full_for_dark.svg">
        <source media="(prefers-color-scheme: light)" srcset="https://www.yiiframework.com/image/design/logo/yii3_full_for_light.svg">
        <img src="https://www.yiiframework.com/image/design/logo/yii3_full_for_light.svg" alt="Yii Framework" width="80%">
    </picture>
    <h1 align="center">Inertia.js + Vue 3 Application Template</h1>
    <br>
</p>
<!-- markdownlint-enable MD041 -->

<p align="center">
    <a href="https://github.com/yii3/app-inertia-vue/actions/workflows/build.yml" target="_blank">
        <img src="https://img.shields.io/github/actions/workflow/status/yii3/app-inertia-vue/build.yml?style=for-the-badge&logo=github&label=Build" alt="Build">
    </a>
    <a href="https://github.com/yii3/app-inertia-vue/actions/workflows/static.yml" target="_blank">
        <img src="https://img.shields.io/github/actions/workflow/status/yii3/app-inertia-vue/static.yml?style=for-the-badge&logo=github&label=PHPStan" alt="PHPStan">
    </a>
    <a href="https://github.com/yii3/app-inertia-vue/actions/workflows/security.yml" target="_blank">
        <img src="https://img.shields.io/github/actions/workflow/status/yii3/app-inertia-vue/security.yml?style=for-the-badge&label=Security&logo=github" alt="Security">
    </a>
</p>

<p align="center">
    <strong>Reference <a href="https://github.com/yiisoft">Yii 3</a> application with Inertia.js + Vue 3 integration</strong><br>
    <em>Server-driven SPA with TypeScript, Vite 8, persistent dark mode, and browser-level tests</em><br>
    <em>Yii owns routing and page data, Inertia carries navigation state, and Vue renders the interface</em>
</p>

## Features

- **Architecture** presents a constructor-injected invokable action and the explicit PSR-15 middleware pipeline that
  handles each request.
- **Stack** shows the Yii, Inertia, Vue, and Vite responsibilities in one server-driven request flow.
- **Partial reloads** refresh only the `runtime` page prop while preserving the persistent layout, deferred data, and
  scroll position.
- **Deferred props** resolve the `ecosystem` diagnostics group after the first response, with an accessible loading
  state in Vue.
- **Infinite scroll** exposes `requestFeed` through `Prop::scroll()`. The server provides cursor metadata, Inertia
  merges `requestFeed.data`, and Vue appends each three-event page inside a contained scroll region.
- **Persistent theme** follows the operating-system light and dark preference until the visitor chooses a mode, then
  stores that choice locally.

## Requirements

- [PHP](https://www.php.net/downloads) 8.3 or later.
- [Composer](https://getcomposer.org/download/) 2.
- [Node.js](https://nodejs.org/) 22.12 or later.

## Quick start

```bash
# install the locked PHP and frontend dependencies
composer install

# install the locked Node.js dependencies
npm ci

# build production assets (one-shot; for live editing see the HMR workflow below)
npm run build

# create the local environment file
cp .env.example .env

# start the development server on port 8081
APP_ENV=debug APP_DEBUG=true ./yii serve
```

Open [http://localhost:8081](http://localhost:8081).

## Development workflow with HMR

`npm run build` produces production assets once and exits. To edit `.vue` files and see changes in the browser without
rebuilding, run two processes side by side:

```bash
# Terminal 1 — Vite dev server (HMR for .vue and the application stylesheet)
npm run dev

# Terminal 2 — Yii 3 in dev mode
APP_ENV=dev APP_DEBUG=true ./yii serve
```

How the pieces connect:

- The PHP application continues to own routing and the initial HTML response.
- `APP_ENV=dev` selects Vite's development configuration. Every other environment uses the production configuration,
  where `PHPForge\Vite\Vite` owns loading and caching `public/build/.vite/manifest.json`.
- The manifest's SHA-256 hash provides the Inertia asset version, so clients reload after built asset references change.

For manifest options, development-server behavior, and CORS configuration, see the
[`php-forge/vite` documentation](https://github.com/php-forge/vite).

## Debugger

`yii3/debug` is a development dependency. The package contributes its toolbar to the application's
`yiisoft/middleware-dispatcher` parameters without an application middleware reference to the debugger. The application
explicitly composes the Inertia collector, panel, and page observer with the Vite collector and panel in its `debug`,
`dev`, and `test` environments. Production keeps that integration absent without runtime package detection.

The package owns the local-only `/debug`, `/debug/view`, `/debug/php-info`, and `/debug/toolbar` routes and their Yii IP
filtering. A captured Inertia response adds an Inertia chip linked to its component, page metadata, props, negotiation
headers, and redacted raw payload. Vite adds its runtime mode and exposes normalized configuration and production
manifest chunks.

## Project map

```text
config/routes.php                 Named Yii 3 routes
config/di/application.php         Application and Vite DI definitions
config/environments/debug/        Explicit non-production debugger integration
config/params.php                 Vite, middleware, Inertia, and application parameters
public/index.php                  Dotenv and HTTP application bootstrap
resources/js/app.ts               Typed Inertia and Vue bootstrap
resources/js/composables/         Persistent theme state
resources/js/layouts/             Persistent Vue application shell
resources/js/pages/Home.vue       Home page and Inertia demonstrations
resources/js/styles/app.css       Application visual system
resources/views/app.php           Initial Inertia HTML document
src/Web/Workbench/HomeAction.php  Home props and scroll pagination
tests/Web/                        Essential browser-level application tests
```

## Quality checks

```bash
npm run typecheck
npm run build
composer tests
composer static
composer check-dependencies
vendor/bin/ecs check --ansi
```

PHPStan runs at maximum level. Use `composer ecs` when you intentionally want to apply coding-standard fixes. The Web
suite covers the home page, its feed pagination, and the application-owned 404 response without duplicating tests for
framework or tooling packages.

## Documentation

- [Debugger integration](docs/debugger.md)

## Yii references

- [Official Yii 3 guide](https://yiisoft.github.io/docs/guide/)
- [Moving from Yii 2](https://yiisoft.github.io/docs/guide/intro/upgrade-from-v2.html)
- [Yii 3 release announcement](https://www.yiiframework.com/news/777/yii3-is-released)
- [Official Yii packages](https://github.com/yiisoft)

## Package information

[![PHP](https://img.shields.io/badge/%3E%3D8.3-777BB4.svg?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/releases/8.3/en.php)
[![Node.js](https://img.shields.io/badge/%3E%3D22.12-339933.svg?style=for-the-badge&logo=nodedotjs&logoColor=white)](https://nodejs.org/)
[![Latest Stable Version](https://img.shields.io/packagist/v/yii3/app-inertia-vue.svg?style=for-the-badge&logo=packagist&logoColor=white&label=Stable)](https://packagist.org/packages/yii3/app-inertia-vue)
[![Total Downloads](https://img.shields.io/packagist/dt/yii3/app-inertia-vue.svg?style=for-the-badge&logo=composer&logoColor=white&label=Downloads)](https://packagist.org/packages/yii3/app-inertia-vue)

## Quality code

[![PHPStan Level Max](https://img.shields.io/badge/PHPStan-Level%20Max-4F5D95.svg?style=for-the-badge&logo=github&logoColor=white)](https://github.com/yii3/app-inertia-vue/actions/workflows/static.yml)
[![Quality](https://img.shields.io/github/actions/workflow/status/yii3/app-inertia-vue/quality.yml?style=for-the-badge&label=Quality&logo=github)](https://github.com/yii3/app-inertia-vue/actions/workflows/quality.yml)

## Our social networks

[![Follow on X](https://img.shields.io/badge/-Follow%20on%20X-1DA1F2.svg?style=for-the-badge&logo=x&logoColor=white&labelColor=000000)](https://x.com/Terabytesoftw)

## License

[![License](https://img.shields.io/badge/License-BSD--3--Clause-brightgreen.svg?style=for-the-badge&logo=opensourceinitiative&logoColor=white&labelColor=555555)](LICENSE)
