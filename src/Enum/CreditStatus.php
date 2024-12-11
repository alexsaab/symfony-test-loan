<?php

namespace App\Enum;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class CreditStatus extends Type
{
    const CREATED = 'CREATED';
    const VOITED = 'VOITED';
    const DECLINED = 'DECLINED';
    const ACCEPTED = 'ACCEPTED';
    const CLOSED = 'CLOSED';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'enum';
    }

    public function getName()
    {
        return 'credit_status';
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function getValues()
    {
        return [
            self::CREATED,
            self::VOITED,
            self::DECLINED,
            self::ACCEPTED,
            self::CLOSED,
        ];
    }
}
