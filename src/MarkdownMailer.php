<?php

namespace LackProject\MdMail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;

/**
 * MarkdownMailer - A simple mailer that converts Markdown to HTML and sends emails using PHPMailer
 */
class MarkdownMailer
{
    private PHPMailer $mailer;
    private MarkdownConverter $markdownConverter;

    /**
     * Constructor
     *
     * @param array $config PHPMailer configuration
     */
    public function __construct(array $config = [])
    {
        $this->mailer = new PHPMailer(true);
        $this->setupMarkdownConverter();
        $this->configureMailer($config);
    }

    /**
     * Setup the markdown converter
     */
    private function setupMarkdownConverter(): void
    {
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        
        $this->markdownConverter = new MarkdownConverter($environment);
    }

    /**
     * Configure PHPMailer with provided settings
     *
     * @param array $config Configuration array
     */
    private function configureMailer(array $config): void
    {
        // Set default configuration
        $this->mailer->isSMTP();
        $this->mailer->isHTML(true);
        $this->mailer->CharSet = 'UTF-8';

        // Apply custom configuration
        if (isset($config['host'])) {
            $this->mailer->Host = $config['host'];
        }
        
        if (isset($config['port'])) {
            $this->mailer->Port = $config['port'];
        }
        
        if (isset($config['username'])) {
            $this->mailer->Username = $config['username'];
        }
        
        if (isset($config['password'])) {
            $this->mailer->Password = $config['password'];
        }
        
        if (isset($config['encryption'])) {
            $this->mailer->SMTPSecure = $config['encryption'];
        }
        
        if (isset($config['auth']) && $config['auth']) {
            $this->mailer->SMTPAuth = true;
        }

        if (isset($config['debug'])) {
            $this->mailer->SMTPDebug = $config['debug'];
        }
    }

    /**
     * Set the sender information
     *
     * @param string $email Sender email address
     * @param string $name Sender name (optional)
     * @return self
     */
    public function from(string $email, string $name = ''): self
    {
        $this->mailer->setFrom($email, $name);
        return $this;
    }

    /**
     * Add a recipient
     *
     * @param string $email Recipient email address
     * @param string $name Recipient name (optional)
     * @return self
     */
    public function to(string $email, string $name = ''): self
    {
        $this->mailer->addAddress($email, $name);
        return $this;
    }

    /**
     * Add a CC recipient
     *
     * @param string $email CC email address
     * @param string $name CC name (optional)
     * @return self
     */
    public function cc(string $email, string $name = ''): self
    {
        $this->mailer->addCC($email, $name);
        return $this;
    }

    /**
     * Add a BCC recipient
     *
     * @param string $email BCC email address
     * @param string $name BCC name (optional)
     * @return self
     */
    public function bcc(string $email, string $name = ''): self
    {
        $this->mailer->addBCC($email, $name);
        return $this;
    }

    /**
     * Set email subject
     *
     * @param string $subject Email subject
     * @return self
     */
    public function subject(string $subject): self
    {
        $this->mailer->Subject = $subject;
        return $this;
    }

    /**
     * Set email body from markdown content
     *
     * @param string $markdown Markdown content
     * @return self
     */
    public function markdown(string $markdown): self
    {
        $html = $this->markdownConverter->convert($markdown)->getContent();
        $this->mailer->Body = $html;
        
        // Also set plain text version by stripping HTML tags
        $this->mailer->AltBody = strip_tags($html);
        
        return $this;
    }

    /**
     * Add an attachment
     *
     * @param string $path Path to the attachment file
     * @param string $name Optional name for the attachment
     * @return self
     */
    public function attach(string $path, string $name = ''): self
    {
        $this->mailer->addAttachment($path, $name);
        return $this;
    }

    /**
     * Send the email
     *
     * @return bool True if email was sent successfully
     * @throws PHPMailerException
     */
    public function send(): bool
    {
        return $this->mailer->send();
    }

    /**
     * Get the underlying PHPMailer instance for advanced configuration
     *
     * @return PHPMailer
     */
    public function getMailer(): PHPMailer
    {
        return $this->mailer;
    }

    /**
     * Clear all recipients, attachments, etc. for reuse
     *
     * @return self
     */
    public function reset(): self
    {
        $this->mailer->clearAllRecipients();
        $this->mailer->clearAttachments();
        $this->mailer->clearCustomHeaders();
        $this->mailer->clearReplyTos();
        $this->mailer->Subject = '';
        $this->mailer->Body = '';
        $this->mailer->AltBody = '';
        
        return $this;
    }
}