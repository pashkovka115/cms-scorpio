<?php


namespace Crm\Views;


class View
{
    /** @var string $path главный путь к шаблонам */
    private static $path = '';


    /**
     * @param string $template путь к шаблону относительно установленного методом self::setPath()
     * @param array $params параметры(переменные) для шаблона
     * @return false|string
     * Возвращает файл шаблона в виде строки
     */
    public static function template(string $template, array $params = [])
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
     * Установить путь к директории с шаблонами.
     * Папка со всеми шаблонами модуля относительно которой будут запрашиваться шаблоны методом self::template()
     */
    public static function setPath(string $path): void
    {
        self::$path = $path;
    }
}