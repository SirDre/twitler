<?php

// PHP Twitter OAuth classes

 class OAuthException extends Exception {
  
}

class OAuthConsumer {
  public $key;
  public $secret;

  function __construct($key, $secret, $callback_url=NULL) {
    $this->key = $key;
    $this->secret = $secret;
    $this->callback_url = $callback_url;
  }

  function __toString() {
    return "OAuthConsumer[key=$this->key,secret=$this->secret]";
  }
}

class OAuthToken {
  // access tokens and request tokens
  public $key;
  public $secret;

  /**
   * key = the token
   * secret = the token secret
   */
  function __construct($key, $secret) {
    $this->key = $key;
    $this->secret = $secret;
  }

  /**
   * generates the basic string serialization of a token that a server
   * would respond to request_token and access_token calls with
   */
  function to_string() {
    return "oauth_token=" .
           OAuthUtil::urlencode_rfc3986($this->key) .
           "&oauth_token_secret=" .
           OAuthUtil::urlencode_rfc3986($this->secret);
  }

  function __toString() {
    return $this->to_string();
  }
}

?>
