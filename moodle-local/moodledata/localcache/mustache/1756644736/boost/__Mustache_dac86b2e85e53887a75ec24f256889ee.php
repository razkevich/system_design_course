<?php

class __Mustache_dac86b2e85e53887a75ec24f256889ee extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="d-flex">
';
        $value = $context->find('showrouteback');
        $buffer .= $this->section2f8c5f4f8ab31e5bcc3e416bc060ec32($context, $indent, $value);
        $buffer .= $indent . '    <div
';
        $buffer .= $indent . '        class="ms-2 rounded-circle bg-pulse-grey align-self-center"
';
        $buffer .= $indent . '        style="height: 38px; width: 38px"
';
        $buffer .= $indent . '    >
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div class="ms-2 " style="flex: 1">
';
        $buffer .= $indent . '        <div
';
        $buffer .= $indent . '            class="mt-1 bg-pulse-grey w-75"
';
        $buffer .= $indent . '            style="height: 16px;"
';
        $buffer .= $indent . '        >
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div
';
        $buffer .= $indent . '        class="ms-2 bg-pulse-grey align-self-center"
';
        $buffer .= $indent . '        style="height: 16px; width: 20px"
';
        $buffer .= $indent . '    >
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section2f8c5f4f8ab31e5bcc3e416bc060ec32(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="align-self-stretch" >
        <a class="h-100 me-2 d-flex align-items-center" href="#" data-route-back role="button">
            {{> core_message/message_drawer_icon_back }}
        </a>
    </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div class="align-self-stretch" >
';
                $buffer .= $indent . '        <a class="h-100 me-2 d-flex align-items-center" href="#" data-route-back role="button">
';
                if ($partial = $this->mustache->loadPartial('core_message/message_drawer_icon_back')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                $buffer .= $indent . '        </a>
';
                $buffer .= $indent . '    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
