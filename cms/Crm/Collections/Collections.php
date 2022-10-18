<?php

namespace Crm\Collections;

class Collections
{
    private array $data;


    public function __construct(array $data = [])
    {
        $this->data = $data;

        return $this;
    }


    /**
     * @param $field
     * @return $this
     * Ключ масива по значению поля элемента.
     * !!! ключ в масиве не может дублироваться
     */
    public function keyAsFild($field)
    {
        $tmp = [];
        if (is_array($this->data[array_key_first($this->data)])){
            foreach ($this->data as $item){
                if (isset($item[$field])){
                    $tmp[$item[$field]] = $item;
                }
            }
        }else{
            if (isset($this->data[$field])){
                $tmp[$this->data[$field]] = $this->data;
            }
        }

        $this->data = $tmp;
        unset($tmp);

        return $this;
    }


    /**
     * @param $key
     * @return $this
     * Сортирует многомерный масив по ключу
     * todo: перепроверить работу
     */
    public function sortBy($key, $reverse = false)
    {
        if (is_numeric(array_key_first($this->data))){
            uasort($this->data, function ($a, $b) use ($key, $reverse){
                if($a[$key] == $b[$key]) {
                    return 0;
                }
                if ($reverse){
                    return ($a[$key] > $b[$key]) ? -1 : 1;
                }
                return ($a[$key] > $b[$key]) ? 1 : -1;
            });
        }else{
            uasort($this->data, function ($a, $b) use ($key, $reverse){
                if($this->data[$key] == $this->data[$key]) {
                    return 0;
                }
                if ($reverse){
                    return ($this->data[$key] > $this->data[$key]) ? -1 : 1;
                }
                return ($this->data[$key] > $this->data[$key]) ? 1 : -1;
            });
        }

        return $this;
    }


    /**
     * Сортирует массив в порядке возрастания и поддерживает ассоциацию индексов
     */
    public function asort()
    {
        \asort($this->data);
        return $this;
    }


    /**
     * @return $this
     * Сортирует массив в порядке убывания и поддерживает ассоциацию индексов
     */
    public function arsort()
    {
        \arsort($this->data);
        return $this;
    }


    /**
     * @return array
     * Получить результат
     */
    public function get(): array
    {
        return $this->data;
    }
}