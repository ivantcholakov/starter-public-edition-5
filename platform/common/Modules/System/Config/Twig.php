<?php namespace Common\Modules\System\Config;

use CodeIgniter\Config\BaseConfig;

class Twig extends BaseConfig implements ArrayAccess
{
    public $options = [
        'debug' => false,
        'charset' => 'UTF-8',
        'strict_variables' => false,
        'autoescape' => 'html',
        'cache' => false,
        'auto_reload' => null,
        'optimizations' => -1,
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function offsetExists($key): bool
    {
        return array_key_exists($key, $this->options);
    }

    public function offsetGet($key)
    {
        if (!$this->offsetExists($key)) {

            return null;
        }

        return $this->options[$key];
    }

    public function offsetSet($key, $value): void
    {
        $this->options[$key] = $value;
    }

    public function offsetUnset($key): void
    {
        unset($this->options[$key]);
    }

    public function count(): int
    {
        return count($this->options);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->options);
    }
}
