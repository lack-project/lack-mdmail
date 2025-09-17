<?php

namespace LackProject\MdMail;

/**
 * Configuration class for MdMailer
 */
class MdMailerConfig
{
    /**
     * Create Gmail configuration
     * 
     * @param string $username Gmail username
     * @param string $password Gmail app password
     * @return array
     */
    public static function gmail(string $username, string $password): array
    {
        return [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username' => $username,
            'password' => $password,
            'encryption' => 'tls',
            'auth' => true
        ];
    }

    /**
     * Create Outlook/Hotmail configuration
     * 
     * @param string $username Outlook username
     * @param string $password Outlook password
     * @return array
     */
    public static function outlook(string $username, string $password): array
    {
        return [
            'host' => 'smtp-mail.outlook.com',
            'port' => 587,
            'username' => $username,
            'password' => $password,
            'encryption' => 'tls',
            'auth' => true
        ];
    }

    /**
     * Create Yahoo configuration
     * 
     * @param string $username Yahoo username
     * @param string $password Yahoo app password
     * @return array
     */
    public static function yahoo(string $username, string $password): array
    {
        return [
            'host' => 'smtp.mail.yahoo.com',
            'port' => 587,
            'username' => $username,
            'password' => $password,
            'encryption' => 'tls',
            'auth' => true
        ];
    }

    /**
     * Create custom SMTP configuration
     * 
     * @param string $host SMTP host
     * @param int $port SMTP port
     * @param string $username Username
     * @param string $password Password
     * @param string $encryption Encryption type (tls, ssl, or empty)
     * @param bool $auth Whether to use authentication
     * @return array
     */
    public static function custom(
        string $host, 
        int $port, 
        string $username, 
        string $password, 
        string $encryption = 'tls', 
        bool $auth = true
    ): array {
        return [
            'host' => $host,
            'port' => $port,
            'username' => $username,
            'password' => $password,
            'encryption' => $encryption,
            'auth' => $auth
        ];
    }
}