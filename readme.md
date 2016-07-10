# Zugy

Laravel project for Zugy eCommerce store.

https://myzugy.com

## Features
* Coupons
* Delivery Time Notifications
* Order status tracking
* Payment methods
  * Stripe
  * Paypal
  * Cash

## Deployment Checklist

* Verify all API keys are working and are not test keys
* Verify database backups are working
* Product table should be synced with Algolia
* Redis is installed and running
* Following locales should be installed (check with `locale -a`):
  * it_IT.utf8
  * en_GB.utf8
* Run tests on production
* Ensure that Real Visitor IP is revealed by installing additional modules for Apache or nginx due to Cloudflare