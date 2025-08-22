# Razorpay Integration Guide for E-Martz

## Overview
This guide will help you integrate Razorpay payment gateway into your E-Martz e-commerce project.

## Features Implemented
- ✅ UPI Payments (Google Pay, PhonePe, Paytm, BHIM, etc.)
- ✅ Credit/Debit Cards
- ✅ Net Banking
- ✅ Digital Wallets
- ✅ EMI Options
- ✅ International Cards
- ✅ Webhook Support
- ✅ Payment Verification
- ✅ Error Handling

## Step-by-Step Setup

### 1. Create Razorpay Account
1. Go to [Razorpay Dashboard](https://dashboard.razorpay.com/)
2. Sign up for a new account
3. Complete KYC verification
4. Get your API keys from Dashboard > Settings > API Keys

### 2. Install Razorpay SDK
```bash
# Using Composer (Recommended)
composer require razorpay/razorpay

# Or download manually
# Download from: https://github.com/razorpay/razorpay-php
# Place in: payment/razorpay/razorpay-php/
```

### 3. Configure API Keys
Edit `payment/razorpay/config.php`:
```php
// Test Mode (Change to false for production)
define('RAZORPAY_TEST_MODE', true);

// Test Keys (Get from Razorpay Dashboard)
define('RAZORPAY_KEY_ID', 'rzp_test_YOUR_TEST_KEY_ID');
define('RAZORPAY_KEY_SECRET', 'YOUR_TEST_KEY_SECRET');

// Live Keys (For production)
define('RAZORPAY_KEY_ID', 'rzp_live_YOUR_LIVE_KEY_ID');
define('RAZORPAY_KEY_SECRET', 'YOUR_LIVE_KEY_SECRET');
```

### 4. Set Up Webhooks
1. Go to Razorpay Dashboard > Settings > Webhooks
2. Add webhook URL: `https://yourdomain.com/payment/razorpay/webhook.php`
3. Select events: `payment.captured`, `payment.failed`, `refund.processed`
4. Copy webhook secret to config.php

### 5. Update URLs
Update these URLs in `config.php`:
```php
define('RAZORPAY_SUCCESS_URL', 'https://yourdomain.com/payment/razorpay/success.php');
define('RAZORPAY_FAILURE_URL', 'https://yourdomain.com/payment/razorpay/failure.php');
```

## File Structure
```
payment/razorpay/
├── config.php          # Configuration file
├── process.php         # Payment initiation
├── success.php         # Success handler
├── failure.php         # Failure handler
├── webhook.php         # Webhook handler
├── razorpay-php/      # Razorpay SDK
└── README.md          # This file
```

## Payment Flow
1. Customer selects Razorpay on checkout
2. `process.php` creates Razorpay order
3. Customer redirected to Razorpay payment page
4. After payment, redirected to `success.php` or `failure.php`
5. Webhook updates payment status in real-time

## Testing
### Test Cards
- **Success**: 4111 1111 1111 1111
- **Failure**: 4000 0000 0000 0002
- **CVV**: Any 3 digits
- **Expiry**: Any future date

### Test UPI IDs
- `success@razorpay`
- `failure@razorpay`

## Production Checklist
- [ ] Change `RAZORPAY_TEST_MODE` to `false`
- [ ] Update with live API keys
- [ ] Update webhook URL to production domain
- [ ] Test all payment methods
- [ ] Set up SSL certificate
- [ ] Configure webhook events

## Security Features
- ✅ Payment signature verification
- ✅ Webhook signature verification
- ✅ SQL injection prevention
- ✅ XSS protection
- ✅ CSRF protection

## Support
- Razorpay Documentation: https://razorpay.com/docs/
- Razorpay Support: support@razorpay.com
- GitHub Issues: https://github.com/razorpay/razorpay-php

## Troubleshooting
1. **Payment not processing**: Check API keys and network connectivity
2. **Webhook not working**: Verify webhook URL and secret
3. **Signature verification failed**: Check webhook secret configuration
4. **Order not created**: Verify Razorpay SDK installation

## Additional Features to Implement
- [ ] Refund functionality
- [ ] Payment analytics
- [ ] Subscription payments
- [ ] International payments
- [ ] Payment links
- [ ] QR code payments 