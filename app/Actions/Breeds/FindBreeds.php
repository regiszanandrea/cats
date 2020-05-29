<?php

namespace App\Actions\Breeds;

use App\Services\CatApiService;

/**
 * Class FindBreeds
 * @package App\Actions\Breeds
 */
class FindBreeds
{
    /**
     * @param int $page
     * @param int $limit
     * @param null $search
     * @return array|mixed
     */
    public static function find($page = 1, $limit = 10, $search = null)
    {
        return CatApiService::breeds($page, $limit, $search);
    }
}