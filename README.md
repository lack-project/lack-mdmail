# MarkdownMailer

A PHP library that converts Markdown content to HTML and sends beautiful emails using PHPMailer.

## Features

- 🔄 **Markdown to HTML conversion** using League CommonMark
- 📧 **PHPMailer integration** for reliable email delivery
- 🎯 **Fluent API** for easy email composition
- 📱 **Automatic plain text fallback** for better compatibility
- ⚙️ **Flexible configuration** for various SMTP providers
- 🔄 **Reusable mailer instances** with reset functionality

## Installation

Install via Composer:

```bash
composer require lack-project/lack-mdmail
```

## Requirements

- PHP 7.4 or higher
- PHPMailer 6.8+
- League CommonMark 2.4+

## Quick Start

```php
<?php
require_once 'vendor/autoload.php';

use LackProject\MdMail\MarkdownMailer;

// Configure SMTP settings
$config = [
    'host'       => 'smtp.gmail.com',
    'port'       => 587,
    'username'   => 'your-email@gmail.com',
    'password'   => 'your-app-password',
    'encryption' => 'tls',
    'auth'       => true,
];

// Create mailer instance
$mailer = new MarkdownMailer($config);

// Compose and send email
$mailer->from('sender@example.com', 'Your Name')
       ->to('recipient@example.com', 'Recipient Name')
       ->subject('Welcome to MarkdownMailer!')
       ->markdown('# Hello **World**! This is *markdown* content.')
       ->send();
```

## Configuration Options

The constructor accepts an array of configuration options:

```php
$config = [
    'host'       => 'smtp.example.com',  // SMTP server
    'port'       => 587,                 // SMTP port
    'username'   => 'user@example.com',  // SMTP username
    'password'   => 'password',          // SMTP password
    'encryption' => 'tls',               // 'tls', 'ssl', or null
    'auth'       => true,                // Enable SMTP authentication
    'debug'      => 0,                   // Debug level (0-4)
];
```

## API Reference

### Basic Methods

#### `from(string $email, string $name = ''): self`
Set the sender information.

```php
$mailer->from('sender@example.com', 'Sender Name');
```

#### `to(string $email, string $name = ''): self`
Add a recipient.

```php
$mailer->to('recipient@example.com', 'Recipient Name');
```

#### `cc(string $email, string $name = ''): self`
Add a CC recipient.

```php
$mailer->cc('cc@example.com', 'CC Name');
```

#### `bcc(string $email, string $name = ''): self`
Add a BCC recipient.

```php
$mailer->bcc('bcc@example.com', 'BCC Name');
```

#### `subject(string $subject): self`
Set the email subject.

```php
$mailer->subject('Your Email Subject');
```

#### `markdown(string $markdown): self`
Set the email body from markdown content.

```php
$markdown = <<<'MD'
# Welcome!

Hello **world**! This email supports:

- *Italic text*
- **Bold text**
- [Links](https://example.com)
- `Code blocks`
- Lists
- And much more!
MD;

$mailer->markdown($markdown);
```

#### `attach(string $path, string $name = ''): self`
Add a file attachment.

```php
$mailer->attach('/path/to/file.pdf', 'document.pdf');
```

#### `send(): bool`
Send the email.

```php
if ($mailer->send()) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email.";
}
```

#### `reset(): self`
Clear all recipients, attachments, and content for reuse.

```php
$mailer->reset()
       ->to('new-recipient@example.com')
       ->subject('New Subject')
       ->markdown('# New Content')
       ->send();
```

### Advanced Methods

#### `getMailer(): PHPMailer`
Get the underlying PHPMailer instance for advanced configuration.

```php
$phpMailer = $mailer->getMailer();
$phpMailer->addReplyTo('noreply@example.com');
$phpMailer->addCustomHeader('X-Custom-Header', 'value');
```

## Examples

### Simple Email

```php
$mailer = new MarkdownMailer($config);

$mailer->from('hello@company.com', 'Company Name')
       ->to('customer@example.com', 'Customer Name')
       ->subject('Welcome to our service!')
       ->markdown('# Welcome! Thanks for signing up.')
       ->send();
```

### Rich Content Email

```php
$markdown = <<<'MARKDOWN'
# Monthly Newsletter

## What's New This Month

We've been busy! Here are the highlights:

### New Features
- ✅ **Dark Mode** - Now available in settings
- ✅ **Mobile App** - Download from app stores
- ✅ **API v2** - Faster and more reliable

### Upcoming Events
1. **Webinar**: Advanced Tips & Tricks
   - *Date*: March 15, 2024
   - *Time*: 2:00 PM EST
   - [Register Now](https://example.com/webinar)

2. **Conference**: Annual User Conference
   - *Date*: April 20-22, 2024
   - *Location*: San Francisco, CA

---

## Code Example

Here's how to use our new API:

```php
$client = new ApiClient('your-api-key');
$result = $client->getData(['limit' => 10]);
```

> 💡 **Tip**: Check out our [documentation](https://docs.example.com) for more examples.

Thanks for being awesome!

*The Team*
MARKDOWN;

$mailer->from('newsletter@company.com', 'Company Newsletter')
       ->to('subscriber@example.com', 'Subscriber')
       ->subject('📧 Monthly Newsletter - March 2024')
       ->markdown($markdown)
       ->send();
```

### Multiple Recipients with Attachments

```php
$mailer->from('reports@company.com', 'Reports Team')
       ->to('manager@company.com', 'Manager')
       ->cc('team@company.com', 'Team')
       ->bcc('archive@company.com')
       ->subject('Monthly Report')
       ->markdown('# Monthly Report\n\nPlease find the attached report.')
       ->attach('/path/to/report.pdf', 'monthly-report.pdf')
       ->send();
```

### Reusing Mailer Instance

```php
$mailer = new MarkdownMailer($config);

$users = [
    ['email' => 'user1@example.com', 'name' => 'User One'],
    ['email' => 'user2@example.com', 'name' => 'User Two'],
    ['email' => 'user3@example.com', 'name' => 'User Three'],
];

foreach ($users as $user) {
    $mailer->reset()
           ->from('hello@company.com', 'Company')
           ->to($user['email'], $user['name'])
           ->subject('Personal Invitation')
           ->markdown("# Hello {$user['name']}!\n\nYou're invited to our special event.")
           ->send();
    
    echo "Email sent to {$user['name']}\n";
}
```

## Error Handling

The `send()` method throws PHPMailer exceptions on failure:

```php
use PHPMailer\PHPMailer\Exception as PHPMailerException;

try {
    $mailer->from('sender@example.com')
           ->to('recipient@example.com')
           ->subject('Test')
           ->markdown('# Test')
           ->send();
    
    echo "Email sent successfully!";
} catch (PHPMailerException $e) {
    echo "Email failed: " . $e->getMessage();
}
```

## Testing

To test the markdown conversion without sending emails:

```php
$mailer = new MarkdownMailer();
$mailer->markdown('# Test **markdown**');

$phpMailer = $mailer->getMailer();
echo "HTML: " . $phpMailer->Body;
echo "Text: " . $phpMailer->AltBody;
```

## Popular SMTP Configurations

### Gmail

```php
$config = [
    'host'       => 'smtp.gmail.com',
    'port'       => 587,
    'username'   => 'your-email@gmail.com',
    'password'   => 'your-app-password', // Use App Password, not account password
    'encryption' => 'tls',
    'auth'       => true,
];
```

### Outlook/Hotmail

```php
$config = [
    'host'       => 'smtp-mail.outlook.com',
    'port'       => 587,
    'username'   => 'your-email@outlook.com',
    'password'   => 'your-password',
    'encryption' => 'tls',
    'auth'       => true,
];
```

### SendGrid

```php
$config = [
    'host'       => 'smtp.sendgrid.net',
    'port'       => 587,
    'username'   => 'apikey',
    'password'   => 'your-sendgrid-api-key',
    'encryption' => 'tls',
    'auth'       => true,
];
```

## License

MIT License. See [LICENSE](LICENSE) file for details.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.