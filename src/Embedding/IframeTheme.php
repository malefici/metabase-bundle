<?php

/*
 * This file is part of the malefici/metabase-bundle package.
 *
 * (c) Malefici <nikita@malefici.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Malefici\Symfony\MetabaseBundle\Embedding;

enum IframeTheme: string
{
    case light = 'light';

    case night = 'dark';

    case transparent = 'transparent';
}
