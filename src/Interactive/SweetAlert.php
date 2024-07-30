<?php

namespace Itszun\Citadel\Interactive;

use Itszun\Citadel\InteractiveComponent;

class SweetAlert extends InteractiveComponent
{
    protected $config = [];
    protected string $title = "";
    protected string $text = "";
    protected array $buttons = []; // Can be a boolean or array of options
    protected int $timer = 0; // in milliseconds
    protected string $width = "500px";
    protected string $padding = "1.25rem";
    protected string $background = "#fff";
    protected string $position = "center"; // Possible values: 'top', 'top-start', 'top-end', 'center', 'center-start', 'center-end', 'bottom', 'bottom-start', 'bottom-end'
    protected bool $showConfirmButton = true;
    protected string $confirmButtonText = "OK";
    protected string $confirmButtonColor = "#3085d6";
    protected bool $showCancelButton = false;
    protected string $cancelButtonText = "Cancel";
    protected string $cancelButtonColor = "#d33";
    protected bool $allowOutsideClick = true;
    protected bool $allowEscapeKey = true;
    protected bool $allowEnterKey = true;
    protected string $input = ""; // Possible values: 'text', 'email', 'password', 'number', 'tel', 'range', 'textarea', 'select', 'radio', 'checkbox', 'file', 'url'
    protected string $inputPlaceholder = "";
    protected string $inputValue = "";
    protected string $customClass = "";
    protected string $footer = "";
    protected string $content = "";


    public function config(array $config)
    {
        $this->config = $config;
        return $this;
    }

    public function getData()
    {
        $hideOnUsingView = empty($this->view);
        return [
            'method' => 'fire',
            'config' => array_merge(
                [
                    'title' => $this->label,
                    'titleText' => $this->label,
                    'html' => $this->content,
                    'view' => $this->view ? route('citadel.get_view', $this->view) : null,
                    'text' => $this->label,
                    'icon' => $this->icon,
                    'buttons' => $this->buttons,
                    'timer' => $this->timer,
                    'width' => $this->width,
                    'padding' => $this->padding,
                    'background' => $this->background,
                    'position' => $this->position,
                    'showConfirmButton' => boolval($this->showConfirmButton * $hideOnUsingView),
                    'confirmButtonText' => $this->confirmButtonText,
                    'confirmButtonColor' => $this->confirmButtonColor,
                    'showCancelButton' => boolval($this->showCancelButton * $hideOnUsingView),
                    'cancelButtonText' => $this->cancelButtonText,
                    'cancelButtonColor' => $this->cancelButtonColor,
                    'allowOutsideClick' => $this->allowOutsideClick,
                    'allowEscapeKey' => $this->allowEscapeKey,
                    'allowEnterKey' => $this->allowEnterKey,
                    'input' => $this->input,
                    'inputPlaceholder' => $this->inputPlaceholder,
                    'inputValue' => $this->inputValue,
                    'customClass' => $this->customClass,
                    'footer' => $this->footer
                ],
                $this->config
            )
        ];
    }

    public function buttons($buttons = [])
    {
        $this->buttons = $buttons;
        return $this;
    }

    public function timer($timer = 0)
    {
        $this->timer = $timer;
        return $this;
    }

    public function width($width = "500px")
    {
        $this->width = $width;
        return $this;
    }

    public function padding($padding = "1.25rem")
    {
        $this->padding = $padding;
        return $this;
    }

    public function background($background = "#fff")
    {
        $this->background = $background;
        return $this;
    }

    public function position($position = "center")
    {
        $this->position = $position;
        return $this;
    }

    public function showConfirmButton($showConfirmButton = true)
    {
        $this->showConfirmButton = $showConfirmButton;
        return $this;
    }

    public function confirmButtonText($confirmButtonText = "OK")
    {
        $this->confirmButtonText = $confirmButtonText;
        return $this;
    }

    public function confirmButtonColor($confirmButtonColor = "#3085d6")
    {
        $this->confirmButtonColor = $confirmButtonColor;
        return $this;
    }

    public function showCancelButton($showCancelButton = false)
    {
        $this->showCancelButton = $showCancelButton;
        return $this;
    }

    public function cancelButtonText($cancelButtonText = "Cancel")
    {
        $this->cancelButtonText = $cancelButtonText;
        return $this;
    }

    public function cancelButtonColor($cancelButtonColor = "#d33")
    {
        $this->cancelButtonColor = $cancelButtonColor;
        return $this;
    }

    public function allowOutsideClick($allowOutsideClick = true)
    {
        $this->allowOutsideClick = $allowOutsideClick;
        return $this;
    }

    public function allowEscapeKey($allowEscapeKey = true)
    {
        $this->allowEscapeKey = $allowEscapeKey;
        return $this;
    }

    public function allowEnterKey($allowEnterKey = true)
    {
        $this->allowEnterKey = $allowEnterKey;
        return $this;
    }

    public function input($input = "")
    {
        $this->input = $input;
        return $this;
    }

    public function inputPlaceholder($inputPlaceholder = "")
    {
        $this->inputPlaceholder = $inputPlaceholder;
        return $this;
    }

    public function inputValue($inputValue = "")
    {
        $this->inputValue = $inputValue;
        return $this;
    }

    public function customClass($customClass = "")
    {
        $this->customClass = $customClass;
        return $this;
    }

    public function footer($footer = "")
    {
        $this->footer = $footer;
        return $this;
    }

    public function content($content = "")
    {
        $this->content = $content;
        return $this;
    }

    public function compile()
    {
        return json_encode([
            'sweet_alert' => $this->getData()
        ]);
    }
}
