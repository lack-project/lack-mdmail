<?php

/**
 * Example usage of MdMailer
 * 
 * This file demonstrates how to use the MdMailer class to send emails
 * directly to mail servers using different providers.
 */

require_once __DIR__ . '/vendor/autoload.php';

use LackProject\MdMail\MdMailer;
use LackProject\MdMail\MdMailerConfig;

// Example 1: Using Gmail configuration
echo "Example 1: Gmail Configuration\n";
$gmailConfig = MdMailerConfig::gmail('your-email@gmail.com', 'your-app-password');
$gmailMailer = new MdMailer($gmailConfig);

// Example 2: Using Outlook configuration
echo "Example 2: Outlook Configuration\n";
$outlookConfig = MdMailerConfig::outlook('your-email@outlook.com', 'your-password');
$outlookMailer = new MdMailer($outlookConfig);

// Example 3: Using custom SMTP configuration
echo "Example 3: Custom SMTP Configuration\n";
$customConfig = MdMailerConfig::custom(
    'smtp.yourdomain.com',  // SMTP host
    587,                    // Port
    'user@yourdomain.com',  // Username
    'your-password',        // Password
    'tls',                  // Encryption
    true                    // Use authentication
);
$customMailer = new MdMailer($customConfig);

// Example 4: Sending a simple email
echo "Example 4: Sending a Simple Email\n";
try {
    // Note: This is just an example - you need valid SMTP credentials to actually send
    /*
    $result = $gmailMailer->send(
        'recipient@example.com',           // To
        'Test Email Subject',              // Subject
        '<h1>Hello!</h1><p>This is a test email.</p>', // Body (HTML)
        'sender@gmail.com',                // From email
        'Sender Name',                     // From name
        true                               // Is HTML
    );
    
    if ($result) {
        echo "Email sent successfully!\n";
    } else {
        echo "Failed to send email: " . $gmailMailer->getLastError() . "\n";
    }
    */
    echo "Email sending example (commented out - requires valid credentials)\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Example 5: Sending email to multiple recipients
echo "Example 5: Sending to Multiple Recipients\n";
try {
    /*
    $recipients = [
        'user1@example.com',
        'user2@example.com',
        'user3@example.com'
    ];
    
    $result = $customMailer->sendToMultiple(
        $recipients,                       // Recipients array
        'Bulk Email Subject',              // Subject
        '<h1>Bulk Email</h1><p>This is sent to multiple recipients.</p>', // Body
        'sender@yourdomain.com',           // From email
        'Bulk Sender',                     // From name
        true                               // Is HTML
    );
    */
    echo "Multiple recipients example (commented out - requires valid credentials)\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Example 6: Advanced email with attachments and CC/BCC
echo "Example 6: Advanced Email Features\n";
try {
    /*
    // Add attachments
    $gmailMailer->addAttachment('/path/to/file.pdf', 'Document.pdf');
    $gmailMailer->addAttachment('/path/to/image.jpg');
    
    // Add CC and BCC recipients
    $gmailMailer->addCC('cc@example.com', 'CC Recipient');
    $gmailMailer->addBCC('bcc@example.com', 'BCC Recipient');
    
    // Set reply-to address
    $gmailMailer->setReplyTo('noreply@example.com', 'No Reply');
    
    // Set email priority (1 = High, 3 = Normal, 5 = Low)
    $gmailMailer->setPriority(1);
    
    $result = $gmailMailer->send(
        'recipient@example.com',
        'Advanced Email with Attachments',
        '<h1>Advanced Email</h1><p>This email has attachments and CC/BCC recipients.</p>',
        'sender@gmail.com',
        'Advanced Sender'
    );
    */
    echo "Advanced features example (commented out - requires valid credentials)\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Example 7: Testing SMTP connection
echo "Example 7: Testing SMTP Connection\n";
try {
    /*
    if ($gmailMailer->testConnection()) {
        echo "SMTP connection successful!\n";
    } else {
        echo "SMTP connection failed: " . $gmailMailer->getLastError() . "\n";
    }
    */
    echo "Connection test example (commented out - requires valid credentials)\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Example 8: Using the underlying PHPMailer instance for advanced features
echo "Example 8: Advanced PHPMailer Features\n";
$mailer = new MdMailer();
$phpMailer = $mailer->getMailer();

// You can now use any PHPMailer feature directly
echo "PHPMailer version: " . $phpMailer::VERSION . "\n";
echo "Charset: " . $phpMailer->CharSet . "\n";

echo "\nAll examples completed!\n";
echo "\nNote: To actually send emails, you need to:\n";
echo "1. Uncomment the relevant code sections\n";
echo "2. Replace with your actual SMTP credentials\n";
echo "3. Replace with real email addresses\n";
echo "4. Ensure you have proper authentication (app passwords for Gmail)\n";