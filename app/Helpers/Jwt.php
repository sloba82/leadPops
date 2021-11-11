<?php

namespace App\Helpers;

class Jwt
{

    /**
     * Set optional params
     */
    public $payload = [];

    /**
     * Set type of token and algorithm
     */
    public $headers = [
        'alg' => 'HS256',
        'typ' => 'JWT',
    ];

    /**
     * Set token expiration in minutes
     */
    public $expires = 10;

    /**
     * For jwt secret APP_KEY is used
     */

    private $secret;

    public function __construct()
    {
        $this->secret = env('APP_KEY');
    }

    /**
     * Generate jwt token
     *
     * @param $name is optional
     * @return string
     */
    public function generate($name = null)
    {
        if ($name) {
            $this->payload['name'] = $name;
        }

        $this->payload['exp'] = (time() + $this->expires * 60);

        $headers_encoded = $this->base64url_encode(json_encode($this->headers));
        $payload_encoded = $this->base64url_encode(json_encode($this->payload));

        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $this->secret, true);
        $signature_encoded = $this->base64url_encode($signature);

        $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";

        return $jwt;
    }

    /**
     * Validate jwt token
     *
     * @param $jwt token
     * @return bool
     */
    public function validate($jwt)
    {
        $secret = $this->secret;

        // Split the jwt
        $tokenParts = explode('.', $jwt);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signature_provided = $tokenParts[2];

        // Check the expiration time - note this will cause an error if there is no 'exp' claim in the jwt
        $expiration = json_decode($payload)->exp;
        $is_token_expired = ($expiration - time()) < 0;

        // Build a signature based on the header and payload using the secret
        $base64_url_header = $this->base64url_encode($header);
        $base64_url_payload = $this->base64url_encode($payload);
        $signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $secret, true);
        $base64_url_signature = $this->base64url_encode($signature);

        // Verify it matches the signature provided in the jwt
        $is_signature_valid = ($base64_url_signature === $signature_provided);

        if ($is_token_expired || !$is_signature_valid) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Remove special characters
     */
    private function base64url_encode($str)
    {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }
}
