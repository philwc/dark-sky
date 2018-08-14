<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value;

/**
 * Class Icon
 * @package philwc\DarkSky\Value
 */
final class Icon
{
    private const ICON_MAP = [
        'clear-day' => '🌣',
        'clear-night' => '🌙',
        'rain' => '⛆',
        'snow' => '❄',
        'sleet' => '🌧',
        'wind' => '🌬',
        'fog' => '🌫',
        'cloudy' => '☁',
        'partly-cloudy-day' => '⛅',
        'partly-cloudy-night' => '☁️',
    ];

    /**
     * @var string
     */
    private $value;

    /**
     * Icon constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        if (array_key_exists($this->value, self::ICON_MAP)) {
            return self::ICON_MAP[$this->value];
        }

        return '';
    }
}
