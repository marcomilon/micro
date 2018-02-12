<?php 

namespace micro;

/**
 * Trait is responsable to send the response to the browser. 
 * 
 * @author Marco Milon <marco.milon@gmail.com>
 */
trait Response 
{
 
    /**
     * Parse the value of the r parameter in the GET request.
     *
     * @param string $body is the content to be send to the browser
     * @param string $status is the status code
     */
  public function send($body, $status)
  {
      http_response_code($status);
      echo $body;
  }
 
}