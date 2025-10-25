# WuzAPI Integration Documentation

## Overview

This project integrates with [WuzAPI](https://github.com/asternic/wuzapi), a simple RESTful API for WhatsApp built in Go using the Whatsmeow multi-device library.

## Configuration

### Environment Variables

Add the following variables to your `.env` file:

```env
# WuzAPI Server Configuration
WUZAPI_URL=http://localhost:8081
WUZAPI_API_TOKEN=your_api_token_here
WUZAPI_INSTANCE_ID=your_instance_id_here

# Webhook Configuration
WUZAPI_WEBHOOK_SECRET=your_webhook_secret_here

# Connection Settings
WUZAPI_TIMEOUT=30
WUZAPI_RETRY_ATTEMPTS=3
WUZAPI_RETRY_DELAY=1

# Raffle Notifications
WUZAPI_RAFFLE_NOTIFICATIONS=true
WUZAPI_PURCHASE_CONFIRMATION=true
WUZAPI_DRAW_NOTIFICATIONS=true
WUZAPI_WINNER_NOTIFICATIONS=true
```

### Docker Configuration

If using Docker, update the URL:
```env
WUZAPI_URL=http://wuzapi:8081
```

## Services

### WuzapiService

Core service for WhatsApp communication:

- `sendMessage(string $phone, string $message)` - Send text message
- `sendMedia(string $phone, string $mediaUrl, string $caption, string $mediaType)` - Send media
- `sendLocation(string $phone, float $latitude, float $longitude, string $name, string $address)` - Send location
- `sendButtons(string $phone, string $message, array $buttons)` - Send button message
- `sendList(string $phone, string $message, string $buttonText, array $sections)` - Send list message
- `getStatus()` - Get connection status
- `getQRCode()` - Get QR code for WhatsApp connection
- `isConnected()` - Check if WhatsApp is connected

### WuzapiRaffles

Raffle-specific WhatsApp functionality:

- `sendVerificationLink(string $phone, string $verificationLink, string $userName)` - Send verification link
- `sendVerificationCode(string $phone, string $code, string $userName)` - Send verification code
- `sendVerificationConfirmation(string $phone, string $userName)` - Send verification confirmation with buttons
- `sendPurchaseConfirmation(string $phone, array $purchaseData)` - Send purchase confirmation
- `sendRaffleCreatedNotification(Raffle $raffle, User $user)` - Send raffle creation notification
- `sendRaffleDrawNotification(Raffle $raffle, int $winningNumber)` - Send draw notification
- `sendWinnerNotification(Raffle $raffle, User $winner, int $winningNumber)` - Send winner notification
- `sendRaffleReminder(Raffle $raffle, User $user)` - Send raffle reminder
- `sendRaffleMenu(string $phone, string $userName)` - Send raffle menu
- `sendRaffleDetails(Raffle $raffle, string $phone)` - Send raffle details
- `sendTicketPurchaseSummary(Raffle $raffle, array $tickets, User $user, float $totalAmount)` - Send purchase summary
- `sendRaffleShare(Raffle $raffle, string $phone)` - Send raffle share message
- `sendHelpMessage(string $phone)` - Send help message
- `sendRaffleStatusUpdate(Raffle $raffle, string $status, string $phone)` - Send status update

## Webhook Events

The webhook controller handles the following WuzAPI events:

- `Message` - Text messages, button responses, list responses
- `ReadReceipt` - Message read receipts
- `Presence` - User presence updates
- `HistorySync` - Chat history synchronization
- `ChatPresence` - Chat presence updates

## API Endpoints

### Status Endpoints

- `GET /api/wuzapi/status` - Get WuzAPI connection status
- `GET /api/wuzapi/qr` - Get QR code for WhatsApp connection
- `GET /api/webhooks/whatsapp/status` - Get webhook status

### Webhook Endpoints

- `POST /api/webhooks/whatsapp` - Handle WhatsApp webhook events

## Usage Examples

### Sending a Simple Message

```php
use App\Services\WuzapiService;

$wuzapiService = app(WuzapiService::class);
$result = $wuzapiService->sendMessage('5511999999999', 'Hello from RAFE!');
```

### Sending Raffle Notifications

```php
use App\Services\WuzapiRaffles;

$wuzapiRaffles = app(WuzapiRaffles::class);
$wuzapiRaffles->sendPurchaseConfirmation('5511999999999', [
    'user_name' => 'John Doe',
    'raffle_title' => 'iPhone 15 Pro',
    'numbers' => [1, 2, 3],
    'total_amount' => 15.00
]);
```

### Sending Button Messages

```php
$buttons = [
    [
        'id' => 'confirm',
        'title' => '✅ Confirm'
    ],
    [
        'id' => 'cancel',
        'title' => '❌ Cancel'
    ]
];

$wuzapiService->sendButtons('5511999999999', 'Please confirm your action:', $buttons);
```

## Error Handling

All services include comprehensive error handling and logging. Check the Laravel logs for detailed error information:

```bash
tail -f storage/logs/laravel.log
```

## Testing

### Test Connection

```php
$wuzapiService = app(WuzapiService::class);
$isConnected = $wuzapiService->isConnected();
```

### Test Message Sending

```php
$wuzapiService = app(WuzapiService::class);
$result = $wuzapiService->sendMessage('5511999999999', 'Test message');
```

## Troubleshooting

### Common Issues

1. **Connection Failed**: Check if WuzAPI server is running and accessible
2. **Invalid Phone Number**: Ensure phone numbers are in Brazilian format (55XXXXXXXXXXX)
3. **Webhook Not Working**: Verify webhook URL is accessible and secret is correct
4. **QR Code Not Loading**: Check WuzAPI server status and connection

### Debug Mode

Enable debug logging by setting `LOG_LEVEL=debug` in your `.env` file.

## Security

- Always validate webhook signatures
- Use HTTPS for webhook URLs in production
- Keep API tokens secure
- Implement rate limiting for webhook endpoints

## Performance

- Use connection pooling for high-volume applications
- Implement retry mechanisms for failed messages
- Cache connection status to avoid repeated API calls
- Use async processing for non-critical notifications

## Support

For WuzAPI-specific issues, refer to the [official documentation](https://github.com/asternic/wuzapi).

For integration issues, check the Laravel logs and ensure all environment variables are properly configured.
