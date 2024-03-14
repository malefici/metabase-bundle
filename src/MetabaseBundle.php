<?php

/*
 * This file is part of the malefici/metabase-bundle package.
 *
 * (c) Malefici <nikita@malefici.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
