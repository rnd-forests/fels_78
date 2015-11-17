<?php

namespace FELS\Core\Html;

class FormBuilder extends \Collective\Html\FormBuilder
{
    const DELETE_ICON = '<i class="fa fa-times"></i>';
    const RESTORE_ICON = '<i class="fa fa-arrow-left"></i>';

    /**
     * Delete form macro.
     *
     * @param $route
     * @param array $params
     * @param null $class
     * @return string
     */
    public function delete($route, $params = [], $class = null)
    {
        $open = $this->open(['method' => 'DELETE', 'route' => [$route, $params], 'class' => $class]);
        $button = $this->button(self::DELETE_ICON, ['type' => 'submit', 'class' => 'btn btn-danger btn-xs']);

        return "{$open}{$button}{$this->close()}";
    }

    /**
     * Restore form macro.
     *
     * @param $route
     * @param array $params
     * @param null $class
     * @return string
     */
    public function restore($route, $params = [], $class = null)
    {
        $open = $this->open(['method' => 'PUT', 'route' => [$route, $params], 'class' => $class]);
        $button = $this->button(self::RESTORE_ICON, ['type' => 'submit', 'class' => 'btn btn-primary btn-xs']);

        return "{$open}{$button}{$this->close()}";
    }

    /**
     * Submit button macro.
     *
     * @param $text
     * @param string $class
     * @param string $wrapper
     * @return string
     */
    public function submitBtn($text, $class = 'btn-primary', $wrapper = 'form-group')
    {
        return $this->wrap("<button type='submit' class='btn {$class}'>{$text} <i class='fa fa-arrow-right'></i></button>", $wrapper);
    }

    /**
     * Normal button macro.
     *
     * @param $text
     * @param string $class
     * @param string $wrapper
     * @return string
     */
    public function normalBtn($text, $class = 'btn-primary', $wrapper = 'form-group')
    {
        return $this->wrap("<button type='button' class='btn {$class}'>{$text} <i class='fa fa-arrow-right'></i></button>", $wrapper);
    }

    /**
     * Wrap Html contents.
     *
     * @param $html
     * @param string $container
     * @return string
     */
    protected function wrap($html, $container = 'form-group')
    {
        return empty($container) ? $html : "<div class='{$container}'>{$html}</div>";
    }
}
