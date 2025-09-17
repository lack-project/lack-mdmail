<?php

namespace LackProject\MdMail\Tests;

use PHPUnit\Framework\TestCase;
use LackProject\MdMail\MdMailer;
use LackProject\MdMail\MdMailerConfig;
use PHPMailer\PHPMailer\PHPMailer;

class MdMailerTest extends TestCase
{
    public function testMdMailerInstantiation()
    {
        $config = [
            'host' => 'smtp.example.com',
            'port' => 587,
            'username' => 'test@example.com',
            'password' => 'password',
            'encryption' => PHPMailer::ENCRYPTION_STARTTLS,
            'auth' => true
        ];

        $mailer = new MdMailer($config);
        
        $this->assertInstanceOf(MdMailer::class, $mailer);
        $this->assertInstanceOf(PHPMailer::class, $mailer->getMailer());
    }

    public function testMdMailerConfigGmail()
    {
        $config = MdMailerConfig::gmail('test@gmail.com', 'password');
        
        $this->assertEquals('smtp.gmail.com', $config['host']);
        $this->assertEquals(587, $config['port']);
        $this->assertEquals('test@gmail.com', $config['username']);
        $this->assertEquals('password', $config['password']);
        $this->assertEquals('tls', $config['encryption']);
        $this->assertTrue($config['auth']);
    }

    public function testMdMailerConfigOutlook()
    {
        $config = MdMailerConfig::outlook('test@outlook.com', 'password');
        
        $this->assertEquals('smtp-mail.outlook.com', $config['host']);
        $this->assertEquals(587, $config['port']);
        $this->assertEquals('test@outlook.com', $config['username']);
    }

    public function testMdMailerConfigYahoo()
    {
        $config = MdMailerConfig::yahoo('test@yahoo.com', 'password');
        
        $this->assertEquals('smtp.mail.yahoo.com', $config['host']);
        $this->assertEquals(587, $config['port']);
        $this->assertEquals('test@yahoo.com', $config['username']);
    }

    public function testMdMailerConfigCustom()
    {
        $config = MdMailerConfig::custom(
            'smtp.custom.com',
            465,
            'user@custom.com',
            'secret',
            'ssl',
            true
        );
        
        $this->assertEquals('smtp.custom.com', $config['host']);
        $this->assertEquals(465, $config['port']);
        $this->assertEquals('user@custom.com', $config['username']);
        $this->assertEquals('secret', $config['password']);
        $this->assertEquals('ssl', $config['encryption']);
        $this->assertTrue($config['auth']);
    }

    public function testMdMailerMethodsExist()
    {
        $mailer = new MdMailer();
        
        $this->assertTrue(method_exists($mailer, 'send'));
        $this->assertTrue(method_exists($mailer, 'sendToMultiple'));
        $this->assertTrue(method_exists($mailer, 'addAttachment'));
        $this->assertTrue(method_exists($mailer, 'setPriority'));
        $this->assertTrue(method_exists($mailer, 'addCC'));
        $this->assertTrue(method_exists($mailer, 'addBCC'));
        $this->assertTrue(method_exists($mailer, 'setReplyTo'));
        $this->assertTrue(method_exists($mailer, 'testConnection'));
        $this->assertTrue(method_exists($mailer, 'getLastError'));
        $this->assertTrue(method_exists($mailer, 'getMailer'));
    }
}