# Yii 3 Inertia Vue application

`yii3/app-inertia-vue` is a reference application that integrates Yii 3,
Inertia.js 3, Vue 3.5, TypeScript, and Vite 8. Yii owns routing and page data,
Inertia carries page responses and navigation state, and Vue renders the
interactive interface.

## Home page

The home page demonstrates the integration with working application behavior:

- **Architecture** presents a constructor-injected invokable action and the
  explicit PSR-15 middleware pipeline that handles each request.
- **Stack** shows the Yii, Inertia, Vue, and Vite responsibilities in one
  server-driven request flow.
- **Partial reloads** refresh only the `runtime` page prop while preserving the
  persistent layout, deferred data, and scroll position.
- **Deferred props** resolve the `ecosystem` diagnostics group after the first
  response, with an accessible loading state in Vue.
- **Infinite scroll** exposes `requestFeed` through `Prop::scroll()`. The server
  provides cursor metadata, Inertia merges `requestFeed.data`, and Vue appends
  each three-event page inside a contained scroll region.
- **Explore** links to the official Yii 3 guide, the neutral Yii 2 upgrade
  guide, and the application source.
- A persistent light and dark theme follows the operating-system preference
  until the visitor chooses a mode, then stores that choice locally.

## Requirements

- PHP 8.3 or later.
- Composer 2.
- Node.js 22.12 or later.

## Install locally

Install the locked PHP and frontend dependencies, build the production assets,
and create the local environment file:

```shell
composer install
npm ci
npm run build
cp .env.example .env
```

Start the application on port 8081:

```shell
APP_ENV=debug APP_DEBUG=true ./yii serve
```

Open [http://localhost:8081](http://localhost:8081).

## Vite development server

For hot module replacement, run the Vite and Yii development servers in
separate terminals:

```shell
npm run dev
```

```shell
APP_ENV=dev APP_DEBUG=true ./yii serve
```

The PHP application continues to own routing and the initial HTML response.
`APP_ENV=dev` selects Vite's development configuration. Every other environment
uses the production configuration, where
`PHPForge\Vite\Vite` owns loading and caching
`public/build/.vite/manifest.json`. The manifest's SHA-256 hash also provides
the Inertia asset version so clients reload after built asset references change.

## Debugger

`yii3/debug` is a development dependency. The package contributes its toolbar
to the application's `yiisoft/middleware-dispatcher` parameters without an
application middleware reference to the debugger. The application explicitly
composes the Inertia collector, panel, and page observer with the Vite collector
and panel in its `debug`, `dev`, and `test` environments. Production keeps that integration absent without runtime package
detection.

The package owns the local-only `/debug`, `/debug/view`, `/debug/php-info`, and
`/debug/toolbar` routes and their Yii IP filtering. The Yii and PHP toolbar
chips open the shared Debug Core Configuration and phpinfo pages. A captured
Inertia response adds an Inertia chip linked to its component, page metadata,
props, negotiation headers, and redacted raw payload. Vite adds its
runtime mode and exposes normalized configuration and production manifest chunks.
The History page persists request summaries with filtering and pagination.

See the [debugger notes](docs/debugger.md) for the integration details.

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

## Yii references

- [Official Yii 3 guide](https://yiisoft.github.io/docs/guide/)
- [Moving from Yii 2](https://yiisoft.github.io/docs/guide/intro/upgrade-from-v2.html)
  explains how to rebuild and verify one application flow at a time. Keeping a
  mature Yii 2 application running can also be a valid choice.
- [Yii 3 release announcement](https://www.yiiframework.com/news/777/yii3-is-released)
- [Official Yii packages](https://github.com/yiisoft)

## Quality checks

```shell
npm run typecheck
npm run build
composer tests
composer static
composer check-dependencies
vendor/bin/ecs check --ansi
```

PHPStan runs at maximum level. Use `composer ecs` when you intentionally want
to apply coding-standard fixes. The Web suite covers the home page, its feed
pagination, and the application-owned 404 response without duplicating tests
for framework or tooling packages.

## License

The application is released under the BSD 3-Clause License. See `LICENSE`.
