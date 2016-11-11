<?php

namespace Dugun\Bundle\SmsBundle\Sms;

/**
 * Class ProviderClientInterface.
 *
 * @author Farhad Safarov <farhad.safarov@gmail.com>
 */
interface ProviderClientInterface
{
    public function __construct(array $config);

    /**
     * @param $from
     * 
     * @return ProviderClientInterface
     */
    public function setFrom($from);

    /**
     * @param $to
     *
     * @return ProviderClientInterface
     */
    public function setTo($to);

    /**
     * @param $text
     *
     * @return ProviderClientInterface
     */
    public function setText($text);

    /**
     * Sends the message
     */
    public function send();

    public function setEnvironment($environment);

    public function getEnvironment();

    public function setDebugNumber($number);

    public function getDebugNumber();
}
