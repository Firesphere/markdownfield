<?php
/**
 * Created by Nivanka Fonseka (nivanka@silverstripers.com).
 * User: nivankafonseka
 * Date: 10/24/17
 * Time: 10:27 AM
 * To change this template use File | Settings | File Templates.
 */

namespace SilverStripers\markdown\forms;

use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Convert;
use SilverStripe\Core\Injector\Injectable;

class MarkdownEditorConfig
{
    use Configurable;
    use Injectable;


    protected static $configs = [];
    protected static $current;
    private static $default_config = 'default';

    protected static $settings;
    /**
     * @param null $identifier
     * @return mixed
     */
    public static function get($identifier = null)
    {
        if (!$identifier) {
            return static::get_active();
        }
        // Create new instance if unconfigured
        if (!isset(self::$configs[$identifier])) {
            self::$configs[$identifier] = static::create();
        }

        return self::$configs[$identifier];
    }

    /**
     * @return mixed
     */
    public static function get_active_identifier()
    {
        return static::$current ?: static::config()->get('default_config');
    }

    /**
     * @return mixed
     */
    public static function get_active()
    {
        return self::get(static::get_active_identifier());
    }

    /**
     * @param MarkdownEditorConfig $config
     * @return MarkdownEditorConfig
     */
    public static function set_active(MarkdownEditorConfig $config)
    {
        return static::get_active_identifier();
    }

    /**
     * @param $identifier
     * @param MarkdownEditorConfig|null $config
     * @return MarkdownEditorConfig
     */
    public static function set_config($identifier, MarkdownEditorConfig $config = null)
    {
        if ($config) {
            static::$configs[$identifier] = $config;
        } else {
            unset(static::$configs[$identifier]);
        }

        return $config;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return static::config()->get('settings');
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return [
            'data-editor' => 'markDown',
            'data-config' => Convert::array2json($this->getConfig()),
        ];
    }
}
