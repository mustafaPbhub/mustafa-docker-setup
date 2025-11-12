<?php

return [

    'enabled' => env('FIREWALL_ENABLED', true),

    'whitelist' => explode(',', env('FIREWALL_WHITELIST', '')),

    'models' => [
        'user' => '\App\Models\User',
        // 'log' => '\App\Models\YourLogModel',
        // 'ip' => 'Akaunting\Firewall\Models\Ip',
    ],

    'log' => [
        'max_request_size' => 2048,
    ],

    'cron' => [
        'enabled' => env('FIREWALL_CRON_ENABLED', true),
        'expression' => env('FIREWALL_CRON_EXPRESSION', '* * * * *'),
    ],

    'responses' => [

        'block' => [
            'view' => env('FIREWALL_BLOCK_VIEW', 'errors.405'),
            'redirect' => env('FIREWALL_BLOCK_REDIRECT', false),
            'abort' => env('FIREWALL_BLOCK_ABORT', false),
            'code' => env('FIREWALL_BLOCK_CODE', 403),
            // 'exception' => \Akaunting\Firewall\Exceptions\AccessDenied::class,
        ],

    ],

    'notifications' => [

        'mail' => [
            'enabled' => env('FIREWALL_EMAIL_ENABLED', false),
            'name' => env('FIREWALL_EMAIL_NAME', 'Laravel Firewall'),
            'from' => env('FIREWALL_EMAIL_FROM', 'firewall@mydomain.com'),
            'to' => env('FIREWALL_EMAIL_TO', 'admin@mydomain.com'),
            'queue' => env('FIREWALL_EMAIL_QUEUE', 'default'),
        ],

        'slack' => [
            'enabled' => env('FIREWALL_SLACK_ENABLED', false),
            'emoji' => env('FIREWALL_SLACK_EMOJI', ':fire:'),
            'from' => env('FIREWALL_SLACK_FROM', 'Laravel Firewall'),
            'to' => env('FIREWALL_SLACK_TO'), // webhook url
            'channel' => env('FIREWALL_SLACK_CHANNEL', null), // set null to use the default channel of webhook
            'queue' => env('FIREWALL_SLACK_QUEUE', 'default'),
        ],

    ],

    'all_middleware' => [
        'firewall.ip',
        'firewall.agent',
        'firewall.bot',
        'firewall.geo',
        'firewall.lfi',
        'firewall.php',
        'firewall.referrer',
        'firewall.rfi',
        'firewall.session',
        'firewall.sqli',
        'firewall.swear',
        'firewall.xss',
        //'App\Http\Middleware\YourCustomRule',
    ],

    'middleware' => [

        'ip' => [
            'enabled' => env('FIREWALL_MIDDLEWARE_IP_ENABLED', env('FIREWALL_ENABLED', true)),

            'methods' => ['all'],

            'routes' => [
                'only' => [], // i.e. 'contact'
                'except' => [''], // i.e. 'admin/*'
            ],

            'block' => [
                '127.0.0.1',  // Block this specific IP address
            ],
           'auto_block' => [
                'attempts' => 1,
                'frequency' => 1 * 60, // 1 minute
                'period' => 30 * 60, // 30 minutes
            ],

        ],

        'agent' => [
            'enabled' => env('FIREWALL_MIDDLEWARE_AGENT_ENABLED', env('FIREWALL_ENABLED', true)),

            'methods' => ['all'],

            'routes' => [
                'only' => [], // i.e. 'contact'
                'except' => [], // i.e. 'admin/*'
            ],

            // https://github.com/jenssegers/agent
            'browsers' => [
                'allow' => [], // i.e. 'Chrome', 'Firefox'
                'block' => [], // i.e. 'IE'
            ],

            'platforms' => [
                'allow' => [], // i.e. 'Ubuntu', 'Windows'
                'block' => [], // i.e. 'OS X'
            ],

            'devices' => [
                'allow' => [], // i.e. 'Desktop', 'Mobile'
                'block' => [], // i.e. 'Tablet'
            ],

            'properties' => [
                'allow' => [], // i.e. 'Gecko', 'Version/5.1.7'
                'block' => [], // i.e. 'AppleWebKit'
            ],

            'auto_block' => [
                'attempts' => 1,
                'frequency' => 1 * 60, // 1 minute
                'period' => 30 * 60, // 30 minutes
            ],
        ],

        'bot' => [
            'enabled' => env('FIREWALL_MIDDLEWARE_BOT_ENABLED', env('FIREWALL_ENABLED', true)),

            'methods' => ['all'],

            'routes' => [
                'only' => [], // i.e. 'contact'
                'except' => [], // i.e. 'admin/*'
            ],

            'crawlers' => [
                'allow' => [], // i.e. 'GoogleSites', 'GuzzleHttp'
                'block' => [], // i.e. 'Holmes'
            ],

            'auto_block' => [
                'attempts' => 5,
                'frequency' => 1 * 60, // 1 minute
                'period' => 30 * 60, // 30 minutes
            ],
        ],

        'geo' => [
            'enabled' => env('FIREWALL_MIDDLEWARE_GEO_ENABLED', env('FIREWALL_ENABLED', true)),

            'methods' => ['all'],

            'routes' => [
                'only' => [], // i.e. 'contact'
                'except' => [], // i.e. 'admin/*'
            ],

            'continents' => [
                'allow' => [], // i.e. 'Africa'
                'block' => [], // i.e. 'Europe'
            ],

            'regions' => [
                'allow' => [], // i.e. 'California'
                'block' => [], // i.e. 'Nevada'
            ],

            'countries' => [
                'allow' => [], // i.e. 'Albania'
                'block' => ['pakistan','Pakistan'], // Pakistan ko block kar rahe hain
            ],

            'cities' => [
                'allow' => [], // i.e. 'Istanbul'
                'block' => [], // i.e. 'London'
            ],

            // ipapi, extremeiplookup, ipstack, ipdata, ipinfo, ipregistry, ip2locationio
            'service' => 'ipapi',

            'auto_block' => [
                'attempts' => 1,
                'frequency' => 5 * 60, // 5 minutes
                'period' => 30 * 60, // 30 minutes
            ],
        ],


        'lfi' => [
            'enabled' => env('FIREWALL_MIDDLEWARE_LFI_ENABLED', env('FIREWALL_ENABLED', false)),

            'methods' => ['get', 'delete'],

            'routes' => [
                'only' => [], // i.e. 'contact'
                'except' => [], // i.e. 'admin/*'
            ],

            'inputs' => [
                'only' => [], // i.e. 'first_name'
                'except' => [], // i.e. 'password'
            ],
            'patterns' => [

                '#(?:%252e|%2e|\.\.)(?:%252f|%2f|/){2,}#is',  // Double or single encoded ../ or ..\ sequence
                '#php\://#is',  // Match php:// (can lead to RFI)
                '#data\://#is',  // Match data:// wrapper, which could be dangerous
                '#file\://#is',  // Match file:// (used for local file inclusion)
                '#php\://filter/#is',  // Match php://filter (a special PHP wrapper for encoding)
                '#/etc/passwd#is',
                '#/proc/self/environ#is',  // Match /proc/self/environ (useful for reading environment variables)
                '#/var/log/#is',  // Match paths in /var/log (often targeted for log poisoning or file reading)
            ],


            'auto_block' => [
                'attempts' => 1,
                'frequency' => 5 * 60, // 5 minutes
                'period' => 30 * 60, // 30 minutes
            ],
        ],

        'login' => [
            'enabled' => env('FIREWALL_MIDDLEWARE_LOGIN_ENABLED', env('FIREWALL_ENABLED', false)),

            'auto_block' => [
                'attempts' => 5,
                'frequency' => 1 * 60, // 1 minute
                'period' => 30 * 60, // 30 minutes
            ],
        ],

        'php' => [
            'enabled' => env('FIREWALL_MIDDLEWARE_PHP_ENABLED', env('FIREWALL_ENABLED', false)),

            'methods' => ['get', 'post', 'delete'],

            'routes' => [
                'only' => config('allowed_urls'), // i.e. 'contact'
                'except' => config('allowed_parameterized_url'), // i.e. 'admin/*'
            ],

            'inputs' => [
                'only' => [],
                'except' => [],
            ],

            'patterns' => [
                'bzip2://',
                'expect://',
                'glob://',
                'phar://',
                'php://',
                'ogg://',
                'rar://',
                'ssh2://',
                'zip://',
                'zlib://',
            ],

            'auto_block' => [
                'attempts' => 1,
                'frequency' => 1 * 60, // 1 minutes
                'period' => 30 * 60, // 30 minutes
            ],
        ],

        'referrer' => [
            'enabled' => env('FIREWALL_MIDDLEWARE_REFERRER_ENABLED', env('FIREWALL_ENABLED', false)),

            'methods' => ['all'],

            'routes' => [
                'only' => config('allowed_urls'), // i.e. 'contact'
                'except' => config('allowed_parameterized_url'), // i.e. 'admin/*'
            ],

            'blocked' => [],

            'auto_block' => [
                'attempts' => 1,
                'frequency' => 5 * 60, // 5 minutes
                'period' => 30 * 60, // 30 minutes
            ],
        ],

        'rfi' => [
            'enabled' => env('FIREWALL_MIDDLEWARE_RFI_ENABLED', env('FIREWALL_ENABLED', false)),

            'methods' => ['get', 'post', 'delete'],

            'routes' => [
                'only' => config('allowed_urls'), // i.e. 'contact'
                'except' => config('allowed_parameterized_url'), // i.e. 'admin/*'
            ],

            'inputs' => [
                'only' => [], // i.e. 'first_name'
                'except' => [], // i.e. 'password'
            ],

           'patterns' => [
                 '#^(https?|ftp)://#i',
             ],

            'exceptions' => [],

            'auto_block' => [
                'attempts' => 1,
                'frequency' => 5 * 60, // 5 minutes
                'period' => 30 * 60, // 30 minutes
            ],
        ],

        'session' => [
            'enabled' => env('FIREWALL_MIDDLEWARE_SESSION_ENABLED', env('FIREWALL_ENABLED', true)),

            'methods' => ['get', 'post', 'delete'],

            'routes' => [
                'only' => config('allowed_urls'), // i.e. 'contact'
                'except' => config('allowed_parameterized_url'), // i.e. 'admin/*'
            ],

            'inputs' => [
                'only' => [], // i.e. 'first_name'
                'except' => [], // i.e. 'password'
            ],

            'patterns' => [
                '@[\|:]O:\d{1,}:"[\w_][\w\d_]{0,}":\d{1,}:{@i',
                '@[\|:]a:\d{1,}:{@i',
            ],

            'auto_block' => [
                'attempts' => 3,
                'frequency' => 5 * 60, // 5 minutes
                'period' => 30 * 60, // 30 minutes
            ],
        ],

        'sqli' => [
            'enabled' => env('FIREWALL_MIDDLEWARE_SQLI_ENABLED', env('FIREWALL_ENABLED', true)),

            'methods' => ['get', 'delete'],

            'routes' => [
                'only' => config('allowed_urls'), // i.e. 'contact'
                'except' => config('allowed_parameterized_url'), // i.e. 'admin/*'
            ],

            'inputs' => [
                'only' => [], // i.e. 'first_name'
                'except' => [], // i.e. 'password'
            ],

            'patterns' => [
                '#[\d\W](union select|union join|union distinct)[\d\W]#is',
                '#[\d\W](union|union select|insert|from|where|concat|into|cast|truncate|select|delete|having)[\d\W]#is',
            ],

            'auto_block' => [
                'attempts' => 3,
                'frequency' => 5 * 60, // 5 minutes
                'period' => 30 * 60, // 30 minutes
            ],
        ],

        'swear' => [
            'enabled' => env('FIREWALL_MIDDLEWARE_SWEAR_ENABLED', env('FIREWALL_ENABLED', false)),

            'methods' => ['post', 'put', 'patch'],

            'routes' => [
                'only' => config('allowed_urls'), // i.e. 'contact'
                'except' => config('allowed_parameterized_url'), // i.e. 'admin/*'
            ],

            'inputs' => [
                'only' => [], // i.e. 'first_name'
                'except' => [], // i.e. 'password'
            ],

            'words' => [],

            'auto_block' => [
                'attempts' => 3,
                'frequency' => 5 * 60, // 5 minutes
                'period' => 30 * 60, // 30 minutes
            ],
        ],

        'url' => [
            'enabled' => env('FIREWALL_MIDDLEWARE_URL_ENABLED', env('FIREWALL_ENABLED', false)),

            'methods' => ['all'],

            'inspections' => [], // i.e. 'admin'

            'auto_block' => [
                'attempts' => 5,
                'frequency' => 1 * 60, // 1 minute
                'period' => 30 * 60, // 30 minutes
            ],
        ],

        'whitelist' => [
            'enabled' => env('FIREWALL_MIDDLEWARE_WHITELIST_ENABLED', env('FIREWALL_ENABLED', false)),

            'methods' => ['all'],

            'routes' => [
                'only' => config('allowed_urls'), // i.e. 'contact'
                'except' => config('allowed_parameterized_url'), // i.e. 'admin/*'
            ],
        ],

        'xss' => [
            'enabled' => env('FIREWALL_MIDDLEWARE_XSS_ENABLED', env('FIREWALL_ENABLED', false)),

            'methods' => ['post', 'put', 'patch'],

            'routes' => [
                'only' => config('allowed_urls'), // i.e. 'contact'
                'except' => config('allowed_parameterized_url'), // i.e. 'admin/*'
            ],

            'inputs' => [
                'only' => [], // i.e. 'first_name'
                'except' => [], // i.e. 'password'
            ],

            'patterns' => [
                '#(<[^>]+[\x00-\x20\"\'\/])(form|formaction|on\w*|style|xmlns|xlink:href)[^>]*>?#iUu',
                '!((java|live|vb)script|mocha|feed|data):(\w)*!iUu',
                '#-moz-binding[\x00-\x20]*:#u',
                '#</*(applet|meta|xml|blink|link|style|script|embed|object|iframe|frame|frameset|ilayer|layer|bgsound|title|base|img)[^>]*>?#i'
            ],#</*(applet|meta|xml|blink|link|style|script|embed|object|iframe|frame|frameset|ilayer|layer|bgsound|title|base|img)[^>]*>?#i'


            'auto_block' => [
                'attempts' => 1,
                'frequency' => 5 * 60, // 5 minutes
                'period' => 30 * 60, // 30 minutes
            ],
        ],

    ],

];
