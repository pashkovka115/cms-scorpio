<?php


namespace Crm\Views;


class View
{
    /** @var string $path главный путь к шаблонам */
    private static $path = '';

    /** @var string $pathLayouts путь к общим шаблонам */
    private static $pathLayouts = '';


    protected static function getLayout($layout)
    {
        ob_start();
        $layout = str_replace('.', '/', $layout);
        if (self::$pathLayouts){
            $layout = rtrim(self::$pathLayouts, '/') . '/' . ltrim($layout, '/');
        }

        require_once $layout . '.php';
        $container = ob_get_clean();

        return $container;
    }


    /**
     * @param string $template путь к шаблону относительно установленного методом self::setPath()
     * @param array $params параметры(переменные) для шаблона
     * @return false|string
     * Возвращает файл шаблона в виде строки
     */
    public static function template(string $template, array $params = [], $current_dir = false)
    {
        if ($current_dir){
            self::$path = $current_dir;
        }
        $extends_pattern = '#\@extends\(\s?([a-z]+),\s?([a-z]+)\s?\)#';

        $template = str_replace('.', '/', $template);
        if (self::$path){
            $template = rtrim(self::$path, '/') . '/' . ltrim($template, '/');
        }
        $template = $template . '.php';

        ob_start();

        extract($params);
        require $template;

        $tmp = ob_get_clean();

        if (stripos($tmp, '@extends(') !== false){
            preg_match($extends_pattern, $tmp, $matches);
//            var_dump($matches, $tmp);
            if (isset($matches[1])){
                $layout_name = $matches[1];
                $layout = self::getLayout($layout_name);
//                var_dump($layout);
            }
            if (isset($matches[2])){
                $section_name = $matches[2];
            }
        }
//        var_dump($layout, $section_name, stripos($layout, '@section(' . $section_name . ')'));
        if (isset($layout) and isset($section_name)){
            if (stripos($layout, '@section(' . $section_name . ')') !== false){
                $tmp = preg_replace($extends_pattern, '', $tmp);
                $tmp = str_replace('@section(' . $section_name . ')', $tmp, $layout);
            }
        }
//        var_dump($tmp);



        return $tmp;
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

    /**
     * @param string $pathLayouts
     * Папка с общими шаблонами
     */
    public static function setPathLayouts(string $pathLayouts): void
    {
        self::$pathLayouts = $pathLayouts;
    }


    /**
     * @return string
     */
    public static function getPathLayouts(): string
    {
        return self::$pathLayouts;
    }
}