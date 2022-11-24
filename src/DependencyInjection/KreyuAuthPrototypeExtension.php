<?php

declare(strict_types=1);

namespace Kreyu\Bundle\AuthPrototypeBundle\DependencyInjection;

use Kreyu\Bundle\AuthPrototypeBundle\Security\LoginFormAuthenticator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class KreyuAuthPrototypeExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $container->loadFromExtension('security', [
            'firewalls' => [
                'main' => [
                    'custom_authenticator' => LoginFormAuthenticator::class,
                    'provider' => 'users_in_memory',
                    'logout' => [
                        'path' => LoginFormAuthenticator::LOGOUT_ROUTE,
                    ],
                ],
            ],
            'providers' => [
                'users_in_memory' => [
                    'memory' => [
                        'users' => [
                            'admin@example.com' => [
                                'password' => '$2y$13$8.WpGoMnrmIRR0KVp3ohkeE0Joxlko25cqiZw.B/J5b6sjYiOJy46', // 123
                                'roles' => ['ROLE_ADMIN'],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}