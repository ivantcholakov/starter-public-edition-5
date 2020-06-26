<?php

namespace Common\Libraries;

/**
 * Registry library for CodeIgniter 4
 *
 * @author Ivan Tcholakov <ivantcholakov@gmail.com>, 2020
 * @license The MIT License, http://opensource.org/licenses/MIT
 *
 */

class Registry {

    protected $data = array();

    public function get($key) {

        if (is_array($key)) {

            $result = array();

            foreach ($key as $k) {
                $result[$k] = $this->get($k);
            }

            return $result;
        }

        $key = (string) $key;

        if ($key != '' && array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        return null;
    }

    public function getAll() {

        return $this->data;
    }

    public function set($key, $value = null) {

        if (is_array($key)) {

            foreach ($key as $k => $v) {
                $this->set($k, $v);
            }

            return $this;
        }

        $this->data[(string) $key] = $value;

        return $this;
    }

    public function has($key) {

        $key = (string) $key;

        return $key != '' && array_key_exists($key, $this->data);
    }

    public function delete($key) {

        if (is_array($key)) {

            foreach ($key as $k) {
                $this->delete($k);
            }

            return $this;
        }

        $key = (string) $key;

        if ($key != '' && array_key_exists($key, $this->data)) {
            unset($this->data[$key]);
        }

        return $this;
    }

    // Use this method for testing purposes only!
    public function destroy() {

        $this->data = array();

        return $this;
    }

}
