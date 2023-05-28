<?php

error_reporting(0);
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
ini_set('display_errors',0);

require_once('vendor/autoload.php');
use \Firebase\JWT\JWT;


$key = "project123";
$payload = array(
    "iss" => "http://example.org",
    "aud" => "http://example.com",
    "iat" => 1356999524,
    "nbf" => 1357000000
);

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 */
$jwt = JWT::encode($payload, $key);
$jwt = 'eyJhbGc1iOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOnsiaWQiOjEsIm5hbWUiOiJhZG1pbiIsImVtYWlsIjoiYWRtaW5AYWRtaW4uY29tIiwiZW1haWxfdmVyaWZpZWRfYXQiOm51bGwsImNyZWF0ZWRfYXQiOiIyMDIwLTA0LTI1VDA2OjM5OjAwLjAwMDAwMFoiLCJ1cGRhdGVkX2F0IjoiMjAyMC0wNC0yNVQwNjozOTowMC4wMDAwMDBaIn0sImlhdCI6MTU5MTc5MjExMH0.3M4rxpF59kI_b7ke4uAVqYG-Qytm3rnc0zFO9NvZK90';
$check='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiYWRtaW4iLCJlbWFpbCI6ImFkbWluQGFkbWluLmNvbSIsImlhdCI6MTM1Njk5OTUyNCwibmJmIjoxMzU3MDAwMDAwfQ.I4jY1qWoCcLW_HOLrLoADcNdOtjKou68LUwMQQGc3aA';
$key='project123';
$decoded = JWT::decode($jwt, $key, array('HS256'));

$decoded = JWT::decode($jwt,"project123", ['HS256']);



echo '<pre/>';
print_r($decoded);
die();




$privateKey = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
-----END RSA PRIVATE KEY-----
EOD;

$publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8kGa1pSjbSYZVebtTRBLxBz5H
4i2p/llLCrEeQhta5kaQu/RnvuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t
0tyazyZ8JXw+KgXTxldMPEL95+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4
ehde/zUxo6UvS7UrBQIDAQAB
-----END PUBLIC KEY-----
EOD;

$payload = array(
   /* "username"  => "jahan",
    "password"  => "123456",*/
    "iss" => "example.org",
    "aud" => "example.com",
    "iat" => 1356999524,
    "nbf" => 1357000000
);

$jwt = JWT::encode($payload, $privateKey, 'RS256');

echo "<pre>";

echo "Encode:\n" . print_r($jwt, true) . "\n";

$decoded = JWT::decode($jwt, $publicKey, array('RS256'));

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/
echo "<br>";

$decoded_array = (array) $decoded;
echo "Decode:\n" . print_r($decoded_array, true) . "\n";