<?php

namespace BookApp\Runtime;


class BaseControl
{
    private $_controller;

    private $_action;

    private $_template;


    public function __construct(string $controller, string $action) {
        $this->_controller = $controller;
        $this->_action = $action;
    }

    protected function template(): Template {
        if (!$this->_template) {
            $this->_template = new Template(BASE_DIR . '/View', BASE_DIR . '/View/layout.php', $this->_controller, $this->_action);
        }

        return $this->_template;
    }
}
