<?php

namespace LackProject\MdMail\Tests;

use LackProject\MdMail\MarkdownMailer;
use PHPUnit\Framework\TestCase;
use PHPMailer\PHPMailer\PHPMailer;

class MarkdownMailerTest extends TestCase
{
    private MarkdownMailer $mailer;

    protected function setUp(): void
    {
        $this->mailer = new MarkdownMailer();
    }

    public function testMarkdownConversion(): void
    {
        $markdown = '# Hello **World**!';
        $this->mailer->markdown($markdown);

        $phpMailer = $this->mailer->getMailer();
        
        $this->assertStringContainsString('<h1>Hello <strong>World</strong>!</h1>', $phpMailer->Body);
        $this->assertStringContainsString('Hello World!', $phpMailer->AltBody);
    }

    public function testFluentInterface(): void
    {
        $result = $this->mailer
            ->from('test@example.com', 'Test Sender')
            ->to('recipient@example.com', 'Test Recipient')
            ->subject('Test Subject')
            ->markdown('# Test Content');

        $this->assertInstanceOf(MarkdownMailer::class, $result);
        
        $phpMailer = $this->mailer->getMailer();
        $this->assertEquals('Test Subject', $phpMailer->Subject);
    }

    public function testMarkdownWithComplexContent(): void
    {
        $markdown = <<<'MD'
# Header 1

This is a paragraph with **bold** and *italic* text.

## Header 2

- List item 1
- List item 2

```php
$code = 'example';
```

> Quote block

[Link](https://example.com)
MD;

        $this->mailer->markdown($markdown);
        $phpMailer = $this->mailer->getMailer();

        // Check that HTML contains expected elements
        $this->assertStringContainsString('<h1>Header 1</h1>', $phpMailer->Body);
        $this->assertStringContainsString('<h2>Header 2</h2>', $phpMailer->Body);
        $this->assertStringContainsString('<strong>bold</strong>', $phpMailer->Body);
        $this->assertStringContainsString('<em>italic</em>', $phpMailer->Body);
        $this->assertStringContainsString('<ul>', $phpMailer->Body);
        $this->assertStringContainsString('<li>List item 1</li>', $phpMailer->Body);
        $this->assertStringContainsString('<pre><code', $phpMailer->Body);
        $this->assertStringContainsString('<blockquote>', $phpMailer->Body);
        $this->assertStringContainsString('<a href="https://example.com">Link</a>', $phpMailer->Body);

        // Check that plain text version is generated
        $this->assertStringContainsString('Header 1', $phpMailer->AltBody);
        $this->assertStringContainsString('bold', $phpMailer->AltBody);
        $this->assertStringContainsString('List item 1', $phpMailer->AltBody);
    }

    public function testReset(): void
    {
        // Set up initial state
        $this->mailer
            ->to('test@example.com')
            ->subject('Test')
            ->markdown('# Content');

        $phpMailer = $this->mailer->getMailer();
        
        // Verify initial state
        $this->assertEquals('Test', $phpMailer->Subject);
        $this->assertNotEmpty($phpMailer->Body);

        // Reset and verify
        $this->mailer->reset();
        
        $this->assertEquals('', $phpMailer->Subject);
        $this->assertEquals('', $phpMailer->Body);
        $this->assertEquals('', $phpMailer->AltBody);
    }

    public function testGetMailer(): void
    {
        $phpMailer = $this->mailer->getMailer();
        $this->assertInstanceOf(PHPMailer::class, $phpMailer);
    }

    public function testConfiguration(): void
    {
        $config = [
            'host' => 'test.smtp.com',
            'port' => 465,
            'username' => 'testuser',
            'password' => 'testpass',
            'encryption' => 'ssl',
            'auth' => true,
        ];

        $mailer = new MarkdownMailer($config);
        $phpMailer = $mailer->getMailer();

        $this->assertEquals('test.smtp.com', $phpMailer->Host);
        $this->assertEquals(465, $phpMailer->Port);
        $this->assertEquals('testuser', $phpMailer->Username);
        $this->assertEquals('testpass', $phpMailer->Password);
        $this->assertEquals('ssl', $phpMailer->SMTPSecure);
        $this->assertTrue($phpMailer->SMTPAuth);
    }
}