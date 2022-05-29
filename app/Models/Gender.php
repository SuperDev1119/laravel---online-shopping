<?php

namespace App\Models;

class Gender
{
    const GENDER_BOTH = 'mixte';

    const GENDER_MALE = 'homme';

    const GENDER_FEMALE = 'femme';

    const GENDER_GIRL = 'fille';

    const GENDER_BOY = 'garcon';

    const GENDER_CHILD = 'enfant';

    public static function GENDER_MALE()
    {
        return _i(self::GENDER_MALE);
    }

    public static function GENDER_FEMALE()
    {
        return _i(self::GENDER_FEMALE);
    }

    public static function GENDER_BOTH()
    {
        return _i(self::GENDER_BOTH);
    }

    const GENDERS = [
        self::GENDER_BOTH,
        self::GENDER_FEMALE,
        self::GENDER_MALE,
    ];

    const GENDERS_FOR_QUERY = [
        self::GENDER_BOTH   => [self::GENDER_BOTH, self::GENDER_FEMALE, self::GENDER_MALE],
        self::GENDER_FEMALE => [self::GENDER_BOTH, self::GENDER_FEMALE],
        self::GENDER_MALE   => [self::GENDER_BOTH, self::GENDER_MALE],
    ];

    public static function genders()
    {
        return array_combine(
      array_map(function ($v) {
          return _i($v);
      }, self::GENDERS),
      self::GENDERS
    );
    }

    public static function gender_from_string($string)
    {
        return @static::genders()[$string];
    }

    public static function areMatching($gender_1, $gender_2)
    {
        if ($gender_1 == $gender_2) {
            return true;
        }

        if (in_array(self::GENDER_BOTH, [$gender_1, $gender_2])) {
            return true;
        }

        return false;
    }
}
