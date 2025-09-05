<?php

class __Mustache_85481a3894a22b83117cb3659525bb0f extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="d-flex flex-column choicelist p-1" role="listbox">
';
        $value = $context->find('options');
        $buffer .= $this->section01c4a3d5666c5c553237c94ac350ff7f($context, $indent, $value);
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section01c4a3d5666c5c553237c94ac350ff7f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{> core/local/choicelist/option}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('core/local/choicelist/option')) {
                    $buffer .= $partial->renderInternal($context, $indent . '        ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
