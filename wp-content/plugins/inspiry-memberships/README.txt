=== Inspiry Memberships for RealHomes ===
Contributors: inspirythemes, saqibsarwar, fahidjavid
Tags: membership, real estate, inspiry, realhomes memberships, real estate membership, listing membership, real estate paid plans, real estate payments, real estate portal, paid listing, listing payments, paypal payment, stripe payment, wire transfer
Requires at least: 4.8
Tested up to: 5.8.2
Stable tag: 2.3.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Memberships packages plugin for Real Homes theme only.

== Description ==

This plugin provides memberships functionality for [RealHomes](https://realhomes.io/) theme.

This plugin offers only **one menu** to cover its settings and features. So, no trouble in finding where the settings are, where to add a new membership or where to find customer receipts. As all this is provided in one place.

Using this plugin you can use your **Stripe** account to receive payments for membership packages. You can also create subscriptions in your Stripe account and integrate it with a membership on your website using related Stripe Plan ID.

You can also use **PayPal** to receive payments for memberships. You can accept payments through Master, Visa and other credit cards supported by PayPal.

This plugin can also be configured to receive **Wire Transfers**. It emails your customer the details of the selected membership so that they can pay it via Wire Transfer.

This plugin allows you to create recurring memberships. So that you can receive **recurring payments** from your customers. You can use this feature with both Stripe and PayPal. Every time you receive a payment, a receipt is generated against it and both you and your customer gets an email notification.

### Links
- [GitHub Repository](https://github.com/InspiryThemes/inspiry-memberships)
- [Its usage in Real Homes](https://realhomes.io/documentation/ims-installation/)

== Installation ==

1. Unzip the downloaded package
2. Upload `inspiry-memberships` to the `/wp-content/plugins/` directory
3. Activate the `Inspiry Memberships` through the 'Plugins' menu in WordPress

== Screenshots ==

1. Dashboard Menu
2. Adding New Membership Package
3. Adding New Receipt
4. Basic Settings
5. Stripe Settings
6. PayPal Settings
7. Wire Transfer Settings

== Changelog ==

= 2.3.0 =
* Added free package subscription support when WC Payments are also enabled.
* Fixed package subscription expiration issue where it was not expiring on its ending date sometimes.
* Fixed instant receipt expiration issue.
* Fixed dual receipt creation issue.
* Fixed some other minor issues.
* Updated POT language file.
* Tested plugin with WordPress 5.8.2

= 2.2.0 =
* Upgraded Stripe API to latest v3 version.
* Made Stripe payments SCA (strong customer authentication) compliance.
* Added package thumbnail image support for the Stripe transaction image meta purpose.
* Improved Stripe payment process by optimizing code and adding user guide notices.
* Removed individual membership template support related code. Memberships are managed form user dashboard already.
* Fixed membership expiration label issue in receipt status column.
* Updated POT language file.

= 2.1.0 =
* Added WooCommerce Payments support for the Membership Packages.
* Added new setting control to choose between Custom Payments or WooCommerce payments.
* Improved membership packages checkout process.
* Improved recurring payments option in checkout page.
* Improved membership receipts.
* Improved Stripe and WireTransfer payment handlers to process and store data efficiently.
* Improved some plugin hooks to the appropriate use context.
* Improved memberships upgrade and downgrade process.
* Improved memberships packages interface and overall functionality.
* Improved membership subscription benefits adjustment according to the current published properties.
* Improved overall memberships code for the optimization and enhanced efficiency.
* Improved memberships notification emails contents and design.
* Improved memberships from various other aspects.
* Fixed receipt expiration problem when another receipt is already active for the same package.
* Fixed featured properties limit based on allowed numbers in a package.
* Updated translation files.
* Tested plugin with WordPress 5.7.2

= 2.0.0 =
* Added subscription cancellation option that fixes the instant expiration issues for resubscription.
* Improved admin and user email notification templates.
* Improved Membership custom post type.
* Improved Receipt custom post type.
* Refactored whole plugin code to the latest standards.
* Optimized plugin code for the better performance.
* Fixed user redirection after the membership subscription cancellation.
* Removed welcome page of the plugin.
* Tested plugin with WordPress 5.7

= 1.3.0 =
* Added "Weeks" to the expiry duration options list.
* Added membership receipt email notification to the website administrator.
* Excluded "Memberships" and "Receipts" from blog search.
* Some other minor code improvements.
* Tested plugin with WordPress 5.6.2

= 1.2.2 =
* Fixed a warning issue on checkout page.

= 1.2.1 =
* Improved some functions call.
* Tested plugin with WordPress 5.6

= 1.2.0 =
* Added RealHomes new dashboard support.
* Added excerpt support to the membership package.
* Added option to set a package as popular.
* Added checkout form with proper steps from package selection to payment.
* Added terms and & Conditions option.
* Added change membership package support.
* Fixed several minor issues.
* Improved receipt post type.
* Improved membership package pricing.
* Improved membership payment option selection and methods.
* Improved recurring payments process.
* Improved subscription and paymetns process alert and success memssages.
* Improved packages appearance for the missing information e.g price. 
* Improved overall plugin code drastically.
* Removed thumbnail support of membership package.
* Updated language files.
* Tested plugin with WordPress 5.5.3

= 1.1.2 =
* Tested plugin with WordPress 5.5

= 1.1.1 =
* Tested plugin with WordPress 5.4

= 1.1.0 =
* Improved memberships subscription area UI & UX.
* Improved subscription related notification emails.
* Updated recurring payment processes according to the latest PayPal & Stripe APIs.
* Updated plugin welcome page and its menu location.
* Updated language file.
* Tested with WordPress 5.3.2

= 1.0.5 =
* Tested with WordPress 5.2.2

= 1.0.4 =
* Added function to make duration translation ready
* Added manual cancellation of wire transfer based membership
* Fixed free membership subscription issue while using PayPal
* Fixed receipt status change bug
* Updated translation file

= 1.0.3 =
* Fixed text-domain loading issue.
* Basic testing and WordPress version update.

= 1.0.2 =
* Basic testing and WordPress version update.

= 1.0.1 =
* Fixed some bugs related to basic use cases.

= 1.0.0 =
* Initial release.
