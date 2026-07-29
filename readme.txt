=== Novixa Addons for Elementor ===
Contributors: novixa
Tags: elementor, addons, widgets, page builder, elementor widgets
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.2.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

An independent, lightweight widget library and control panel for Elementor.

== Description ==

Novixa Addons is an independent collection of creative, lightweight widgets for Elementor, with a clean dashboard for enabling only the elements you need.

**Included in v1.2.0**

* Heading widget (Alignment, Typography, Text Stroke, Text Shadow, Blend Mode, Normal/Hover colors)
* Text Editor widget (Alignment, Typography, Text Shadow, Paragraph Spacing, Drop Cap, Columns, Normal/Hover colors)
* Icon Box widget (icon shape, hover lift, box shadow, Normal/Hover icon colors)
* Image Box widget (hover zoom / grayscale effects, flexible left/right/top layout)
* Button widget with 2 built-in skins — Modern Solid (gradient) and Modern Outline

All settings live under **Novixa Addons** in your wp-admin menu.

== Installation ==

1. Upload the `novixa-addons` folder to `/wp-content/plugins/`.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Make sure Elementor is installed and active.
4. Go to **Novixa Addons > Elements** to enable the widgets you want.

== Frequently Asked Questions ==

= Does this require Elementor? =

Yes, Elementor (free version) must be installed and active.

= Can I disable widgets I don't use? =

Yes, go to **Novixa Addons > Elements** and toggle any widget off. Disabled widgets are not loaded on the front end.

== Changelog ==

= 1.2.1 =
* Fixed: All 5 widget names (Heading, Text Editor, Icon Box, Image Box, Button) were identical to Elementor's own built-in widgets of the same name — easy to drag the wrong one onto the page by mistake. Every widget is now labeled "... - Novixa" (e.g. "Text Editor - Novixa") so it's always obvious which widget is which in the panel and in the editor's "Edit ..." header.
* Fixed: All Plugin Check errors/warnings resolved (unslashed/sanitized settings input, removed discouraged load_plugin_textdomain() call, prefixed remaining template/uninstall variables, bumped "Tested up to").
* Fixed: Text Editor no longer leaves a phantom gap on the front end from empty TinyMCE paragraphs (blank lines) — these are now stripped so Paragraph Spacing = 0 is truly zero space. This is now also fixed live inside the Elementor editor preview, not just the front end.
* New: Icon Box widget can now use a Number badge instead of an icon (Content tab > Type).
* New: Icon Box "Spacing" (icon-to-content) and refined title/description spacing controls.

= 1.2.0 =
* Fixed: Text Editor "Paragraph Spacing" control now works reliably (broadened selector + auto-paragraph wrapping for plain content).
* New: Icon Box widget.
* New: Image Box widget.
* New: Button widget with 2 modern skins (Solid Gradient, Outline).

= 1.1.0 =
* Redesigned admin dashboard with sidebar navigation.
* Heading and Text Editor widgets now include Normal/Hover style tabs, Text Stroke, Blend Mode and Paragraph Spacing controls.

= 1.0.0 =
* Initial release: Heading and Text Editor widgets, dashboard, elements manager, settings screen.
