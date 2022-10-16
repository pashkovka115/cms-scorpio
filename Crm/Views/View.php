<?php


namespace Crm\Views;


class View
{
    /** @var string $path главный путь к шаблонам */
    private static $path = '';


    public static function template($template, array $params = [])
    {
        $template = str_replace('.', '/', $template);
        if (self::$path){
            $template = rtrim(self::$path, '/') . '/' . ltrim($template, '/');
        }
        $template = $template . '.php';

        ob_start();

        extract($params);
        require $template;

        return ob_get_clean();
    }


    /**
     * @param string $path
     * Установить главный путь к шаблонам
     */
    public static function setPath(string $path): void
    {
        self::$path = $path;
    }
}