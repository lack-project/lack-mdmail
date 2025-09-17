<?php

require_once __DIR__ . '/vendor/autoload.php';

use LackProject\MdMail\MarkdownMailer;

// Example usage of MarkdownMailer
try {
    // Configuration for SMTP (example configuration)
    $config = [
        'host'       => 'smtp.example.com',
        'port'       => 587,
        'username'   => 'your-email@example.com',
        'password'   => 'your-password',
        'encryption' => 'tls',
        'auth'       => true,
        'debug'      => 0, // Set to 2 for detailed debug output
    ];

    // Create a new mailer instance
    $mailer = new MarkdownMailer($config);

    // Markdown content
    $markdownContent = <<<'MARKDOWN'
# Welcome to MarkdownMailer!

Hello **World**!

This is a test email sent using **MarkdownMailer** - a PHP library that converts Markdown to HTML and sends beautiful emails using PHPMailer.

## Features

- ✅ **Markdown to HTML conversion**
- ✅ **PHPMailer integration**
- ✅ **Fluent API**
- ✅ **Automatic plain text fallback**

### Code Example

```php
$mailer = new MarkdownMailer($config);
$mailer->from('sender@example.com', 'Sender Name')
       ->to('recipient@example.com', 'Recipient Name')
       ->subject('Test Email')
       ->markdown('# Hello **World**!')
       ->send();
```

---

*Sent with ❤️ using MarkdownMailer*
MARKDOWN;

    // Send the email
    $result = $mailer
        ->from('sender@example.com', 'Sender Name')
        ->to('recipient@example.com', 'Recipient Name')
        ->subject('Test Email from MarkdownMailer')
        ->markdown($markdownContent)
        ->send();

    if ($result) {
        echo "Email sent successfully!\n";
    } else {
        echo "Failed to send email.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}