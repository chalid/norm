<?php

namespace Norm\Schema;

class DateTime extends Field
{
    public function prepare($value)
    {
        if (empty($value)) {
            return null;
        } elseif ($value instanceof \Norm\Type\DateTime) {
            return $value;
        } elseif ($value instanceof \DateTime) {
            $t = $value->format('c');
        } elseif (is_string($value)) {
            $t = date('c', strtotime($value));
        } else {
            $t = date('c', (int) $value);
        }
        return new \Norm\Type\DateTime($t);
    }

    public function presetInput($value, $entry = null)
    {
        $value = $this->prepare($value);
        return '<input type="datetime-local" name="'.$this['name'].'" value="'.
            ($value ? $value->format("Y-m-d\TH:i") : '').'" placeholder="'.
            $this['label'].'" autocomplete="off" />';
    }

    public function presetReadonly($value, $entry = null)
    {
        $value = $this->prepare($value);
        return '<span class="field">'.($value ? $value->format('c') : '&nbsp;').'</span>';
    }

    // DEPRECATED replaced by Field::render
    // public function cell($value, $entry = null)
    // {
    //     if ($this->has('cellFormat') && $format = $this['cellFormat']) {
    //         return $format($value, $entry);
    //     }
    //     return $value->format('Y-m-d H:i:s a');
    // }
}
