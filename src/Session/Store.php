<?php

namespace Olakunlevpn\PhpHelpers\Session;

use Olakunlevpn\PhpHelpers\Util;
use ReturnTypeWillChange;

class Store implements \ArrayAccess
{


    /**
     * Start the session.
     *
     * @return Store
     */
    public function start(): static
    {
        if (!$this->getId()) {
            session_start();
        }

        if (!$this->has('_token')) $this->regenerateToken();

        return $this;
    }

    /**
     * Get the current session id.
     *
     * @return string
     */
    public function getId(): string
    {
        return session_id();
    }

    /**
     * Set the current session id.
     *
     * @param string $id
     * @return string|false
     */
    public function setId(string $id): string|bool
    {
        return session_id($id);
    }

    /**
     * Get the current session name.
     *
     * @return string
     */
    public function getName(): string
    {
        return session_name();
    }


    /**
     * Set a key / value pair or array of key / value pairs in the session.
     *
     * @param array|string $key
     * @param mixed|null $value
     * @return void
     */
    public function set(array|string $key, mixed $value = null): void
    {
        if (!is_array($key)) $key = array($key => $value);

        foreach ($key as $arrayKey => $arrayValue) {
            Util::array_set($_SESSION, $arrayKey, $arrayValue);
        }
    }

    /**
     * Push a value onto an array session value.
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function push(string $key, string $value): void
    {
        $array = $this->get($key, array());

        $array[] = $value;

        $this->set($key, $array);
    }

    /**
     * Flash a key / value pair to the session.
     *
     * @param string $key
     * @param  mixed   $value
     * @return void
     */
    public function flash(string $key, mixed $value): void
    {
        $this->set($key, $value);

        $this->push('flash', $key);
    }


    /**
     * Delete all the flashed data.
     *
     * @return void
     */
    public function deleteFlash(): void
    {
        foreach ($this->get('flash', array()) as $key) {
            $this->delete($key);
        }

        $this->set('flash', array());
    }

    /**
     * Retrieve an item from the session.
     *
     * @param string $name
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $name, mixed $default = null): mixed
    {
        return Util::array_get($_SESSION, $name, $default);
    }

    /**
     * Retrieve all items from the session.
     *
     * @return array
     */
    public function all(): array
    {
        return $_SESSION;
    }

    /**
     * Determine if an item exists in the session.
     *
     * @param  string  $name
     * @return mixed
     */
    public function has($name): mixed
    {
        return $this->get($name);
    }

    /**
     * Remove an item from the session.
     *
     * @param string $key
     * @return void
     */
    public function delete(string $key): void
    {
        Util::array_forget($_SESSION, $key);
    }

    /**
     * Destroy all data registered to a session.
     *
     * @return bool
     */
    public function destroy(): bool
    {
        if ($this->getId()) {
            return session_destroy();
        }

        return false;
    }

    /**
     * Remove all items from the session.
     *
     * @return bool
     */
    public function flush(): bool
    {
        return session_unset();
    }

    /**
     * Get CSRF token value.
     *
     * @return mixed
     */
    public function token(): mixed
    {
        return $this->get('_token');
    }

    /**
     * Regenerate the CSRF token value.
     *
     * @return void
     */
    public function regenerateToken(): void
    {
        $this->set('_token', md5(mt_rand()));
    }

    /**
     * Determine if the given configuration option exists.
     *
     * @param  mixed  $key
     * @return bool
     */
    #[ReturnTypeWillChange]
    public function offsetExists(mixed $key): bool
    {
        return $this->has($key);
    }

    /**
     * Get a configuration option.
     *
     * @param  mixed  $key
     * @return mixed
     */
    #[ReturnTypeWillChange]
    public function offsetGet(mixed $key): mixed
    {
        return $this->get($key);
    }

    /**
     * Set a configuration option.
     *
     * @param mixed $key
     * @param  mixed   $value
     * @return void
     */
    #[ReturnTypeWillChange]
    public function offsetSet(mixed $key, $value): void
    {
        $this->set($key, $value);
    }

    /**
     * Unset a configuration option.
     *
     * @param mixed $key
     * @return void
     */
    #[ReturnTypeWillChange]
    public function offsetUnset(mixed $key): void
    {
        $this->delete($key);
    }

}