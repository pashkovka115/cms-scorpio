<?php


namespace Crm\Views;


class View
{
    /** @var string $path главный путь к шаблонам */
    private $path = '';

    /** @var string $pathLayouts путь к общим шаблонам */
    private $pathLayouts = '';


    protected function getLayout($layout)
    {
        ob_start();
        $layout = str_replace('.', '/', $layout);
        if ($this->pathLayouts){
            $layout = rtrim($this->pathLayouts, '/') . '/' . ltrim($layout, '/');
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
    public function template(string $template, array $params = [], $current_dir = false)
    {
        if ($current_dir){
            $this->path = $current_dir;
        }
        $extends_pattern = '#\@extends\(\s?([a-z]+),\s?([a-z]+)\s?\)#';

        $template = str_replace('.', '/', $template);
        if ($this->path){
            $template = rtrim($this->path, '/') . '/' . ltrim($template, '/');
        }

        ob_start();

        extract($params);
        require $template . '.php';

        $tmp = ob_get_clean();

        if (stripos($tmp, '@extends(') !== false){
            preg_match($extends_pattern, $tmp, $matches);

            if (isset($matches[1])){
                $layout_name = $matches[1];
                $layout = self::getLayout($layout_name);
            }
            if (isset($matches[2])){
                $section_name = $matches[2];
            }
        }

        if (isset($layout) and isset($section_name)){
            if (stripos($layout, '@section(' . $section_name . ')') !== false){
                $tmp = preg_replace($extends_pattern, '', $tmp);
                $tmp = str_replace('@section(' . $section_name . ')', $tmp, $layout);
            }
        }

        return $tmp;
    }


    /**
     * @param string $path
     * Установить путь к директории с шаблонами.
     * Папка со всеми шаблонами модуля относительно которой будут запрашиваться шаблоны методом self::template()
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }


    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $pathLayouts
     * Папка с общими шаблонами
     */
    public function setPathLayouts(string $pathLayouts): void
    {
        $this->pathLayouts = $pathLayouts;
    }


    /**
     * @return string
     */
    public function getPathLayouts(): string
    {
        return $this->pathLayouts;
    }
}