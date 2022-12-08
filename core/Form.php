<?php

class Form
{
    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
        debug($controller->request->data->title);
    }

    public function input($name, $label, $options = [])
    {
        if ($label == "hidden") {
            return '<input type="hidden" name="' . $name . '" value="' . $this->controller->request->data->$name . '">';
        }

        $html = '<div class="form-group col-md-9">
                    <label for="input' . $name . '">' . $label . '</label>';
        $attr = "";
        foreach ($options as $k => $v) {
            if ($k != "type")
                $attr .= " $k='$v'";
        }

        // debug($this->controller->request);

        if (!isset($options["type"])) {
            $html .= '<input type="text" class="form-control" id="input' . $name . '" name="' . $name . '" value="' . $this->controller->request->data->$name . '">';
        } elseif ($options["type"] == "textarea") {
            $html .= '<textarea class="form-control" id="input' . $name . '" name="' . $name . '" ' . $attr . '>' . $this->controller->request->data->$name . '</textarea>';
        } elseif ($options["type"] == "checkbox") {
            $html .= '&nbsp;&nbsp;&nbsp;<input type="hidden" name="' . $name . '" value="0"><input type="checkbox" name="' . $name . '" value="1">';
        }

        $html .= '</div>';
        return $html;
    }
}
