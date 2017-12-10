<?php
/**
 * Intergift.
 *
 * @link      https://github.com/adrosoftware/intergift
 *
 * @copyright Copyright (c) 2017 Adro Rocker
 * @author    Adro Rocker <mes@adro.rocks>
 */
namespace Intergift;

use BadMethodCallException;
use Dotenv\Dotenv;
use Intergift\Provider\Gateway\ApiGatewayProvider;
use Intergift\Provider\MailProvider;
use Intergift\Provider\ViewProvider;
use Intergift\Provider\ServiceProviderInterface;
use Slim\App;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Application
{
    protected $container;
    protected $providers = [];
    protected $base;
    protected $root;
    protected $configs = [];
    public $version = '0.2.2';
    protected $booted = false;

    public function __construct($root)
    {
        $this->base = ROOT_PATH . DIRECTORY_SEPARATOR . 'app';
        $this->root = ROOT_PATH;

        $this->bootstrap();
        $this->registerDefaultServices();
    }

    /**
     * Bootstrap the application.
     *
     * @return void
     */
    protected function bootstrap()
    {
        $this->createConstants();
        $dotenv = new Dotenv($this->root);
        $dotenv->overload();
        $this->setConfig();
        $slim = new App(["settings" => $this->configs['slim']]);
        $this->container = $slim->getContainer();
        $that = $this;
        $this->container['app'] = function ($container) use ($that) {
            return $that;
        };
        $this->container['slim'] = function ($container) use ($slim) {
            return $slim;
        };
        $this->container['app.settings'] = function ($container) use ($that) {
            return $that->configs;
        };
    }

    public function createConstants()
    {
        define('APP_PATH', realpath($this->base . '/app/'));
        define('PUBLIC_PATH', realpath($this->base . '/public/'));
        define('STORAGE_PATH', realpath($this->base . '/storage/'));
        define('VIEWS_PATH', realpath($this->base . '/resources/views/'));
        define('VERSION', $this->version);
    }

    public function setConfig()
    {
        foreach (glob($this->root . '/config/*.php') as $configFile) {
            require $configFile;
        }
        $appConfig = $this->container['settings'];
        foreach ($config as $key => $value) {
            $appConfig[$key] = $value;
        }

        $this->configs = $appConfig;

        return $this;
    }

    /**
     * This function registers the default services that Engine needs to run.
     *
     * @return void
     */
    protected function registerDefaultServices()
    {
        $this
            ->register(new MailProvider)
            ->register(new ViewProvider)
            ->register(new ApiGatewayProvider);
    }

    public function run()
    {
        if (!$this->booted) {
            $this->boot();
        }

        $this->container->get('slim')->run();
    }

    /**
     * Registers a service provider.
     *
     * @param ServiceProviderInterface $provider A ServiceProviderInterface instance
     * @param array                    $values   An array of values that customizes the provider
     *
     * @return Application
     */
    public function register(ServiceProviderInterface $provider, array $values = array())
    {
        $provider->register($this->container);
        foreach ($values as $key => $value) {
            $this->container[$key] = $value;
        }
        $this->providers[] = $provider;
        return $this;
    }

    /**
     * Boots all service providers.
     *
     * This method is automatically called by run(), but you can use it
     * to boot all service providers when not handling a request.
     */
    public function boot()
    {
        if (!$this->booted) {
            foreach ($this->providers as $provider) {
                $provider->boot($this->container);
            }
            $this->booted = true;
        }
    }
}
