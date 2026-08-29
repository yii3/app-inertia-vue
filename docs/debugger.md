# Yii 3 debugger

The application installs `yii3/debug` as a development dependency through the
local `../debug` Composer path repository. Yii Config loads the package's
parameters, DI definitions, protected routes, and toolbar middleware. The
application does not reference debugger classes in its own configuration.

The package contributes `/debug`, `/debug/view`, `/debug/php-info`, and `/debug/toolbar`.
These routes are protected with Yii `IpFilter`, and access is restricted to
`127.0.0.1` and `::1` by default. Toolbar injection uses the same IP-range
configuration.

This foundational phase provides the Yii and PHP version metadata, their linked
Debug Core Configuration and phpinfo pages, toolbar injection, AJAX request
tracking, and the History grid. The package persists only the request summaries
needed by the grid and sidebar. The shared Yii-style shell places the current or
newest request card above History, the only primary sidebar item, and includes
the Yii, PHP, memory, Config, copy-link, and theme top bar. Extension panels will
appear in a separate Extensions group when they are introduced. The integration
has no application-specific request panels, collectors, or instrumentation.

Start the application and open `http://localhost:8081`. Eligible HTML
requests appear in its AJAX indicator. Selecting the toolbar title opens History,
selecting Yii opens the live
Configuration page for the generated request tag; selecting PHP opens phpinfo
in a new tab. The toolbar runtime forwards the active light or dark theme in
both links.
