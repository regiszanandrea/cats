<?php


return [
    /**
     * The url of CAT API to make requests
     */
    'base_url' => $_ENV['CAT_API_URL'],


    /**
     * The key to authenticate on CAT API
     */
    'key' => $_ENV['CAT_API_KEY'],

    /**
     * The header to authenticate on CAT API
     */
    'authentication_header' => $_ENV['CAT_API_AUTHENTICATION_HEADER'],
];