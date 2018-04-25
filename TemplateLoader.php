<?php

namespace JazzMan\Template;

class TemplateLoader
{
    /**
     * @param        $name
     * @param string $dir
     *
     * @return string
     */
    public static function locate($name, $dir = '')
    {
        if ('' === $name) {
            wp_die('The parameter $name can not be empty');
        }
        $stylesheet_dir = get_stylesheet_directory();
        $template_dir = get_template_directory();
        if ('' === $dir) {
            $dir = $template_dir;
        }
        $tpl_dir = 'template';
        $template = locate_template("{$name}.php");
        if (!$template && !empty($name) && file_exists("{$stylesheet_dir}/{$tpl_dir}/{$name}.php")) {
            $template = "{$stylesheet_dir}/{$tpl_dir}/{$name}.php";
        }
        if (!$template && !empty($name) && file_exists("{$template_dir}/{$tpl_dir}/{$name}.php")) {
            $template = "{$template_dir}/{$tpl_dir}/{$name}.php";
        }
        if (!$template && !empty($name) && file_exists("{$dir}/{$tpl_dir}/{$name}.php")) {
            $template = "{$dir}/{$tpl_dir}/{$name}.php";
        }
        if (empty($template)) {
            wp_die(
                "Template <b> /{$tpl_dir}/{$name}.php </b> in plugin dir <b> {$dir} </b> not found.",
                'Template not found.'
            );
        }

        return $template;
    }

    /**
     * @param        $name
     * @param array  $args
     * @param string $dir
     *
     * @return string
     */
    public static function load($name = '', array $args = [], $dir = '')
    {
        if ('' === $name) {
            wp_die('The parameter $name can not be empty');
        }
        if (is_array($args) && count($args) > 0) {
            extract($args, EXTR_SKIP);
        }
        if ('' === $dir) {
            $dir = get_stylesheet_directory();
        }
        $path = self::locate($name, $dir);
        ob_start();
        include $path;
        $result = ob_get_contents();
        ob_end_clean();

        return $result;
    }
}
