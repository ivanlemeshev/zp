<?php

class FileCacheTest extends \Codeception\Test\Unit
{
    const KEY = 'zp_test_cache_file';

    const DATA = [1, 'hello' => 'world'];

    /**
     * @var \App\Service\Cache\FileCache
     */
    private $cache;

    protected function _before()
    {
        $this->cache = new \App\Service\Cache\FileCache(['path' => dirname(__DIR__) . '/_cache']);
    }

    public function testSet()
    {
        $this->cache->set(self::KEY, self::DATA);
        $this->assertNotFalse($this->cache->get(self::KEY));
    }

    public function testGet()
    {
        $this->cache->set(self::KEY, self::DATA);
        $this->assertEquals(self::DATA, $this->cache->get(self::KEY));
    }

    protected function _after()
    {
        $file = dirname(__DIR__) . '/_cache/' . self::KEY;
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
