<?php

namespace App\Service\Cache;

interface CacheInterface
{
    public function set(string $key, $value);

    public function get(string $key);
}
