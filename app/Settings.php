<?php

namespace App;

use Exception;

class Settings
{
    /**
     * The User instance.
     *
     * @var User
     */
    protected $user;

    /**
     * The list of settings.
     *
     * @var array
     */
    protected $settings = [
        'language' => 1
    ];

    protected $userSettings = [];

    /**
     * Create a new settings instance.
     *
     * @param array $settings
     * @param User  $user
     */
    public function __construct(User $user)
    {
        $this->userSettings = $user->settings;
        $this->user = $user;
    }

    /**
     * Retrieve the given setting.
     *
     * @param  string $key
     * @return string
     */
    public function get($key)
    {
        if(array_key_exists($key, $this->userSettings))
            return array_get($this->userSettings, $key);
        else //Return default
            return $this->settings[$key];
    }

    /**
     * Create and persist a new setting.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value)
    {
        $this->userSettings[$key] = $value;

        $this->persist();
    }

    /**
     * Determine if the given setting exists.
     *
     * @param  string $key
     * @return boolean
     */
    public function has($key)
    {
        return array_key_exists($key, $this->userSettings) || array_key_exists($key, $this->settings);
    }

    /**
     * Retrieve an array of all settings.
     *
     * @return array
     */
    public function all()
    {
        return $this->userSettings;
    }

    /**
     * Merge the given attributes with the current settings.
     * But do not assign any new settings.
     *
     * @param  array  $attributes
     * @return mixed
     */
    public function merge(array $attributes)
    {
        $this->userSettings = array_merge(
            $this->userSettings,
            array_only($attributes, array_keys($this->userSettings))
        );

        return $this->persist();
    }

    /**
     * Persist the settings.
     *
     * @return mixed
     */
    protected function persist()
    {
        return $this->user->update(['settings' => $this->userSettings]);
    }

    /**
     * Magic property access for settings.
     *
     * @param  string $key
     * @throws Exception
     * @return
     */
    public function __get($key)
    {
        if ($this->has($key)) {
            return $this->get($key);
        }

        throw new Exception("The {$key} setting does not exist.");
    }
}