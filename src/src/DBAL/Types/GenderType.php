<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class GenderType extends AbstractEnumType
{
    public const MAN = 'man';
    public const WOMAN = 'woman';

    protected static $choices = [
        self::MAN => 'man',
        self::WOMAN => 'woman',
    ];
}