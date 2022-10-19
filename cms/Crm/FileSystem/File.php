<?php

namespace Crm\FileSystem;


class File
{
    protected $path;


    public function __construct($pathToWorkDir)
    {
        $this->path = rtrim(str_replace('\\', '/', $pathToWorkDir), '/');
    }


    public function addDir($path)
    {
        $this->path = rtrim($this->path) . '/' . ltrim($path);

        return $this;
    }


    public function minusDir($name_dirs)
    {
        $level = 0;
        if (is_int($name_dirs)){
            $level = $name_dirs;
        }elseif (is_string($name_dirs)){
            $name_dirs = trim($name_dirs, '/');
            $level = count(explode('/', $name_dirs));
        }
        $split = explode('/', $this->path);

        for ($i = 0; $i < $level; $i++){
            array_pop($split);
        }

        $this->path = implode('/', $split);

        return $this;
    }


    public function listDir(string $pattern = '', array $ignore_list = ['.', '..'])
    {
        if ($pattern){
            $dirs = glob(rtrim($this->path) . '/' . ltrim($pattern));
        }else{
            $dirs = scandir($this->path);
        }

        foreach ($dirs as $key => $dir){
            if (in_array($dir, $ignore_list)){
                unset($dirs[$key]);
                continue;
            }
            if (!$pattern){
                $dirs[$key] = $this->path . '/' . $dir;
            }
        }

        return array_values($dirs);
    }


    /**
     * @return string
     * Текущая директория
     */
    public function getPath(): string
    {
        return rtrim($this->path, '/');
    }
}