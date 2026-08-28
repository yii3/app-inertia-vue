# Yii 3 debugger

The application installs `yii3/debug` as a development dependency. When the
package is installed, `ToolbarMiddleware` wraps the Inertia pipeline and
exposes the local-only toolbar and `/debug` inspection routes.

The home page receives the debugger's local access policy through an optional
container reference. Production installations without development dependencies
omit both the toolbar middleware and the local Debugger link.
