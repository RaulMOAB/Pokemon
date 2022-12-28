<?php

declare(strict_types=1);

namespace Request;


// ############################################################################
// Request helper functions
// ############################################################################

// ----------------------------------------------------------------------------
function get_canonical_path(string $url_path): string
{

    $url_path_sanitized = filter_var($url_path, FILTER_SANITIZE_URL);
    $url_path_trimmed   = rtrim($url_path_sanitized, '/');

    $result = $url_path_trimmed;
    return $result;
}

class Request
{
    public string $path;
    public string $method;
    public array  $parameters;

    function __construct(string $url_path = "/", string $method = "GET", array $parameters = [])
    {
        $this->path       = get_canonical_path($url_path);
        $this->method     = $method;
        $this->parameters = $parameters;
    }

   public static function getFromWebServer(): self
    {
        $url_path_and_query = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $url_path           = urldecode(parse_url($url_path_and_query, PHP_URL_PATH));
        $method     = $_SERVER["REQUEST_METHOD"];
        $parameters = array_merge($_GET, $_POST, $_COOKIE);

        $request    = new Request($url_path, $method, $parameters);

        return $request;
    }

    // ------------------------------------------------------------------------
    public function __toString(): string
    {

        $parameters_json_str = json_encode($this->parameters, JSON_PRETTY_PRINT);

        $request_str = <<<END

            Method: $this->method
            Path:   $this->path
            Parameters: $parameters_json_str

            END;

        return $request_str;
    }
}
