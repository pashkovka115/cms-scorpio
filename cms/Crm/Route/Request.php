<?php


namespace Crm\Route;


use Crm\Collections\Collections;

class Request
{
    private static $instance = null;
    public $url = [];
    protected $request;


    private function __construct()
    {
        $host = conf('app.host');

        if (!$host and !is_string($host)) {
            throw new \Exception('В настройках не указан HOST');
        }
        $url = rtrim(
            rtrim($host, '/')
            . '/'
            . ltrim($_SERVER['REQUEST_URI']
                , '/')
            , '/'
        );
        $parsed_url = parse_url($url);

        $this->url['scheme'] = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : null;
        $this->url['host'] = isset($parsed_url['host']) ? $parsed_url['host'] : null;
        $this->url['port'] = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : null;
        $this->url['user'] = isset($parsed_url['user']) ? $parsed_url['user'] : null;
        $this->url['pass'] = isset($parsed_url['pass']) ? ':' . $parsed_url['pass'] : null;
        $this->url['pass'] = ($this->url['user'] || $this->url['pass']) ? "{$this->url['pass']}@" : null;
        $this->url['path'] = isset($parsed_url['path']) ? $parsed_url['path'] : null;
        $this->url['query'] = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : null;
        $this->url['fragment'] = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : null;

        $this->request = $this->toArray();
    }


    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    public function getQuery()
    {
        if (isset($this->url['query'])) {
            parse_str(ltrim($this->url['query'], '?/'), $result);

            return $result;
        }

        return false;
    }


    public function getCollection($black_list = [])
    {
        return new Collections($this->toArray($black_list));
    }


    public function toArray($black_list = [])
    {
        $data = array_merge_recursive($_GET, $_POST);

        foreach ($data as $key => $v) {
            if (in_array($key, $black_list) and isset($data[$key])) {
                unset($data[$key]);
            }
        }

        return $data;
    }


    public function input($name, $default = false)
    {
        $data = $this->toArray();
        if (isset($data[$name])) {
            return $data[$name];
        } elseif ($default) {
            return $default;
        }

        return false;
    }


    public function hasInput($name)
    {
        return isset($this->toArray()[$name]);
    }
}