<?php

namespace Dugun\Bundle\SmsBundle\Sms;

use Dugun\Bundle\SmsBundle\Exception\ProviderNotInstalledException;

/**
 * Class BaseProviderClient.
 */
abstract class BaseProviderClient implements ProviderClientInterface
{
    /**
     * @var bool
     */
    protected $disabled = false;

    public function disable()
    {
        $this->disabled = true;
    }

    public function enable()
    {
        $this->disabled = false;
    }

    protected function removeNewLines($string)
    {
        return trim(preg_replace('/\s+/', ' ', $string));
    }

    protected function createNotInstalledException(string $name, string $package)
    {
        throw new ProviderNotInstalledException(sprintf('%s is not installed. Run `composer require %s`', $name, $package));
    }
}
