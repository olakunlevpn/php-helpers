<?php

namespace Olakunlevpn\PhpHelpers;


use Closure;
use Olakunlevpn\PhpHelpers\Session\Store;
use Olakunlevpn\PhpHelpers\Support\Str;

class Util
{

    /**
     * Output JSON formatted message.
     *
     * @param string|null $message
     * @param bool $success
     * @return void
     */

   public static function json_message(string $message = null, bool $success = true): void
    {
        header('Content-Type: application/json');

        echo json_encode(compact('message', 'success'));

        exit;
    }




    /**
     * Redirect to given URL.
     *
     * @param  string  $url
     * @return void
     */

   public static function redirect_to(string $url): void
   {

        if (headers_sent()) {
            echo '<html lang="en"><body onload="redirect_to(\''.$url.'\');"></body>'.
                '<script type="text/javascript">function redirect_to(url) {window.location.href = url}</script>'.
                '</body></html>';
        } else {
            header('Location:' . $url);
        }

        exit;
    }



    /**
     * Get the current url.
     *
     * @return string
     */
    public static  function get_current_url(): string
    {
        $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        return ($https ? 'https://' : 'http://') . (!empty($_SERVER['REMOTE_USER']) ?
                $_SERVER['REMOTE_USER'].'@' : '') . ($_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] .
                ($https && $_SERVER['SERVER_PORT'] === 443 || $_SERVER['SERVER_PORT'] === 80 ? '' :
                    ':' . $_SERVER['SERVER_PORT']))).$_SERVER['REQUEST_URI'];
    }


    /**
     * Check if is an ajax request.
     *
     * @return bool
     */
    public static function is_ajax_request(): bool
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    private static function value(mixed $default)
    {
        return $default;
    }


    /**
     * Get the value from the POST array.
     *
     * @param string $field
     * @param string $default
     * @param bool $escape
     * @return	string
     */
    function set_value(string $field, string $default = '', bool $escape = true): string
    {
        if (isset($_POST[$field])) {
            return $escape ? self::escape($_POST[$field]) : $_POST[$field];
        }

        return $default;
    }
    
    
    /**
     * Get Gravatar URL for a specified email address.
     *
     * @param string $email
     * @param int|string $size
     * @param string $default  Default image to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $rating   Maximum rating (inclusive) [ g | pg | r | x ]
     * @return string
     */
    public static function gravatar(string $email, int|string $size = 80, string $default = 'mm', string $rating = 'g'): string
    {
        $url = 'https://www.gravatar.com/avatar/';

        $url .= md5(strtolower(trim($email)));

        $url .= "?s=$size&d=$default&r=$rating";

        return $url;
    }


    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @param string $name
     * @return string
     */
    public static function avatar(string $name): string
    {
        $name = trim(implode(' ', array_map(function($segment) {
            return mb_substr($segment, 0, 1);
        }, explode(' ', $name))));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Escape HTML entities in a string.
     *
     * @param string $value
     * @return string
     */
    public static function escape(string $value): string
    {
        return trim(htmlentities($value, ENT_QUOTES, 'UTF-8'));
    }


    /**
     * Echo the CSRF input.
     *
     * @return mixed
     */
    public static function csrf_input(): mixed
    {
        return '<input type="hidden" name="_token" value="'.self::csrf_token().'">';
    }


    /**
     * Echo the CSRF  head meta.
     *
     * @return mixed
     */

    public static function csrf_meta(): mixed
    {
        return '<meta name="csrf-token" content="'.self::csrf_token().'">';
    }


    /**
     * Check if input token match session token.
     *
     * @return string
     */
    public static function csrf_filter(): bool|string
    {

        $check = isset($_POST['_token']) && $_POST['_token'] == self::csrf_token();

        $session = new Store();
        $session->regenerateToken();

        return $check;
    }



    /**
     * Get the CSRF token value.
     *
     * @return string
     */
    public static function csrf_token(): string
    {
        $session = new Store();
        return $session->start()->token();
    }



    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param array $array
     * @param string $key
     * @param  mixed   $value
     * @return array
     */
    public static function array_set(array &$array, string $key, mixed $value): array
    {

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if ( ! isset($array[$key]) || ! is_array($array[$key])) {
                $array[$key] = array();
            }

            $array =& $array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }


    /**
     * Remove an array item from a given array using "dot" notation.
     *
     * @param array $array
     * @param string $key
     * @return void
     */
    public static function array_forget(array &$array, string $key): void
    {
        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if ( ! isset($array[$key]) || ! is_array($array[$key])) {
                return;
            }

            $array =& $array[$key];
        }

        unset($array[array_shift($keys)]);
    }



    /**
     * Get an item from an array using "dot" notation.
     *
     * @param array $array
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public static function array_get(array $array, string $key, mixed $default = null): mixed
    {

        if (isset($array[$key])) return $array[$key];

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || ! array_key_exists($segment, $array)) {
                return $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }


     /**
     * Get te selected value of <select> from the POST array.
     *
     * @param string $field
     * @param string $value
     * @param bool $default
     * @return	string
     */
    public static function set_select(string $field, string $value = '', bool $default = false): string
    {
        if (isset($_POST[$field]) && $_POST[$field] == (string) $value) {
            return ' selected="selected"';
        }

        return $default ? ' selected="selected"' : '';
    }

    /**
     * Get the selected value of a checkbox input from the POST array.
     *
     * @param string $field
     * @param string $value
     * @param bool $default
     * @return	string
     */
    public static function set_checkbox(string $value, bool $default = false, string $field = ''): string
    {
        if (isset($_POST[$field]) && $_POST[$field] == (string) $value) {
            return ' checked="checked"';
        }

        return $default ? ' checked="checked"' : '';
    }


    /**
     * Get the selected value of a radio input from the POST array.
     *
     * @param string $field
     * @param string $value
     * @param bool $default
     * @return	string
     */
    public static function set_radio(string $field, string $value = '', bool $default = false): string
    {
        if (isset($_POST[$field]) && $_POST[$field] == (string) $value) {
            return ' checked="checked"';
        }

        return $default ? ' checked="checked"' : '';
    }

    /**
     * Sanitizes a string key.
     *
     * @param string $key String key
     * @return string Sanitized key
     */
    public static function sanitize_key(string $key): string
    {
        $key = strtolower($key);

        return preg_replace('/[^a-z0-9_\-]/', '', $key);
    }


    /**
     * Decode value only if it was encoded to JSON.
     *
     * @param string $original
     * @param bool $assoc
     * @return mixed
     */
    public static function maybe_decode(string $original, bool $assoc = true): mixed
    {
        if (is_numeric($original)) return $original;

        $data = json_decode($original, $assoc);

        return (is_object($data) || is_array($data)) ? $data : $original;
    }

    /**
     * Encode data to JSON, if needed.
     *
     * @param  mixed  $data
     * @return mixed
     */
     public static function maybe_encode(mixed $data): mixed
     {
        if (is_array($data) || is_object($data)) {
            return json_encode($data);
        }

        return $data;
     }

    /**
     * Check value to find if it was serialized.
     *
     * @param string $data
     * @param bool $strict
     * @return bool
     */
    public static function is_serialized(string $data, bool $strict = true ): bool
    {

        $data = trim($data);

        if ('N;' == $data) return true;
        if (strlen($data) < 4) return false;
        if (':' !== $data[1]) return false;

        if ($strict) {
            $lastc = substr($data, -1);

            if (';' !== $lastc && '}' !== $lastc) {
                return false;
            }
        } else {
            $semicolon = strpos($data, ';');
            $brace     = strpos($data, '}');

            if (false === $semicolon && false === $brace) return false;
            if (false !== $semicolon && $semicolon < 3) return false;
            if (false !== $brace && $brace < 4) return false;
        }

        $token = $data[0];

        switch ($token) {
            case 's' :
                if ($strict) {
                    if ('"' !== substr($data, -2, 1)) {
                        return false;
                    }
                } elseif ( ! str_contains($data, '"')) {
                    return false;
                }
            case 'a' :
            case 'O' :
                return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b' :
            case 'i' :
            case 'd' :
                $end = $strict ? '$' : '';
                return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
        }

        return false;
    }



    /**
     * Unserialize value only if it was serialized.
     *
     * @param string $original
     * @return mixed
     */
    public  static function maybe_unserialize(string $original): mixed
    {
        if (self::is_serialized($original)) {
            return @unserialize( $original );
        }

        return $original;
    }



    /**
     * Serialize data, if needed.
     *
     * @param  mixed  $data
     * @return mixed
     */
    public static function maybe_serialize(mixed $data): mixed
    {
        if (is_array($data) || is_object($data)) {
            return serialize($data);
        }

        return $data;
    }


    /**
     * Return the first element in an array passing a given truth test.
     *
     * @param array $array
     * @param Closure $callback
     * @param mixed|null $default
     * @return mixed
     */
    public static function array_first(array $array, Closure $callback, mixed $default = null): mixed
    {
        foreach ($array as $key => $value) {
            if (call_user_func($callback, $key, $value)) return $value;
        }

        return self::value($default);
    }


    /**
     * Get the first element of an array.
     *
     * @param array $array
     * @return mixed
     */
    public static function head(array $array): mixed
    {
        return reset($array);
    }


    /**
     * Determine if a given string matches a given pattern.
     *
     * @param string $pattern
     * @param string $value
     * @return bool
     */
    public static function str_is(string $pattern, string $value): bool
    {
        return Str::is($pattern, $value);
    }


    /**
     * Determine if a given string contains a given substring.
     *
     * @param string $haystack
     * @param array|string $needles
     * @return bool
     */
    public static function str_contains(string $haystack, array|string $needles): bool
    {
        return Str::contains($haystack, $needles);
    }



    /**
     * Convert a value to studly caps case.
     *
     * @param string $value
     * @return string
     */
    public static function studly_case(string $value): string
    {
        return Str::studly($value);
    }


    /**
     * Convert a string to snake case.
     *
     * @param  string  $value
     * @param string $delimiter
     * @return string
     */
    public static function snake_case($value, string $delimiter = '_'): string
    {
        return Str::snake($value, $delimiter);
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string $haystack
     * @param $needles
     * @return bool
     */
    public static function starts_with(string $haystack, $needles): bool
    {
        return Str::contains($haystack, $needles);
    }

    /**
     * Generate a "random" alpha-numeric string.
     *
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public static function str_random(int $length = 16): string
    {
        return Str::random($length);
    }
    /**
     * Return the given object.
     *
     * @param  mixed  $object
     * @return mixed
     */
    public static function with(mixed $object): mixed
    {
        return $object;
    }
    /**
     * Convert a value to non-negative integer.
     *
     * @param  mixed $value
     * @return int
     */
    public static function absint(mixed $value): int
    {
        return abs(intval($value));
    }
    
}