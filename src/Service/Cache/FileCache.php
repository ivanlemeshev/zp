<?php

namespace App\Service\Cache;

class FileCache implements CacheInterface
{
    const EXPIRE_TIME = 5 * 60; // 5 минут

    /**
     * @var string
     */
    private $path;

    public function __construct(array $params)
    {
        $this->path = $params['path'];
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value)
    {
        file_put_contents("{$this->path}/{$key}", json_encode($value));
    }

    /**
     * @param string $key
     * @return bool|mixed
     */
    public function get(string $key)
    {
        $file = "{$this->path}/{$key}";

        if (!file_exists($file)) {
            return false;
        }

        $time = filemtime($file);
        if ($this->isExpired($time)) {
            return false;
        }

        $content = file_get_contents($file);
        if ($content) {
            return json_decode($content, true);
        }

        return false;
    }

    private function isExpired(int $time): bool
    {
        return $time < time() - self::EXPIRE_TIME;
    }
}
