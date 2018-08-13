<?php

namespace Dugun\Bundle\SmsBundle\DependencyInjection;

use Dugun\Bundle\SmsBundle\Sms\Provider\Infobip\Client as InfoBip;
use Dugun\Bundle\SmsBundle\Sms\Provider\Mobily\Client as Mobily;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class DugunSmsExtension.
 *
 * @author Farhad Safarov <farhad.safarov@gmail.com>
 */
class DugunSmsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        switch ($config['gateway_provider']) {
            case 'infobip':
                $definition = new Definition(InfoBip::class, [$config['credentials']]);
                break;
            case 'mobily':
                $definition = new Definition(Mobily::class, [$config['credentials'], $config['custom']]);
                break;
            default:
                throw new \LogicException('Validation is done in Configuration.php');
        }

        if ($config['disable']) {
            $definition->addMethodCall('disable');
        }

        $definition->addTag('dugun.sms');
        $container->setDefinition('dugun_sms', $definition);
    }
}
