<?php

namespace lib\mail;

class Mail {
  
  protected static function send($to, $subject, $content, $type = "plain") {
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/'. $type .'; charset=utf-8' . "\r\n";
    $headers .= 'From: "FSC Bezannes" <contact@bezannes-fsc.fr>' . "\r\n";
    $headers .= 'Reply-To: contact@bezannes-fsc.fr'. "\r\n";
    
    return mail($to, $subject, $content, $headers);
  }

  public static function text($to, $subject, $body) {
    $body .= "

--
Foyer Social et Culturel de Bezannes
contact@bezannes-fsc.fr
http://beta.bezannes-fsc.fr
";
    return self::send($to, $subject .' – FSC Bezannes', $body);
  }
  public static function html($to, $subject, $html) {
    return self::send($to, $subject, $html, "html");
  }
  
}

?>