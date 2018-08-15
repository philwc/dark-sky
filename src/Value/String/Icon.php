<?php
declare(strict_types=1);

namespace philwc\DarkSky\Value\String;

/**
 * Class Icon
 * @package philwc\DarkSky\Value
 */
final class Icon extends StringValue
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
     * @return string
     */
    public function getIcon(): string
    {
        if (array_key_exists($this->value, self::ICON_MAP)) {
            return self::ICON_MAP[$this->value];
        }

        return '';
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->getIcon();
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return '';
    }

    /**
     * @param mixed $value
     */
    protected function assertValue($value): void
    {
        // noop
    }
}
