<?php


namespace App\MessageHelperBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class MessageHelperExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        //dd($configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        //dd($config);
        //$definition = $container->getDefinition('app_message_helper.message_helper');
    }

//    public function getAlias()
//    {
//        return 'message_helper';
//    }
}