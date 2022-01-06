<?php

namespace App\Repositories\HMRC\Environment;

use App\Repositories\HMRC\Exceptions\InvalidVariableValueException;
use App\Repositories\HMRC\Oauth2\AccessToken;

class Environment
{
    const ALLOWED_ENV = [self::SANDBOX, self::LIVE];

    const SANDBOX = 'sandbox';

    const LIVE = 'live';

    const HMRC_TESTING_KEY = 'hmrc_testing';

    private static $instance = null;

    /** @var string */
    private $env;

    /** @var array of request headers which will be added in all requests in this environment */
    private $requestHeaders = [];

    /**
     * Private : not instantiable
     * Environment constructor.
     */
    private function __construct()
    {
        $this->env = session()->exists(self::HMRC_TESTING_KEY) ? self::SANDBOX : self::LIVE;
    }

    public static function getInstance(): self
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function reset()
    {
        self::$instance = new self();
    }

    public function getEnv(): string
    {
        return $this->env;
    }

    /**
     * @param string $env
     *
     * @throws InvalidVariableValueException
     */
    public function setEnv(string $env)
    {
        $this->checkEnv($env);

        $this->env = $env;
    }

    public function isSandbox(): bool
    {
        return $this->env == self::SANDBOX;
    }

    public function isLive(): bool
    {
        return $this->env == self::LIVE;
    }

    public function setToSandbox()
    {
        session()->put(self::HMRC_TESTING_KEY,1);
        $this->env = self::SANDBOX;
    }

    public function setToLive()
    {
        session()->forget(self::HMRC_TESTING_KEY);
        $this->env = self::LIVE;
    }

    /**
     * Sets Request headers which will be included in all Requests.
     * This can be nicely used to include fraud prevention headers, for example.
     *
     * @param array $headers
     */
    public function setDefaultRequestHeaders(array $headers)
    {
        $this->requestHeaders = $headers;
    }

    /**
     * Returns default request headers.
     *
     * @return array
     */
    public function getDefaultRequestHeaders(): array
    {
        return $this->requestHeaders;
    }

    /**
     * @param string $env
     *
     * @throws InvalidVariableValueException
     */
    private function checkEnv(string $env)
    {
        if (!in_array($env, self::ALLOWED_ENV)) {
            $allowedValueString = implode(', ', self::ALLOWED_ENV);

            throw new InvalidVariableValueException("Invalid env, the allowed env are {$allowedValueString}.");
        }
    }
}
