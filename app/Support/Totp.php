<?php

namespace App\Support;

class Totp
{
    // 30-second time step, 6 digits, SHA1
    public static function generateSecret(int $length = 20): string
    {
        $bytes = random_bytes($length);
        return self::base32Encode($bytes);
    }

    public static function otpauthUri(string $issuer, string $account, string $secret): string
    {
        $label = rawurlencode($issuer.':'.$account);
        $issuerParam = rawurlencode($issuer);
        return "otpauth://totp/{$label}?secret={$secret}&issuer={$issuerParam}&digits=6&period=30";
    }

    public static function verify(string $secret, string $code, int $window = 1): bool
    {
        $code = trim($code);
        if ($code === '' || !ctype_digit($code)) return false;
        $time = time();
        for ($i = -$window; $i <= $window; $i++) {
            if (self::totp($secret, $time + ($i * 30)) === $code) {
                return true;
            }
        }
        return false;
    }

    private static function totp(string $base32Secret, int $time): string
    {
        $counter = intdiv($time, 30);
        $secret = self::base32Decode($base32Secret);
        $binCounter = pack('N*', 0) . pack('N*', $counter);
        $hash = hash_hmac('sha1', $binCounter, $secret, true);
        $offset = ord(substr($hash, -1)) & 0x0F;
        $truncated = unpack('N', substr($hash, $offset, 4))[1] & 0x7FFFFFFF;
        $code = $truncated % 1000000;
        return str_pad((string)$code, 6, '0', STR_PAD_LEFT);
    }

    private static function base32Encode(string $data): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $bits = '';
        foreach (str_split($data) as $char) {
            $bits .= str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);
        }
        $chunks = str_split($bits, 5);
        $output = '';
        foreach ($chunks as $chunk) {
            if (strlen($chunk) < 5) {
                $chunk = str_pad($chunk, 5, '0', STR_PAD_RIGHT);
            }
            $output .= $alphabet[bindec($chunk)];
        }
        return rtrim($output, '=');
    }

    private static function base32Decode(string $b32): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $b32 = strtoupper($b32);
        $bits = '';
        foreach (str_split($b32) as $char) {
            $pos = strpos($alphabet, $char);
            if ($pos === false) continue;
            $bits .= str_pad(decbin($pos), 5, '0', STR_PAD_LEFT);
        }
        $bytes = '';
        $chunks = str_split($bits, 8);
        foreach ($chunks as $chunk) {
            if (strlen($chunk) === 8) {
                $bytes .= chr(bindec($chunk));
            }
        }
        return $bytes;
    }
}
