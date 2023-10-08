# Usages 

Streamline PHP Development with php-helpers – Your Go-To Toolkit for Common Tasks

### `json_message(string $message = null, bool $success = true)`

This function outputs a JSON-formatted message. It takes an optional message string and a success boolean parameter. It sends a JSON response with the provided message and success status.

**Usage Example:**

```php
// Output a success message
Util::json_message("Operation completed successfully", true);
```

### `redirect_to(string $url)`

This function redirects the user to the specified URL. It checks if headers are already sent and handles the redirection accordingly.

**Usage Example:**

```php
// Redirect to the homepage
Util::redirect_to("/home");
```

### `get_current_url(): string`

Returns the current URL as a string.

**Usage Example:**

```php
// Get the current URL
$currentUrl = Util::get_current_url();
echo "Current URL: $currentUrl";
```

### `is_ajax_request(): bool`

Checks if the current request is an AJAX request and returns a boolean value accordingly.

**Usage Example:**

```php
// Check if the request is AJAX
$isAjax = Util::is_ajax_request();
if ($isAjax) {
    echo "This is an AJAX request";
} else {
    echo "This is not an AJAX request";
}
```

### `set_value(string $field, string $default = '', bool $escape = true): string`

Retrieves a value from the POST array based on the provided field name. It also allows you to escape the value for security.

**Usage Example:**

```php
// Get a value from the POST array and escape it
$username = Util::set_value("username", "", true);
echo "Username: $username";
```

### `gravatar(string $email, int|string $size = 80, string $default = 'mm', string $rating = 'g'): string`

Generates a Gravatar URL based on the provided email, size, default image, and rating.

**Usage Example:**

```php
// Generate a Gravatar URL for a user's email
$email = "user@example.com";
$gravatarUrl = Util::gravatar($email, 120, 'identicon', 'pg');
echo "Gravatar URL: $gravatarUrl";
```

### `avatar(string $name): string`

Generates a URL for a default profile photo based on the provided name.

**Usage Example:**

```php
// Generate an avatar URL for a user's name
$userName = "John Doe";
$avatarUrl = Util::avatar($userName);
echo "Avatar URL: $avatarUrl";
```

### `escape(string $value): string`

Escapes HTML entities in a string for security.

**Usage Example:**

```php
// Escape a user input before displaying it
$userInput = "<script>alert('XSS Attack');</script>";
$escapedInput = Util::escape($userInput);
echo "Escaped Input: $escapedInput";
```

### `csrf_input(): mixed`

Generates a hidden input field for CSRF protection.

**Usage Example:**

```php
// Include the CSRF token in a form
$csrfInput = Util::csrf_input();
echo "<form>$csrfInput</form>";
```

### `csrf_meta(): mixed`

Generates a CSRF token as a meta tag.

**Usage Example:**

```php
// Include the CSRF token in the HTML head
$csrfMeta = Util::csrf_meta();
echo "<head>$csrfMeta</head>";
```

### `csrf_filter(): bool|string`

Checks if the input token matches the session token for CSRF protection.

**Usage Example:**

```php
// Validate CSRF token for a POST request
if (Util::csrf_filter()) {
    echo "CSRF token is valid";
} else {
    echo "CSRF token is invalid";
}
```

### `csrf_token(): string`

Retrieves the CSRF token value.

**Usage Example:**

```php
// Get the current CSRF token
$token = Util::csrf_token();
echo "CSRF Token: $token";
```

### `array_set(array &$array, string $key, mixed $value): array`

Sets an array item to a given value using "dot" notation.

**Usage Example:**

```php
// Set a value in a nested array using dot notation
$data = [];
Util::array_set($data, "user.name", "John Doe");
print_r($data);
```

### `array_forget(array &$array, string $key): void`

Removes an array item using "dot" notation.

**Usage Example:**

```php
// Remove a value from a nested array using dot notation
$data = ["user" => ["name" => "John Doe"]];
Util::array_forget($data, "user.name");
print_r($data);
```

### `array_get(array $array, string $key, mixed $default = null): mixed`

Retrieves an item from an array using "dot" notation.

**Usage Example:**

```php
// Get a value from a nested array using dot notation
$data = ["user" => ["name" => "John Doe"]];
$value = Util::array_get($data, "user.name");
echo "User Name: $value";
```

### `set_select(string $field, string $value = '', bool $default = false): string`

Generates the "selected" attribute for a select input based on the provided field and value.

**Usage Example:**

```php
// Generate "selected" attribute for a select input
$selected = Util::set_select("gender", "male", true);
echo "<select><option value='male'$selected>Male</option></select>";
```

### `set_checkbox(string $value, bool $default = false, string $field = ''): string`

Generates the "checked" attribute for a checkbox input based on the provided value and field.

**Usage Example:**

```php
// Generate "checked" attribute for a checkbox input
$checked = Util::set_checkbox("subscribe", true, "newsletter");
echo "<input type='checkbox' name='newsletter'$checked>";
```

### `set_radio(string $field, string $value = '', bool $default = false): string`

Generates the "checked" attribute for a radio input based on the provided field and value.

**Usage Example:**

```php
// Generate "checked" attribute for a radio input
$checked = Util::set_radio("gender", "male", false);
echo "<input type='radio' name='gender' value='male'$checked>Male";
```

### `sanitize_key(string $key): string`

Sanitizes a string key.

**Usage Example:**

```php
// Sanitize a string key
$dirtyKey = "user@123";
$sanitizedKey = Util::sanitize_key($dirtyKey);
echo "Sanitized Key: $sanitizedKey";
```

### `maybe_decode(string $original, bool $assoc = true): mixed`

Decodes a value if it was encoded to JSON.

**Usage Example:**

```php
// Decode a JSON-encoded string
$jsonString = '{"name": "John", "age": 30}';
$data = Util::maybe_decode($jsonString);
print_r($data);
```

### `maybe_encode(mixed

$data): mixed`

Encodes data to JSON if needed.

**Usage Example:**

```php
// Encode an array to JSON if it's not already JSON
$data = ["name" => "John", "age" => 30];
$encodedData = Util::maybe_encode($data);
echo "Encoded Data: $encodedData";
```

### `is_serialized(string $data, bool $strict = true): bool`

Checks if a value is serialized.

**Usage Example:**

```php
// Check if a string is serialized
$serializedData = 'a:2:{s:4:"name";s:4:"John";s:3:"age";i:30;}';
$isSerialized = Util::is_serialized($serializedData);
echo $isSerialized ? "Serialized" : "Not Serialized";
```

### `maybe_unserialize(string $original): mixed`

Unserializes a value if it was serialized.

**Usage Example:**

```php
// Unserialize a serialized string
$serializedData = 'a:2:{s:4:"name";s:4:"John";s:3:"age";i:30;}';
$data = Util::maybe_unserialize($serializedData);
print_r($data);
```

### `maybe_serialize(mixed $data): mixed`

Serializes data if needed.

**Usage Example:**

```php
// Serialize an array if it's not already serialized
$data = ["name" => "John", "age" => 30];
$serializedData = Util::maybe_serialize($data);
echo "Serialized Data: $serializedData";
```

### `array_first(array $array, Closure $callback, mixed $default = null): mixed`

Returns the first element in an array passing a given truth test.

**Usage Example:**

```php
// Find the first even number in an array
$numbers = [1, 3, 5, 2, 4, 6];
$even = Util::array_first($numbers, function($key, $value) {
    return $value % 2 === 0;
});
echo "First Even Number: $even";
```

### `head(array $array): mixed`

Gets the first element of an array.

**Usage Example:**

```php
// Get the first element of an array
$fruits = ["apple", "banana", "cherry"];
$firstFruit = Util::head($fruits);
echo "First Fruit: $firstFruit";
```

### `str_is(string $pattern, string $value): bool`

Determines if a given string matches a given pattern.

**Usage Example:**

```php
// Check if a string matches a pattern
$pattern = "user_*";
$string = "user_profile";
$matchesPattern = Util::str_is($pattern, $string);
echo $matchesPattern ? "Matches Pattern" : "Doesn't Match Pattern";
```

### `str_contains(string $haystack, array|string $needles): bool`

Determines if a given string contains a given substring.

**Usage Example:**

```php
// Check if a string contains a substring
$haystack = "Hello, world!";
$needle = "world";
$containsSubstring = Util::str_contains($haystack, $needle);
echo $containsSubstring ? "Contains Substring" : "Doesn't Contain Substring";
```

### `studly_case(string $value): string`

Converts a value to studly caps case.

**Usage Example:**

```php
// Convert a string to studly caps case
$string = "hello_world";
$studlyString = Util::studly_case($string);
echo "Studly String: $studlyString";
```

### `snake_case($value, string $delimiter = '_'): string`

Converts a string to snake case.

**Usage Example:**

```php
// Convert a string to snake case
$string = "HelloWorld";
$snakeString = Util::snake_case($string);
echo "Snake String: $snakeString";
```

### `starts_with(string $haystack, $needles): bool`

Determines if a given string starts with a given substring.

**Usage Example:**

```php
// Check if a string starts with a substring
$haystack = "Hello, world!";
$substring = "Hello";
$startsWith = Util::starts_with($haystack, $substring);
echo $startsWith ? "Starts With Substring" : "Doesn't Start With Substring";
```

### `str_random(int $length = 16): string`

Generates a random alpha-numeric string.

**Usage Example:**

```php
// Generate a random string
$randomString = Util::str_random(10);
echo "Random String: $randomString";
```

### `with(mixed $object): mixed`

Returns the given object.

**Usage Example:**

```php
// Use the with function to return an object
$data = ["name" => "John"];
$object = Util::with($data);
print_r($object);
```

### `absint(mixed $value): int`

Converts a value to a non-negative integer.

**Usage Example:**

```php
// Convert a value to a non-negative integer
$number = -10;
$absint = Util::absint($number);
echo "Absolute Integer: $absint";
```

These are the functions provided by the `Util` class, along with usage examples for each of them.

[See changelog...](/docs/changelog.md)