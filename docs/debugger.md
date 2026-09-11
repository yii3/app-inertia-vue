# Yii 3 debugger

The application installs `yii3/debug` as a development dependency through the
local `../debug` Composer path repository. Yii Config loads the package's
parameters, DI definitions, protected routes, and toolbar middleware.

The package contributes `/debug`, `/debug/view`, `/debug/php-info`, and `/debug/toolbar`.
These routes are protected with Yii `IpFilter`, and access is restricted to
`127.0.0.1` and `::1` by default. Toolbar injection uses the same IP-range
configuration.

The debugger does not discover optional packages at runtime. The application
opts in through the `yii3/debug.extensions` parameters, which register the
provider-owned `PHPForge\Inertia\Debug\{InertiaCollector, InertiaPanel}` and
`PHPForge\Vite\Debug\{ViteCollector, VitePanel}` and attach each collector as a
PSR-14 listener. The container injects its event dispatcher into
`PHPForge\Vite\Vite` and `PHPForge\Inertia\Protocol`, so the application needs no
further wiring. The `debug`, `dev`, and `test` environments load this
composition; `prod` does not.

The toolbar presents the Yii and PHP versions, AJAX activity, the captured
Inertia component, and the Vite runtime mode. Selecting Inertia opens the
extension panel with page metadata, visit type, shared and page props, protocol
headers, version-conflict diagnostics, and the redacted raw payload. Selecting
Vite opens its normalized development or production configuration and typed
production manifest chunks.

To use built frontend assets with the debugger, start the application with:

```shell
APP_ENV=debug APP_DEBUG=true ./yii serve
```

Open `http://localhost:8081`. A fresh page response creates the snapshot
needed by both chips; captures created before the extensions were registered
remain unchanged. Selecting the toolbar title opens History, selecting Yii opens the
live Configuration page, and selecting PHP opens phpinfo in a new tab. The
toolbar runtime forwards the active light or dark theme in every debug link.
