<?php

namespace App\Service;

use GuzzleHttp\Client;

class Storage
{
    private const BASE_URL = 'https://api.zp.ru/v1';

    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Возвращает рубрики для новых вакансий, которые добавлены сегодня.
     * @param int $geoId
     * @return array
     */
    public function getRubricsForTodayNewJobs(int $geoId): array
    {
        $data = $this->getJobs([
            'categories_facets' => true,
            'is_new_only' => true,
            'period' => 'today',
            'geo_id' => $geoId,
            'state' => 1,
        ]);

        if (isset($data['metadata']['categories_facets'])) {
            return $data['metadata']['categories_facets'];
        }

        return [];
    }

    /**
     * Возвращает список новых вакансий, которые добавлены сегодня.
     * @param int $geoId
     * @return array
     */
    public function getTodayNewJobs(int $geoId): array
    {
        $offset = 0;
        $limit = 100;
        $result = [];

        do {
            $data = $this->getJobs([
                'is_new_only' => true,
                'period' => 'today',
                'geo_id' => $geoId,
                'state' => 1,
                'limit' => $limit,
                'offset' => $offset
            ]);

            if (isset($data['vacancies'])) {
                $result = array_merge($result, $data['vacancies']);
            }

            $offset += $limit;
        } while (isset($data['vacancies']) && !empty($data['vacancies']));

        return $result;
    }


    /**
     * Длает запрос к API и возвращает результат.
     * @param array $params
     * @return array
     */
    private function getJobs(array $params = []): array
    {
        $url = self::BASE_URL . '/vacancies?' . http_build_query($params);
        $response = $this->client->request('GET', $url);
        return json_decode($response->getBody()->getContents(), true);
    }
}
