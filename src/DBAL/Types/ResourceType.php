<?php

/*
 * This file is part of aakb/resource_database.
 *
 * (c) 2020 ITK Development
 *
 * This source file is subject to the MIT license.
 */

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class ResourceType.
 */
final class ResourceType extends AbstractEnumType
{
    public const EXCHANGE = 'EXCHANGE';

    protected static $choices = [
        self::EXCHANGE => 'enum.resource_type.exchange',
    ];
}
