<?php
/**
 * Loads Stripe PHP SDK assets.
 *
 * @since 1.0.0
 * @package inspiry-stripe-payments/includes/stripe-php-sdk
 */

// Stripe singleton.
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Stripe.php';

// Utilities.
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Util/AutoPagingIterator.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Util/RequestOptions.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Util/Set.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Util/Util.php';

// HttpClient.
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/HttpClient/ClientInterface.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/HttpClient/CurlClient.php';

// Errors.
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Error/Base.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Error/Api.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Error/ApiConnection.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Error/Authentication.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Error/Card.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Error/InvalidRequest.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Error/Permission.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Error/RateLimit.php';

// Plumbing.
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/ApiResponse.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/JsonSerializable.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/StripeObject.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/ApiRequestor.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/ApiResource.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/SingletonApiResource.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/AttachedObject.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/ExternalAccount.php';

// Stripe API Resources.
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Account.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/AlipayAccount.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/ApplePayDomain.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/ApplicationFee.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/ApplicationFeeRefund.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Balance.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/BalanceTransaction.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/BankAccount.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/BitcoinReceiver.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/BitcoinTransaction.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Card.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Charge.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Collection.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/CountrySpec.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Coupon.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Customer.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Dispute.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Event.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/FileUpload.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Invoice.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/InvoiceItem.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Order.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/OrderReturn.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Plan.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Product.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Recipient.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Refund.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/SKU.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Source.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Subscription.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/SubscriptionItem.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/ThreeDSecure.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Token.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/Transfer.php';
require_once ISP_PLUGIN_DIR_PATH . 'includes/stripe-php-sdk/lib/TransferReversal.php';
