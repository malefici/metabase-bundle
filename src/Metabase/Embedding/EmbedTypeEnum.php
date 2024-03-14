<?php

namespace Malefici\Symfony\MetabaseBundle\Metabase\Embedding;

enum EmbedTypeEnum: string
{
    case question = 'question';

    case dashboard = 'dashboard';
}
