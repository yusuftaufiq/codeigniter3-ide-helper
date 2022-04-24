<?php

namespace Haemanthus\CodeIgniter3IdeHelper\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self core()
 * @method static self controller()
 * @method static self model()
 */
final class ClassTypeEnum extends Enum
{
    public function directory(): ?string
    {
        switch (true) {
            case $this->equals(self::core()):
                $dir = './application/cores/';
                break;

            case $this->equals(self::controller()):
                $dir = './application/controllers/';
                break;

            case $this->equals(self::model()):
                $dir = './application/models/';
                break;
            
            default:
                $dir = null;
                break;
        }

        return $dir;
    }
}
