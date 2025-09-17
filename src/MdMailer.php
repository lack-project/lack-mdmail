<?php

namespace LackProject\MdMail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * MdMailer - A mail sending class based on PHPMailer
 * 
 * This class provides a simplified interface for sending emails directly
 * to mail servers using PHPMailer as the underlying mail transport.
 */
class MdMailer
{
    /**
     * @var PHPMailer
     */
    private $mailer;

    /**
     * @var array Default configuration
     */
    private $config = [
        'host' => '',
        'port' => 587,
        'username' => '',
        'password' => '',
        'encryption' => PHPMailer::ENCRYPTION_STARTTLS,
        'auth' => true,
        'charset' => PHPMailer::CHARSET_UTF8,
        'debug' => 0
    ];

    /**
     * Constructor
     * 
     * @param array $config SMTP configuration
     */
    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->config, $config);
        $this->initializeMailer();
    }

    /**
     * Initialize PHPMailer instance
     */
    private function initializeMailer(): void
    {
        $this->mailer = new PHPMailer(true);
        
        // Server settings
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->config['host'];
        $this->mailer->SMTPAuth = $this->config['auth'];
        $this->mailer->Username = $this->config['username'];
        $this->mailer->Password = $this->config['password'];
        $this->mailer->SMTPSecure = $this->config['encryption'];
        $this->mailer->Port = $this->config['port'];
        $this->mailer->CharSet = $this->config['charset'];
        $this->mailer->SMTPDebug = $this->config['debug'];
    }

    /**
     * Send a simple email
     * 
     * @param string $to Recipient email address
     * @param string $subject Email subject
     * @param string $body Email body (can be HTML or plain text)
     * @param string $fromEmail Sender email address
     * @param string $fromName Sender name (optional)
     * @param bool $isHTML Whether the body is HTML (default: true)
     * @return bool True on success, false on failure
     * @throws Exception
     */
    public function send(
        string $to, 
        string $subject, 
        string $body, 
        string $fromEmail, 
        string $fromName = '', 
        bool $isHTML = true
    ): bool {
        try {
            // Recipients
            $this->mailer->setFrom($fromEmail, $fromName);
            $this->mailer->addAddress($to);

            // Content
            $this->mailer->isHTML($isHTML);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            // If HTML, set also a plain text version
            if ($isHTML) {
                $this->mailer->AltBody = strip_tags($body);
            }

            return $this->mailer->send();
        } catch (Exception $e) {
            throw new Exception("Email could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
        } finally {
            $this->clearMailer();
        }
    }

    /**
     * Send email with multiple recipients
     * 
     * @param array $recipients Array of recipient email addresses
     * @param string $subject Email subject
     * @param string $body Email body
     * @param string $fromEmail Sender email address
     * @param string $fromName Sender name (optional)
     * @param bool $isHTML Whether the body is HTML (default: true)
     * @return bool True on success, false on failure
     * @throws Exception
     */
    public function sendToMultiple(
        array $recipients, 
        string $subject, 
        string $body, 
        string $fromEmail, 
        string $fromName = '', 
        bool $isHTML = true
    ): bool {
        try {
            // Recipients
            $this->mailer->setFrom($fromEmail, $fromName);
            
            foreach ($recipients as $recipient) {
                $this->mailer->addAddress($recipient);
            }

            // Content
            $this->mailer->isHTML($isHTML);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            // If HTML, set also a plain text version
            if ($isHTML) {
                $this->mailer->AltBody = strip_tags($body);
            }

            return $this->mailer->send();
        } catch (Exception $e) {
            throw new Exception("Email could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
        } finally {
            $this->clearMailer();
        }
    }

    /**
     * Add an attachment to the email
     * 
     * @param string $path Path to the file
     * @param string $name Optional name for the attachment
     * @return void
     * @throws Exception
     */
    public function addAttachment(string $path, string $name = ''): void
    {
        try {
            $this->mailer->addAttachment($path, $name);
        } catch (Exception $e) {
            throw new Exception("Failed to add attachment: {$e->getMessage()}");
        }
    }

    /**
     * Set email priority
     * 
     * @param int $priority 1 = High, 3 = Normal, 5 = Low
     * @return void
     */
    public function setPriority(int $priority): void
    {
        $this->mailer->Priority = $priority;
    }

    /**
     * Add CC recipient
     * 
     * @param string $email CC email address
     * @param string $name Optional name
     * @return void
     */
    public function addCC(string $email, string $name = ''): void
    {
        $this->mailer->addCC($email, $name);
    }

    /**
     * Add BCC recipient
     * 
     * @param string $email BCC email address
     * @param string $name Optional name
     * @return void
     */
    public function addBCC(string $email, string $name = ''): void
    {
        $this->mailer->addBCC($email, $name);
    }

    /**
     * Set reply-to address
     * 
     * @param string $email Reply-to email address
     * @param string $name Optional name
     * @return void
     */
    public function setReplyTo(string $email, string $name = ''): void
    {
        $this->mailer->addReplyTo($email, $name);
    }

    /**
     * Clear all recipients, attachments, and other data
     * 
     * @return void
     */
    private function clearMailer(): void
    {
        $this->mailer->clearAddresses();
        $this->mailer->clearAttachments();
        $this->mailer->clearCCs();
        $this->mailer->clearBCCs();
        $this->mailer->clearReplyTos();
    }

    /**
     * Get the underlying PHPMailer instance for advanced usage
     * 
     * @return PHPMailer
     */
    public function getMailer(): PHPMailer
    {
        return $this->mailer;
    }

    /**
     * Test SMTP connection
     * 
     * @return bool True if connection successful
     * @throws Exception
     */
    public function testConnection(): bool
    {
        try {
            return $this->mailer->smtpConnect();
        } catch (Exception $e) {
            throw new Exception("SMTP connection failed: {$e->getMessage()}");
        }
    }

    /**
     * Get last error message
     * 
     * @return string Error message
     */
    public function getLastError(): string
    {
        return $this->mailer->ErrorInfo;
    }
}