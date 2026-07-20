<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     */
    public array $aliases = [
        'auth'      => \App\Filters\AuthFilter::class,
        'adminOnly' => \App\Filters\AdminOnlyFilter::class,
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * 'auth' and 'adminOnly' are applied globally (matched against the raw
     * request URI) rather than only to the explicit routes declared in
     * Config/Routes.php, because $routes->setAutoRoute(true) lets requests
     * reach controller actions (e.g. estudiantes/insertar) that have no
     * matching explicit route entry, and a filter attached only to a route
     * group does not cover those auto-routed URIs.
     */
    public array $globals = [
        'before' => [
            'csrf',
            'auth'      => ['except' => ['/', 'auth*']],
            'adminOnly' => ['except' => ['/', 'auth*', 'perfil*', 'ticket/*', 'ticketestudiante*', 'cajas*']],
            // 'honeypot',
            // 'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public array $filters = [];
}
