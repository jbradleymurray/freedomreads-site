# Neon CRM to Meta Conversions API Webhook

This directory contains the webhook endpoint that receives donation events from Neon CRM and forwards them to Meta's Conversions API for ad conversion tracking.

## Setup Instructions

### 1. Get Meta Credentials

You need two pieces of information from Meta (Facebook):

#### Meta Pixel ID
1. Go to [Meta Events Manager](https://business.facebook.com/events_manager)
2. Select the Freedom Reads Pixel
3. The Pixel ID is shown at the top of the page (usually a 15-16 digit number)

#### Meta Conversions API Access Token
1. In Meta Events Manager, select your Pixel
2. Go to **Settings** → **Conversions API**
3. Click **Generate Access Token**
4. **IMPORTANT:** Save this token securely - you won't be able to see it again
5. Copy the token (starts with something like `EAAxxxxx...`)

### 2. Configure the Webhook

Edit `/webhooks/neon.php` and update these lines:

```php
$config = [
    'meta_pixel_id'     => 'YOUR_PIXEL_ID_HERE',        // Replace with your Pixel ID
    'meta_access_token' => 'YOUR_ACCESS_TOKEN_HERE',    // Replace with your Access Token
    'meta_api_version'  => 'v21.0',                     // Keep current
    'event_source_url'  => 'https://freedomreads.org/donate',
    'debug_mode'        => true,   // Set to TRUE for initial testing
    'log_file'          => __DIR__ . '/neon-webhook.log'
];
```

### 3. Configure Neon CRM Webhook

1. Log into Neon CRM admin
2. Navigate to: **Settings → System Settings → Developer Tools → Webhooks**
3. Click **New Webhook**
4. Configure:
   - **Webhook Name:** `Meta CAPI Donation Tracking`
   - **Notify URL:** `https://freedomreads.org/webhooks/neon.php`
   - **Event Trigger:** `CREATE_DONATION`
   - **Content Type:** `application/json`
5. Save the webhook

### 4. Testing

#### Enable Debug Mode
Make sure `'debug_mode' => true` in `neon.php`

#### Get Test Event Code (Optional but Recommended)
1. In Meta Events Manager, select your Pixel
2. Go to **Test Events** tab
3. Copy the `test_event_code` shown
4. In `neon.php`, uncomment and update this line:
   ```php
   $eventData['test_event_code'] = 'TEST12345';  // Replace with your actual code
   ```

#### Make a Test Donation
1. Go to https://freedomreads.org/donate
2. Complete a small test donation ($5 or less)
3. Check `/webhooks/neon-webhook.log` for the webhook processing
4. Check Meta Events Manager > Test Events to verify the event arrived

#### Verify the Event
In Meta Events Manager:
- Event should appear with source "Server"
- Check that `value` and `currency` are correct
- Review Event Match Quality (EMQ) score - should be "Good" or "Excellent"

### 5. Go Live

Once testing is successful:

1. In `neon.php`, set `'debug_mode' => false`
2. Comment out the test event code line:
   ```php
   // $eventData['test_event_code'] = 'TEST12345';
   ```
3. The webhook is now live and will track all Neon donations

## Files in this Directory

- `neon.php` - Main webhook endpoint (processes Neon webhooks)
- `.htaccess` - Protects log files from web access
- `neon-webhook.log` - Debug log (created automatically when debug_mode is true)
- `README.md` - This file

## Security Notes

1. **Access Token Security**
   - The Meta Access Token in `neon.php` is sensitive
   - Never commit it to git
   - Consider moving to environment variables or external config file

2. **Log File Protection**
   - The `.htaccess` file prevents direct access to `.log` files
   - Logs are only written when `debug_mode` is true

3. **Webhook Authentication (Optional)**
   - Neon supports basic authentication for webhooks
   - Can be configured in both Neon and the PHP script for extra security

## Troubleshooting

### Webhook not firing
- Verify webhook is enabled in Neon CRM
- Check event trigger is set to `CREATE_DONATION`
- Make sure to test with a real donation, not just test mode

### Events not appearing in Meta
- Check `neon-webhook.log` for errors
- Verify Pixel ID and Access Token are correct
- Check Meta Events Manager → Diagnostics tab

### Low Event Match Quality
- Ensure email is being captured correctly
- Verify data is hashed properly (SHA256, lowercase)
- Check the log to see what user data is being sent

## Support

For detailed implementation guide, see:
`/Users/jbradleymurray/Documents/Clients/FreedomReads/neon-meta-capi-implementation.md`
