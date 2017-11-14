<?php 

namespace micro;

trait Response {
 
  public function send($body, $status)
  {
      http_response_code($status);
      echo $body;
  }
 
}