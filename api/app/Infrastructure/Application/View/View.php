<?php

namespace Intergift\Infrastructure\Application\View;

use Psr\Http\Message\ResponseInterface;
use League\Plates\Engine;

class View
{
    protected $engine;

    protected $data = [];

    protected $publish;

    public function __construct(Engine $engine)
    {
        $this->engine = $engine;

        $this->setInitialData();
    }

    public function data($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function render($view, ResponseInterface $response, $data = [])
    {
        $this->data = array_merge($this->data, $data);

        $template = $this->engine->addData($this->data)->make($view);

        $content = $template->render($data);

        return $response->write($content);
    }

    public function fetch($view, $data = [])
    {
        $this->data = array_merge($this->data, $data);

        $template = $this->engine->addData($this->data)->make($view);

        $content = $template->render($data);

        return $content;
    }

    protected function setInitialData()
    {
        /** default title */
        $this->data['title'] = '';
        /** meta tag and information */
        $this->data['meta'] = array();
        /** queued css files */
        $this->data['css'] = array(
            'internal'  => array(),
            'external'  => array()
        );
        /** queued js files */
        $this->data['js'] = array(
            'internal'  => array(),
            'external'  => array(),
            'snippets'  => array(),
        );
        /** prepared message info */
        $this->data['message'] = array(
            'error'    => array(),
            'info'    => array(),
            'debug'    => array(),
        );
        /** global javascript var */
        $this->data['global'] = array();
        /** base dir for asset file */
        // $this->data['baseUrl']  = $this->baseUrl();
        // $this->data['assetUrl'] = $this->data['baseUrl'].'/public/';
    }

     /**
     * enqueue css asset to be loaded
     * @param  [string] $css     [css file to be loaded relative to base_asset_dir]
     * @param  [array]  $options [location=internal|external, position=first|last|after:file|before:file]
     */
    public function loadCss($css, $options = array())
    {
        $location = (isset($options['location'])) ? $options['location']:'internal';

        //after:file, before:file, first, last
        $position = (isset($options['position'])) ? $options['position']:'last';

        if (!in_array($css, $this->data['css'][$location])) {
            if ($position=='first' || $position=='last') {
                $key = $position;
                $file='';
            } else {
                list($key, $file) =  explode(':', $position);
            }

            switch ($key) {
                case 'first':
                    array_unshift($this->data['css'][$location], $css);
                    break;

                case 'last':
                    $this->data['css'][$location][]=$css;
                    break;

                case 'before':
                case 'after':
                    $varkey = array_keys($this->data['css'][$location], $file);
                    if ($varkey) {
                        $nextkey = ($key=='after') ? $varkey[0]+1 : $varkey[0];
                        array_splice($this->data['css'][$location], $nextkey, 0, $css);
                    } else {
                        $this->data['css'][$location][] = $css;
                    }
                    break;
            }
        }

        return $this;
    }


    /**
     * enqueue js asset to be loaded
     * @param  [string] $js      [js file to be loaded relative to base_asset_dir]
     * @param  [array]  $options [location=internal|external, position=first|last|after:file|before:file]
     */
    public function loadJs($js, $options = array())
    {
        $location = (isset($options['location'])) ? $options['location']:'internal';

        //after:file, before:file, first, last
        $position = (isset($options['position'])) ? $options['position']:'last';

        if (!in_array($js, $this->data['js'][$location])) {
            if ($position=='first' || $position=='last') {
                $key = $position;
                $file='';
            } else {
                list($key, $file) =  explode(':', $position);
            }

            switch ($key) {
                case 'first':
                    array_unshift($this->data['js'][$location], $js);
                    break;

                case 'last':
                    $this->data['js'][$location][] = $js;
                    break;

                case 'before':
                case 'after':
                    $varkey = array_keys($this->data['js'][$location], $file);
                    if ($varkey) {
                        $nextkey = ($key=='after') ? $varkey[0]+1 : $varkey[0];
                        array_splice($this->data['js'][$location], $nextkey, 0, $js);
                    } else {
                        $this->data['js'][$location][] = $js;
                    }
                    break;
            }
        }

        return $this;
    }

    public function loadJsSnippet($code)
    {
        $this->data['js']['snippets'][] = $code;

        return $this;
    }


    /**
     * clear enqueued css asset
     */
    protected function resetCss()
    {
        $this->data['css'] = array(
            'internal'  => array(),
            'external'  => array()
        );

        return $this;
    }

    /**
     * clear enqueued js asset
     */
    protected function resetJs()
    {
        $this->data['js'] = array(
            'internal'  => array(),
            'external'  => array(),
            'snippets'  => array()
        );

        return $this;
    }

    /**
     * remove individual css file from queue list
     * @param  [string] $css [css file to be removed]
     */
    protected function removeCss($css)
    {
        $key = array_keys($this->data['css']['internal'], $css);
        if ($key) {
            array_splice($this->data['css']['internal'], $key[0], 1);
        }

        $key=array_keys($this->data['css']['external'], $css);
        if ($key) {
            array_splice($this->data['css']['external'], $key[0], 1);
        }

        return $this;
    }

    /**
     * remove individual js file from queue list
     * @param  [string] $js [js file to be removed]
     */
    protected function removeJs($js)
    {
        $key=array_keys($this->data['js']['internal'], $js);
        if ($key) {
            array_splice($this->data['js']['internal'], $key[0], 1);
        }

        $key = array_keys($this->data['js']['external'], $js);
        if ($key) {
            array_splice($this->data['js']['external'], $key[0], 1);
        }

        return $this;
    }

    /**
     * register global variable to be accessed via javascript
     */
    protected function publish($key, $val)
    {
        $this->data['global'][$key] =  $val;

        return $this;
    }

    /**
     * remove published variable from registry
     */
    protected function unpublish($key)
    {
        unset($this->data['global'][$key]);

        return $this;
    }

    /**
     * add custom meta tags to the page
     */
    protected function meta($name, $content)
    {
        $this->data['meta'][$name] = $content;

        return $this;
    }
}
