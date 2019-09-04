<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 04.09.19
 * Time: 15:28
 */

namespace App\Types;


use Doctrine\DBAL\Exception\InvalidArgumentException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class Owner extends Type
{
    const TYPE = 'owner_type';

    /**
     * @var array
     */
    private static $list = [
        'admin', 'user', 'guest'
    ];

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        // return the SQL used to create your column type. To create a portable column type, use the $platform.
        return "VARCHAR(10";
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
        // This is executed when the value is read from the database. Make your conversions here, optionally using the $platform.
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        // This is executed when the value is written to the database. Make your conversions here, optionally using the $platform.
        if (!is_string($value)) {
            throw new InvalidArgumentException('Owner must be a string');
        }

        if (!in_array($value, self::$list)) {
            throw new InvalidArgumentException('Owner must be one of the: '
                . implode(', ', self::$list));
        }

        return $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::TYPE;
    }
}