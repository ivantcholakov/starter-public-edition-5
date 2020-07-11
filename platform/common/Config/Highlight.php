<?php namespace Common\Config;

class Highlight extends \Common\Modules\Renderers\Config\Highlight
{
    public function __construct()
    {
        parent::__construct();

        // Do not edit the following statement.
        $parent_vars = array_except(
            get_object_vars($this), array_merge(
                array_keys(get_class_vars(parent::class)),
                ['config']
            )
        );

        //--------------------------------------------------------------------
        // Configuration Options, You May Edit Them
        //--------------------------------------------------------------------

        // highlight.php is a server-side syntax highlighter written in PHP
        // that currently supports 185 languages. It's a port of highlight.js
        // by Ivan Sagalaev that makes full use of the language and style
        // definitions of the original JavaScript project.
        // See https://github.com/scrivo/highlight.php

        // Pointing out which languages to be used for syntax highlighting.
        // If none are set - language autodetection is going to be applied.
        // If only one language is set - it will be assumed explicitly.
        $this->languages = [];

        //--------------------------------------------------------------------
        // Do Not Edit Below This Line
        //--------------------------------------------------------------------

        $this->config = array_merge(
            $this->config, $parent_vars,
            array_except(
                get_object_vars($this), array_merge(
                    array_keys(get_class_vars(parent::class)),
                    ['config']
                )
            )
        );
    }

    //------------------------------------------------------------------------

}
