# php-helpers

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

`php-helpers` is a PHP utility library that provides a collection of useful functions to simplify common tasks in PHP development.

## Features

- **JSON Handling**: Easily generate JSON responses with the `json_message` function.
- **Redirects**: Manage redirects, even when headers are already sent, using the `redirect_to` function.
- **URL Manipulation**: Get the current URL, check for AJAX requests, and work with URLs effortlessly.
- **Gravatar Integration**: Generate Gravatar URLs for user avatars.
- **Security**: Handle CSRF tokens and input data sanitization.
- **Array Manipulation**: Manipulate arrays using dot notation with `array_set`, `array_forget`, and `array_get`.
- **String Operations**: Perform various string operations like case conversions and substring checks.
- And more.....


## Installation

You can easily install `php-helpers` using Composer. Run the following command in your project directory:

```bash
composer require olakunlevpn/php-helpers
```

After installing, you can include the `Util` class in your PHP scripts where you need its functionalities.

```php
require_once('vendor/autoload.php');

use Olakunlevpn\PhpHelpers\Util;

// Now you can use Util:: functions
```

## Usage

Here are some examples of how to use the functions provided by `php-helpers`:

```php
// Generate a JSON response
Util::json_message("Operation completed successfully", true);

// Redirect to a specific URL
Util::redirect_to("/home");

// Get the current URL
$currentUrl = Util::get_current_url();

// Check if it's an AJAX request
$isAjax = Util::is_ajax_request();

// Generate a Gravatar URL
$gravatarUrl = Util::gravatar("user@example.com", 120, 'identicon', 'pg');


// Generate a avatar with first name and last name
$avatarUrl = Util::avatar("John Timothy");



// Sanitize a string key
$sanitizedKey = Util::sanitize_key("user@123");

// Perform string operations
$studlyString = Util::studly_case("hello_world");
```

For more details and examples, please refer to the [docs](docs/introduction.md).

## License

This project is open-source and available under the [MIT License](LICENSE).

Feel free to contribute, report issues, or suggest improvements. Your feedback is valuable!


Happy coding with `php-helpers`!


This updated README provides clear instructions on how users can install `php-helpers` using Composer. Users simply need to run the `composer require` command in their project directory to include the library, and then they can use it in their PHP scripts as shown in the usage examples.


