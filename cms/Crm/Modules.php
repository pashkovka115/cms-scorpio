<?php


namespace Crm;


class Modules
{
    /**
     * @param array $class [класс, метод]
     * @param false $params параметры при запуске модуля
     * Запускает модуль на выполнение.
     * Должен быть в модуле метод Index::start
     */
    public static function includeModule(string $class, $params = false)
    {
            $short_class_name = basename(str_replace('\\', '/', $class));

            if ($short_class_name == 'Index'){
                if (method_exists($class, 'start')){
                    $result = (new $class)->start($params);
                    if (is_string($result)){
                        return $result;
                    }else{
                        throw new \Exception('Модуль должен возвращать строку, а вернул "' . gettype($result) . '"');
                    }
                }else{
                    throw new \Exception('У модуля должен быть метод "Index::start()"');
                }
            }else{
                throw new \Exception('У модуля должен быть класс "Index"');
            }
    }
}
