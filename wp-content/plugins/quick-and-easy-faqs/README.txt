=== Quick and Easy FAQs ===
Contributors: inspirythemes, saqibsarwar
Tags: FAQs, FAQ, FAQs list, accordion FAQs, toggle FAQs, filtered FAQs, grouped FAQs, FAQs Block, Gutenberg FAQs, FAQs Order, FAQs Sorting
Requires at least: 5.0
Tested up to: 5.7
Stable tag: 1.3.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Truly a quick and easy way to add FAQs to your site.

== Description ==

This plugin provides a quick and easy way add FAQs using custom post type and later on displaying those FAQs using Gutenberg Blocks or shortcodes. For details, Please consult the documentation below.

### Features

* Easily add FAQs using FAQ custom post type.
* Display FAQs in simple list style, accordion style or toggle style.
* Display FAQs in groups.
* Display FAQs in filterable groups.
* Display FAQs in sorted order by title or date.
* Settings page to customize colors and other stuff.
* Custom CSS box in settings page to override default styles.
* Translation Ready ( Comes with POT file and PO & MO translation files for few main languages )
* RTL ( Right to Left Language ) Support
* Support for Visual Composer Plugin

### Documentation

* `[faqs]` Display all FAQs in simple list style.

* `[faqs order="ASC" orderby="title"]` Display all FAQs in simple list style and order by ascending title.

* `[faqs order="DESC" orderby="title"]` Display all FAQs in simple list style and order by descending title.

* `[faqs style="grouped"]` Display all FAQs in simple list style that are separated by groups.

* `[faqs filter="true"]` Display FAQs in simple list style that are filterable by all available groups.

* `[faqs filter="group-slug,another-group-slug"]` Display FAQs in simple list style that are filterable by only given group slugs.

* `[faqs style="toggle"]` Display all FAQs in toggle style.

* `[faqs style="toggle" filter="true"]` Display all FAQs in toggle style and filterable by all available groups.

* `[faqs style="toggle-grouped"]` Display all FAQs in toggle style and grouped by all available groups.

* `[faqs style="toggle" order="ASC" orderby="title"]` Display all FAQs in toggle style and order by ascending title.

* `[faqs style="toggle" order="DESC" orderby="title"]` Display all FAQs in toggle style and order by descending title.

* `[faqs style="accordion"]` Display all FAQs in accordion style.

* `[faqs style="accordion" filter="true"]` Display all FAQs in accordion style and filterable by all available groups.

* `[faqs style="accordion-grouped"]` Display all FAQs in accordion style and grouped by all available groups.

* `[faqs style="accordion" order="ASC" orderby="title"]` Display all FAQs in accordion style and order by ascending title.

* `[faqs style="accordion" order="DESC" orderby="title"]` Display all FAQs in accordion style and order by descending title.

### Links

- [GitHub Repository](https://github.com/inspirythemes/quick-and-easy-faqs)

== Installation ==

1. Unzip the downloaded package
1. Upload `quick-and-easy-faqs` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

== Screenshots ==
1. FAQs
2. Add/Edit FAQ
3. FAQ Groups
4. FAQs Settings
5. FAQs Settings
6. Simple FAQs
7. Grouped FAQs
8. FAQs Toggle
9. FAQs Accordion

== Changelog ==

= 1.3.4 =
* Multiple FAQs filters on same page issue fixed
* FAQs group title issue fixed


= 1.3.3 =
* Tested for WordPress 5.4

= 1.3.2 =
* Improved Simple Grouped FAQs list structure

= 1.3.1 =
* HTML and shortcodes support added in FAQ's contents section
* Styles and Scripts inclusion improved
* Minor fixes/improvements in styles

= 1.3.0 =
* Refactored the code for better performance and easier maintenance
* FAQs Accordion support added
* FAQs Order By support added
* WordPress do_shortcode support added
* Improved Gutenberg support
* Font Awesome enable/disable option added
* Back to index show/hide option added

= 1.2.4 =
* Tested for WordPress 5.2.2

= 1.2.3 =
* Added Gutenberg detection check to fix bug in WordPress versions below 5.0

= 1.2.2 =
* Fixed a bug

= 1.2.0 =
* Re-Organised code files for simpler editing
* Added FAQs option in Classic Editor
* Added FAQs basic blocks in Gutenberg Editor
* Added WPML translation support
* Tested on WordPress 5.1

= 1.1.3 =
* Added partially translated language files for Spanish, French, German, Italian, Turkish and Portuguese.
* Added filter support for filterable toggle styles.
* Improved code for scenario where JavaScript is disabled.

= 1.1.2 =
* Fixed CSS precedence bug appeared in last update.

= 1.1.1 =
* Optimised CSS and JS files loading to only when shortcode is being used.
* Re-Tested for WordPress 4.9

= 1.1.0 =
* Re-Organised admin menu
* Added default color support for color settings
* Tested for WordPress 4.9

= 1.0.4 =
* Tested for WordPress 4.8

= 1.0.3 =
* Tested for WordPress 4.4

= 1.0.2 =
* Tested for WordPress 4.3
* Fixed a syntax error

= 1.0.1 =
* Fixed a spacing issue in filterable FAQs
* Added Visual Composer Support
* Added bottom margin to 'Back to Index' link in simple listing

= 1.0.0 =
* Initial Release
