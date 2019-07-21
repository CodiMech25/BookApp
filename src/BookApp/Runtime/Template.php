<?php

namespace BookApp\Runtime;


class Template
{
    private $_source_dir;

    private $_layout_file_path;

    private $_template_file_path;

    private $_template_vars = [];


    public function __construct(string $source_dir, string $layout_file_path, string $controller, string $action) {
        $this->_source_dir = $source_dir;
        $this->_layout_file_path = $layout_file_path;
        $this->_template_file_path = $source_dir . '/' . $controller . '/' . $action . '.php';
    }

    public function set(string $name, $value): void {
        $this->_template_vars[$name] = $value;
    }

    public function display(): void {
        if (is_file($this->_template_file_path)) {
            ob_start();
            extract($this->_template_vars);
            include($this->_template_file_path);
            $_content = ob_get_contents();
            ob_end_clean();

            if (is_file($this->_layout_file_path)) {
                include($this->_layout_file_path);
            }
        }
    }
}
