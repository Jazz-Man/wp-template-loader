<?php

use JazzMan\Template\TemplateLoader;

if (!function_exists('view')) {
    /**
     * @param string $name
     * @param array  $args
     * @param string $dir
     *
     * @return string
     *
     * @throws \Exception
     */
    function view($name, array $args = [], $dir = '')
    {
        return TemplateLoader::load($name, $args, $dir);
    }
}

if (!function_exists('view_compress')) {
    function view_compress($html)
    {
        $search = [
          '/>[^\S ]+/s',   // strip whitespaces after tags, except space
          '/[^\S ]+</s',   // strip whitespaces before tags, except space
          '/(\s)+/s',  // shorten multiple whitespace sequences
          '/<!--(.|\s)*?-->/', // Remove HTML comments
        ];
        $replace = [
          '>',
          '<',
          '\\1',
          '',
        ];
        $html = preg_replace($search, $replace, $html);

        return $html;
    }
}
