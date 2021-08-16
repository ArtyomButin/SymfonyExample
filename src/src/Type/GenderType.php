<?php

declare(strict_types=1);

namespace App\Type;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class GenderType extends EnumType
{
    protected $name = 'gender';

    protected $values = array('man', 'woman');
}