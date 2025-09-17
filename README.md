# lack-mdmail

Eine PHP-Bibliothek zum direkten Versenden von E-Mails an Mailserver basierend auf PHPMailer.

A PHP library for sending emails directly to mail servers based on PHPMailer.

## Installation

Install via Composer:

```bash
composer require lack-project/lack-mdmail
```

## Anforderungen / Requirements

- PHP >= 7.4
- PHPMailer >= 6.8

## Verwendung / Usage

### Basis-Konfiguration / Basic Configuration

```php
<?php
require_once 'vendor/autoload.php';

use LackProject\MdMail\MdMailer;
use LackProject\MdMail\MdMailerConfig;

// Gmail Konfiguration / Gmail Configuration
$config = MdMailerConfig::gmail('your-email@gmail.com', 'your-app-password');
$mailer = new MdMailer($config);

// Outlook Konfiguration / Outlook Configuration
$config = MdMailerConfig::outlook('your-email@outlook.com', 'your-password');
$mailer = new MdMailer($config);

// Benutzerdefinierte SMTP Konfiguration / Custom SMTP Configuration
$config = MdMailerConfig::custom(
    'smtp.yourdomain.com',  // SMTP Host
    587,                    // Port
    'user@yourdomain.com',  // Username
    'your-password',        // Password
    'tls',                  // Verschlüsselung / Encryption
    true                    // Authentifizierung / Authentication
);
$mailer = new MdMailer($config);
```

### E-Mail senden / Sending Emails

```php
// Einfache E-Mail / Simple Email
$result = $mailer->send(
    'recipient@example.com',              // Empfänger / Recipient
    'Betreff',                           // Betreff / Subject
    '<h1>Hallo!</h1><p>Test E-Mail.</p>', // Inhalt (HTML) / Content (HTML)
    'sender@example.com',                // Absender E-Mail / Sender Email
    'Absender Name',                     // Absender Name / Sender Name
    true                                 // HTML Format
);

// E-Mail an mehrere Empfänger / Email to Multiple Recipients
$recipients = ['user1@example.com', 'user2@example.com'];
$result = $mailer->sendToMultiple(
    $recipients,
    'Bulk E-Mail Betreff',
    '<h1>Massenversand</h1><p>E-Mail an mehrere Empfänger.</p>',
    'sender@example.com',
    'Bulk Sender'
);
```

### Erweiterte Funktionen / Advanced Features

```php
// Anhänge hinzufügen / Add Attachments
$mailer->addAttachment('/path/to/file.pdf', 'Document.pdf');

// CC und BCC Empfänger / CC and BCC Recipients
$mailer->addCC('cc@example.com', 'CC Empfänger');
$mailer->addBCC('bcc@example.com', 'BCC Empfänger');

// Antwort-an Adresse / Reply-To Address
$mailer->setReplyTo('noreply@example.com', 'No Reply');

// E-Mail Priorität setzen / Set Email Priority
$mailer->setPriority(1); // 1 = Hoch, 3 = Normal, 5 = Niedrig / 1 = High, 3 = Normal, 5 = Low

// SMTP Verbindung testen / Test SMTP Connection
if ($mailer->testConnection()) {
    echo "SMTP Verbindung erfolgreich!";
} else {
    echo "SMTP Verbindung fehlgeschlagen: " . $mailer->getLastError();
}
```

## Verfügbare Methoden / Available Methods

### MdMailer Klasse / MdMailer Class

- `send($to, $subject, $body, $fromEmail, $fromName = '', $isHTML = true)` - Sendet eine E-Mail / Sends an email
- `sendToMultiple($recipients, $subject, $body, $fromEmail, $fromName = '', $isHTML = true)` - Sendet an mehrere Empfänger / Sends to multiple recipients
- `addAttachment($path, $name = '')` - Fügt Anhang hinzu / Adds attachment
- `setPriority($priority)` - Setzt E-Mail Priorität / Sets email priority
- `addCC($email, $name = '')` - Fügt CC Empfänger hinzu / Adds CC recipient
- `addBCC($email, $name = '')` - Fügt BCC Empfänger hinzu / Adds BCC recipient
- `setReplyTo($email, $name = '')` - Setzt Antwort-an Adresse / Sets reply-to address
- `testConnection()` - Testet SMTP Verbindung / Tests SMTP connection
- `getLastError()` - Gibt letzten Fehler zurück / Returns last error
- `getMailer()` - Gibt PHPMailer Instanz zurück / Returns PHPMailer instance

### MdMailerConfig Klasse / MdMailerConfig Class

- `MdMailerConfig::gmail($username, $password)` - Gmail Konfiguration / Gmail configuration
- `MdMailerConfig::outlook($username, $password)` - Outlook Konfiguration / Outlook configuration
- `MdMailerConfig::yahoo($username, $password)` - Yahoo Konfiguration / Yahoo configuration
- `MdMailerConfig::custom($host, $port, $username, $password, $encryption, $auth)` - Benutzerdefinierte Konfiguration / Custom configuration

## Beispiele / Examples

Detaillierte Beispiele finden Sie in der Datei `examples.php` / Detailed examples can be found in the `examples.php` file.

## Lizenz / License

MIT License - siehe LICENSE Datei / see LICENSE file

## Beitragen / Contributing

Beiträge sind willkommen! Bitte erstellen Sie einen Pull Request. / Contributions are welcome! Please create a pull request.

## Support

Bei Problemen oder Fragen erstellen Sie bitte ein Issue im GitHub Repository. / For issues or questions, please create an issue in the GitHub repository.