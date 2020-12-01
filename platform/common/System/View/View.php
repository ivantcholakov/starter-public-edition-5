<?php

/**
 * This file is part of the CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeIgniter\View;

use CodeIgniter\View\Exceptions\ViewException;
use Config\Services;
use Psr\Log\LoggerInterface;

/**
 * Class View
 */
class View implements RendererInterface
{
    /**
     * Data that is made available to the Views.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Merge savedData and userData
     */
    protected $tempData = null;

    /**
     * The base directory to look in for our Views.
     *
     * @var string
     */
    protected $viewPath;

    /**
     * The render variables
     *
     * @var array
     */
    protected $renderVars = [];

    /**
     * Instance of FileLocator for when
     * we need to attempt to find a view
     * that's not in standard place.
     *
     * @var \CodeIgniter\Autoloader\FileLocator
     */
    protected $loader;

    /**
     * Logger instance.
     *
     * @var \CodeIgniter\Log\Logger
     */
    protected $logger;

    /**
     * Should we store performance info?
     *
     * @var boolean
     */
    protected $debug = false;

    /**
     * Cache stats about our performance here,
     * when CI_DEBUG = true
     *
     * @var array
     */
    protected $performanceData = [];

    /**
     * @var \Config\View
     */
    protected $config;

    /**
     * Whether data should be saved between renders.
     *
     * @var boolean
     */
    protected $saveData;

    /**
     * Number of loaded views
     *
     * @var integer
     */
    protected $viewsCount = 0;

    /**
     * The name of the layout being used, if any.
     * Set by the `extend` method used within views.
     *
     * @var string
     */
    protected $layout;

    /**
     * Holds the sections and their data.
     *
     * @var array
     */
    protected $sections = [];

    /**
     * The name of the current section being rendered,
     * if any.
     *
     * @var string
     */
    protected $currentSection;

    /**
     * Selects a renderer-driver to be applied on a view.
     *
     * @var \Common\Modules\Renderers\Renderers
     */
    protected $driverManager;

    //--------------------------------------------------------------------

    /**
     * Constructor
     *
     * @param \Config\View    $config
     * @param string          $viewPath
     * @param mixed           $loader
     * @param boolean         $debug
     * @param LoggerInterface $logger
     */
    public function __construct($config, string $viewPath = null, $loader = null, bool $debug = null, LoggerInterface $logger = null)
    {
        $this->config   = $config;
        $this->viewPath = rtrim($viewPath, '/ ') . '/';
        $this->loader   = is_null($loader) ? Services::locator() : $loader;
        $this->logger   = is_null($logger) ? Services::logger() : $logger;
        $this->debug    = is_null($debug) ? CI_DEBUG : $debug;
        $this->saveData = $config->saveData ?? null;
        $this->driverManager = new \Common\Modules\Renderers\Renderers();
    }

    //--------------------------------------------------------------------

    /**
     * Builds the output based upon a file name and any
     * data that has already been set.
     *
     * Valid $options:
     *     - cache         number of seconds to cache for
     *  - cache_name    Name to use for cache
     *
     * @param string  $view
     * @param array   $options
     * @param boolean $saveData
     *
     * @return string
     */
    public function render(string $view, array $options = null, bool $saveData = null): string
    {
        $this->renderVars['start'] = microtime(true);

        $this->output = '';

        // Store the results here so even if
        // multiple views are called in a view, it won't
        // clean it unless we mean it to.
        if (is_null($saveData))
        {
            $saveData = $this->saveData;
        }

        $this->driverChain = $this->driverManager->getDriverChain('view', $options, $view, $this->viewPath, $this->loader);

        $this->renderVars['view']    = $this->driverChain[0]['view'];
        $this->renderVars['options'] = $options;
        $this->renderVars['file']    = $this->driverChain[0]['file'];

        // Was it cached?
        if (isset($this->renderVars['options']['cache']))
        {
            $this->renderVars['cacheName'] = $this->renderVars['options']['cache_name'] ?? $this->driverChain[0]['fileName'];

            if ($this->output = cache($this->renderVars['cacheName']))
            {
                $this->logPerformance($this->renderVars['start'], microtime(true), $this->renderVars['view']);
                return $this->output;
            }
        }

        // Make our view data available to the view.

        if (is_null($this->tempData))
        {
            $this->tempData = $this->data;
        }

        if (isset($this->tempData['saveData']) && $this->tempData['saveData'])
        {
            $this->data = $this->tempData;
        }

        $this->currentDriver = null;
        $this->currentRenderer = null;

        foreach ($this->driverChain as $this->currentDriver) {

            if (!empty($this->currentDriver['first'])) {

                if ($this->currentDriver['name'] == 'php') {

                    extract($this->tempData);

                    ob_start();
                    include($this->currentDriver['file']); // PHP will be processed
                    $this->output = ob_get_contents();
                    @ob_end_clean();

                } else {

                    $this->currentRenderer = $this->driverManager->createRenderer($this->currentDriver['name']);
                    $this->output = $this->currentRenderer->render($this->currentDriver['file'], $this->tempData, $this->currentDriver['options']);
                }

            } else {

                $this->currentRenderer = $this->driverManager->createRenderer($this->currentDriver['name']);
                $this->output = $this->currentRenderer->renderString($this->output, [], $this->currentDriver['options']);
            }
        }

        // When using layouts, the data has already been stored
        // in $this->sections, and no other valid output
        // is allowed in $this->output so we'll overwrite it.
        if (! is_null($this->layout) && empty($this->currentSection))
        {
            $layoutView   = $this->layout;
            $this->layout = null;
            $this->output = $this->render($layoutView, $options, $saveData);
        }

        $this->logPerformance($this->renderVars['start'], microtime(true), $this->renderVars['view']);

        if ($this->debug && (! isset($options['debug']) || $options['debug'] === true))
        {
            $toolbarCollectors = config(\Config\Toolbar::class)->collectors;

            if (in_array(\CodeIgniter\Debug\Toolbar\Collectors\Views::class, $toolbarCollectors))
            {
                $pretty_paths = ['APPPATH', 'COMMONPATH', 'SYSTEMPATH', 'ROOTPATH'];

                if (defined('VENDORPATH'))
                {
                    $pretty_paths[] = 'VENDORPATH';
                }

                // Clean up our path names to make them a little cleaner
                foreach ($pretty_paths as $path)
                {
                    if (strpos($this->renderVars['file'], constant($path)) === 0)
                    {
                        $this->renderVars['file'] = str_replace(constant($path), $path . '/', $this->renderVars['file']);
                        break;
                    }
                }
                $this->renderVars['file'] = ++$this->viewsCount . ' ' . $this->renderVars['file'];
                $this->output                   = '<!-- DEBUG-VIEW START ' . $this->renderVars['file'] . ' -->' . PHP_EOL
                    . $this->output . PHP_EOL
                    . '<!-- DEBUG-VIEW ENDED ' . $this->renderVars['file'] . ' -->' . PHP_EOL;
            }
        }

        // Should we cache?
        if (isset($this->renderVars['options']['cache']))
        {
            cache()->save($this->renderVars['cacheName'], $this->output, (int) $this->renderVars['options']['cache']);
        }

        $this->tempData = null;

        return $this->output;
    }

    //--------------------------------------------------------------------

    /**
     * Builds the output based upon a string and any
     * data that has already been set.
     * Cache does not apply, because there is no "key".
     *
     * @param string  $view     The view contents
     * @param array   $options  Reserved for 3rd-party uses since
     *                          it might be needed to pass additional info
     *                          to other template engines.
     * @param boolean $saveData If true, will save data for use with any other calls,
     *                          if false, will clean the data after displaying the view,
     *                             if not specified, use the config setting.
     *
     * @return string
     */
    public function renderString(string $view, array $options = null, bool $saveData = null): string
    {
        $start = microtime(true);

        $this->output = $view;

        $this->driverChain = $this->driverManager->getDriverChain('string', $options, $view);

        if (is_null($saveData))
        {
            $saveData = $this->saveData;
        }

        if (is_null($this->tempData))
        {
            $this->tempData = $this->data;
        }

        if (isset($this->tempData['saveData']) && $this->tempData['saveData'])
        {
            $this->data = $this->tempData;
        }

        if (empty($this->driverChain)) {

            extract($this->tempData);

            ob_start();
            $incoming = '?>' . $view;
            eval($incoming);
            $this->output = ob_get_contents();
            @ob_end_clean();

        } else {

            foreach ($this->driverChain as $this->currentDriver) {

                $this->currentRenderer = $this->driverManager->createRenderer($this->currentDriver['name']);
                $this->output = $this->currentRenderer->renderString(!empty($this->currentDriver['first']) ? $view : $this->output, !empty($this->currentDriver['first']) ? $this->tempData : [], $this->currentDriver['options']);
            }
        }

        $this->logPerformance($start, microtime(true), $this->excerpt($view));

        $this->tempData = null;

        return $this->output;
    }

    //--------------------------------------------------------------------

    /**
     * Extract first bit of a long string and add ellipsis
     *
     * @param  string  $string
     * @param  integer $length
     * @return string
     */
    public function excerpt(string $string, int $length = 20): string
    {
        return (\UTF8::strlen($string) > $length) ? \UTF8::substr($string, 0, $length - 3) . '...' : $string;
    }

    //--------------------------------------------------------------------

    /**
     * Sets several pieces of view data at once.
     *
     * @param array  $data
     * @param string $context The context to escape it for: html, css, js, url
     *                        If null, no escaping will happen
     *
     * @return RendererInterface
     */
    public function setData(array $data = [], string $context = null): RendererInterface
    {
        if (! empty($context))
        {
            $data = \esc($data, $context);
        }

        $this->tempData = $this->tempData ?? $this->data;
        $this->tempData = array_merge($this->tempData, $data);

        return $this;
    }

    //--------------------------------------------------------------------

    /**
     * Sets a single piece of view data.
     *
     * @param string $name
     * @param mixed  $value
     * @param string $context The context to escape it for: html, css, js, url
     *                        If null, no escaping will happen
     *
     * @return RendererInterface
     */
    public function setVar(string $name, $value = null, string $context = null): RendererInterface
    {
        if (! empty($context))
        {
            $value = \esc($value, $context);
        }

        $this->tempData        = $this->tempData ?? $this->data;
        $this->tempData[$name] = $value;

        return $this;
    }

    //--------------------------------------------------------------------

    /**
     * Removes all of the view data from the system.
     *
     * @return RendererInterface
     */
    public function resetData(): RendererInterface
    {
        $this->data = [];

        return $this;
    }

    //--------------------------------------------------------------------

    /**
     * Returns the current data that will be displayed in the view.
     *
     * @return array
     */
    public function getData(): array
    {
        return is_null($this->tempData) ? $this->data : $this->tempData;
    }

    //--------------------------------------------------------------------

    /**
     * Specifies that the current view should extend an existing layout.
     *
     * @param string $layout
     *
     * @return void
     */
    public function extend(string $layout)
    {
        $this->layout = $layout;
    }

    //--------------------------------------------------------------------

    /**
     * Starts holds content for a section within the layout.
     *
     * @param string $name
     */
    public function section(string $name)
    {
        $this->currentSection = $name;

        ob_start();
    }

    //--------------------------------------------------------------------

    /**
     *
     *
     * @throws \Laminas\Escaper\Exception\RuntimeException
     */
    public function endSection()
    {
        $contents = ob_get_clean();

        if (empty($this->currentSection))
        {
            throw new \RuntimeException('View themes, no current section.');
        }

        // Ensure an array exists so we can store multiple entries for this.
        if (! array_key_exists($this->currentSection, $this->sections))
        {
            $this->sections[$this->currentSection] = [];
        }
        $this->sections[$this->currentSection][] = $contents;

        $this->currentSection = null;
    }

    //--------------------------------------------------------------------

    /**
     * Renders a section's contents.
     *
     * @param string $sectionName
     */
    public function renderSection(string $sectionName)
    {
        if (! isset($this->sections[$sectionName]))
        {
            echo '';

            return;
        }

        foreach ($this->sections[$sectionName] as $key => $contents)
        {
            echo $contents;
            unset($this->sections[$sectionName][$key]);
        }
    }

    //--------------------------------------------------------------------

    /**
     * Used within layout views to include additional views.
     *
     * @param string     $view
     * @param array|null $options
     * @param null       $saveData
     *
     * @return string
     */
    public function include(string $view, array $options = null, $saveData = true): string
    {
        return $this->render($view, $options, $saveData);
    }

    //--------------------------------------------------------------------

    /**
     * Returns the performance data that might have been collected
     * during the execution. Used primarily in the Debug Toolbar.
     *
     * @return array
     */
    public function getPerformanceData(): array
    {
        return $this->performanceData;
    }

    //--------------------------------------------------------------------

    /**
     * Logs performance data for rendering a view.
     *
     * @param float  $start
     * @param float  $end
     * @param string $view
     *
     * @return void
     */
    protected function logPerformance(float $start, float $end, string $view)
    {
        if ($this->debug)
        {
            $this->performanceData[] = [
                'start' => $start,
                'end'   => $end,
                'view'  => $view,
            ];
        }
    }

    //--------------------------------------------------------------------
}
