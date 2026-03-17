<?php

namespace App\Helpers;

class AwsSesHelper
{
    /**
     * Convert AWS Secret Access Key to SMTP Password for AWS SES
     * 
     * AWS SES SMTP requires the password to be calculated from the secret access key
     * using a specific HMAC-SHA256 signature process.
     *
     * @param string $secretKey The AWS Secret Access Key
     * @param string $region The AWS region (e.g., 'us-east-1')
     * @return string The SMTP password
     */
    public static function generateSmtpPassword($secretKey, $region = 'us-east-1')
    {
        $version = "\x04";
        $signature = "SendEmail";
        $date = gmdate('Ymd');
        
        // Step 1: Derive the signing key
        $kDate = hash_hmac('sha256', $date, 'AWS4' . $secretKey, true);
        $kRegion = hash_hmac('sha256', $region, $kDate, true);
        $kService = hash_hmac('sha256', 'ses', $kRegion, true);
        $kSigning = hash_hmac('sha256', 'aws4_request', $kService, true);
        
        // Step 2: Calculate the signature
        $signature = hash_hmac('sha256', $signature, $kSigning, true);
        
        // Step 3: Prepend the version byte
        $smtpPassword = $version . $signature;
        
        // Step 4: Base64 encode
        return base64_encode($smtpPassword);
    }
}
