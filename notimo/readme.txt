=== Notimo ===
Contributors: notimo
Tags: notimo, sdk, head, script
Requires at least: 5.8
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 1.0.0
licence: GPLv2 or later
licence URI: https://www.gnu.org/licences/gpl-2.0.html

Loads Notimo on every public-facing page.

== Installation ==

1. Upload the `notimo` folder to `/wp-content/plugins/`.
2. Activate **Notimo** from **Plugins**.
3. Open **Settings → Notimo**.
4. Enter and save your licence code.

== Configuration ==

The SDK is disabled when the licence field is empty. The code is added through WordPress's `wp_head` hook, immediately before the closing `</head>` tag produced by the active theme.

== Updates ==

The plugin includes a semantic version and WordPress update metadata. When distributed through a WordPress update source, newer versions can be installed normally from the Plugins screen.

