<?php

namespace Malefici\Symfony\MetabaseBundle;

use Malefici\Symfony\MetabaseBundle\DependencyInjection\MetabaseExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class MetabaseBundle extends AbstractBundle
{
    public function getContainerExtension(): ExtensionInterface
    {
        return new MetabaseExtension();
    }
}
