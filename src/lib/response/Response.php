<?php

declare(strict_types=1);
namespace Response;

require_once(__DIR__ . '/../../app/config.php');
use function Config\get_lib_dir;

require_once(get_lib_dir() . '/utils/utils.php');
use function Utils\convert_to_string;

require_once(get_lib_dir() . '/cookie/cookie.php');
use Cookie\Cookie;

// ############################################################################
// Response Class
// ############################################################################

class Response
{
    public mixed   $body;
    public ?int    $status_code;
    public ?string $redirection_path;
    public array   $cookies;


    public function __construct(
        mixed   $body               = null,
        ?int    $status_code        = null,
        ?string $redirection_path   = null,
        array   $cookies            = []
    ) {

        $this->body             = $body;
        $this->status_code      = $status_code;
        $this->redirection_path = $redirection_path;
        $this->cookies          = $cookies;
    }

    // ------------------------------------------------------------------------
    public function __toString(): string
    {

        $body_str = convert_to_string($this->body);

        $response_str = <<<END

            Body:
            $body_str
            Status code:
            $this->status_code
            Redirection path:
            $this->redirection_path

            END;

        return $response_str;
    }

      // Short helper functions
    // ------------------------------------------------------------------------
    public function is_redirection():     bool { return  !is_null($this->redirection_path); }
    public function has_status_code():    bool { return  !is_null($this->status_code);      }
    public function has_body():           bool { return  !is_null($this->body);             }
    public function has_array_body():     bool { return (!is_null($this->body)) and (is_array($this->body)); }
    public function has_cookies():        bool { return (!empty($this->cookies));}  

    public function add_cookie(Cookie $cookie):void{
        array_push($this->cookies, $cookie);
    }

    public function set_cookies(): void {

        foreach ($this->cookies as $cookie) { 
            setcookie(  $cookie->name,
                        $cookie->value,
                        $cookie->expiration_date,
                        '/');
        }
    }

    // Redirection: https://stackoverflow.com/questions/768431/how-do-i-make-a-redirect-in-php
    // ------------------------------------------------------------------------
    public function send(): void {

        if ( $this->has_cookies()     ) { $this->set_cookies(); }
        if ( $this->is_redirection()  ) { header('Location: ' . $this->redirection_path); return; }
        if ( $this->has_status_code() ) { http_response_code($this->status_code); }
        if ( $this->has_array_body()  ) { header("Content-Type: application/json"); }
        if ( $this->has_body()        ) { $body_str = convert_to_string($this->body); echo $body_str; }

    }

}
