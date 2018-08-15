<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value;

use Assert\AssertionFailedException;
use philwc\DarkSky\Value\String\Lang;
use philwc\DarkSky\Value\String\Units;

/**
 * Class OptionalParameters
 * @package philwc\DarkSky\Value
 */
class OptionalParameters
{
    /**
     * @var Lang
     */
    private $lang;
    /**
     * @var Units
     */
    private $units;

    /**
     * OptionalParameters constructor.
     * @param array $optionalParameters
     * @throws AssertionFailedException
     */
    public function __construct(array $optionalParameters = [])
    {
        if (array_key_exists('lang', $optionalParameters)) {
            try {
                $this->lang = new Lang($optionalParameters['lang']);
            } catch (AssertionFailedException $e) {
            }
        }

        if (array_key_exists('units', $optionalParameters)) {
            try {
                $this->units = new Units($optionalParameters['units']);
            } catch (AssertionFailedException $e) {
            }
        }

        if ($this->lang === null) {
            $this->lang = new Lang(Lang::DEFAULT_LANG);
        }

        if ($this->units === null) {
            $this->units = new Units(Units::DEFAULT_UNIT);
        }
    }

    /**
     * @return Lang
     */
    public function getLang(): Lang
    {
        return $this->lang;
    }

    /**
     * @return Units
     */
    public function getUnits(): Units
    {
        return $this->units;
    }
}
