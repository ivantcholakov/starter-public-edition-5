<?php

namespace Common\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AssetsCompile extends BaseCommand
{
    protected $group       = 'Assets';
    protected $name        = 'assets:compile';
    protected $description = 'Executes prepared tasks for web-assets compilation.';

    protected $tasks;

    public function __construct()
    {
        $this->tasks = config('AssetsCompile')->tasks;
    }

    public function run(array $params)
    {
        if (empty($this->tasks)) {
            return;
        }

        $tasks = [];

        if (empty($params)) {

            $tasks = $this->tasks;

        } else {

            foreach ($params as $name) {

                if ($key = $this->find($name) !== false) {
                    $tasks[] = $this->tasks[$key];
                }
            }
        }

        if (empty($tasks)) {
            return;
        }

        foreach ($tasks as $task) {

            $source = isset($task['source']) ? (string) $task['source'] : '';

            if (isset($task['source'])) {

                if ($source == '') {
                    continue;
                }

                if (!is_file($source)) {
                    continue;
                }

                $task['source'] = $source;
            }

            $destination = isset($task['destination']) ? (string) $task['destination'] : '';

            if (isset($task['destination'])) {

                if ($destination == '') {
                    continue;
                }

                $dir = pathinfo($destination, PATHINFO_DIRNAME);
                file_exists($dir) OR mkdir($dir, DIR_WRITE_MODE, TRUE);

                if (!is_dir($dir)) {
                    continue;
                }

                $task['destination'] = $destination;
            }

            switch ($task['type']) {

                case 'less':

                    $this->less($task);

                    break;

                case 'scss':

                    $this->scss($task);

                    break;

                case 'autoprefixer':

                    $this->autoprefixer($task);

                    break;

                case 'cssmin':

                    $this->cssmin($task);

                    break;

                case 'jsmin':

                    $this->jsmin($task);

                    break;

                case 'jsonmin':

                    $this->jsonmin($task);

                    break;
            }

            if (isset($task['destination'])) {

                try {

                    write_file($task['destination'], $task['result']);
                    @chmod($task['destination'], FILE_WRITE_MODE);
                    unset($task['result']);

                    CLI::write(CLI::color($task['destination'], 'green'));

                } catch(Exception $e) {

                    CLI::write(CLI::color($e->getMessage(), 'yellow'));
                }
            }
        }

        CLI::newLine();
    }

    protected function find($name)
    {
        $key = array_search($name, array_column($this->tasks, 'name'));

        if (!is_int($key)) {
            $key = false;
        }

        return $key;
    }

    protected function less(& $task)
    {
        $task['result'] = '';

        $renderers = [];

        $renderers['less'] = isset($task['less']) ? $task['less'] : ['less' => []];

        if (isset($task['autoprefixer'])) {
            $renderers['autoprefixer'] = $task['autoprefixer'];
        }

        if (isset($task['cssmin'])) {
            $renderers['cssmin'] = $task['cssmin'];
        }

        $task['result'] = render_string(file_get_contents($task['source']), null, $renderers);
    }

    protected function scss(& $task)
    {
        $task['result'] = '';

        $renderers = [];

        $renderers['scss'] = isset($task['scss']) ? $task['scss'] : ['scss' => []];

        if (isset($task['autoprefixer'])) {
            $renderers['autoprefixer'] = $task['autoprefixer'];
        }

        if (isset($task['cssmin'])) {
            $renderers['cssmin'] = $task['cssmin'];
        }

        $task['result'] = render_string(file_get_contents($task['source']), null, $renderers);
    }

    protected function autoprefixer(& $task)
    {
        $task['result'] = '';

        $renderers = [];

        $renderers['autoprefixer'] = isset($task['autoprefixer']) ? $task['autoprefixer'] : ['autoprefixer' => []];

        if (isset($task['cssmin'])) {
            $renderers['cssmin'] = $task['cssmin'];
        }

        $task['result'] = render_string(file_get_contents($task['source']), null, $renderers);
    }

    protected function cssmin(& $task)
    {
        $task['result'] = '';

        $renderers = [];

        $renderers['cssmin'] = isset($task['cssmin']) ? $task['cssmin'] : ['cssmin' => []];

        $task['result'] = render_string(file_get_contents($task['source']), null, $renderers);
    }

    protected function jsmin(& $task)
    {
        $task['result'] = '';

        $renderers = [];

        $renderers['jsmin'] = isset($task['jsmin']) ? $task['jsmin'] : ['jsmin' => []];

        $task['result'] = render_string(file_get_contents($task['source']), null, $renderers);
    }

    protected function jsonmin(& $task)
    {
        $task['result'] = '';

        $renderers = [];

        $renderers['jsonmin'] = isset($task['jsonmin']) ? $task['jsonmin'] : ['jsonmin' => []];

        $task['result'] = render_string(file_get_contents($task['source']), null, $renderers);
    }

}
