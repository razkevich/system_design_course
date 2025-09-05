<?php

class __Mustache_10970359e4893f8705ed8fee4ba1c1fe extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="hidden border-bottom p-1 px-sm-2 pb-sm-3" aria-hidden="true" data-region="view-settings">
';
        $buffer .= $indent . '    <div class="d-flex align-items-center">
';
        $value = $context->find('isdrawer');
        $buffer .= $this->section954922f74056d5492a960e51aac6be7e($context, $indent, $value);
        $buffer .= $indent . '        <div>
';
        $buffer .= $indent . '            ';
        $value = $context->find('str');
        $buffer .= $this->section89fe6ec2ad927929ef01bc4d6a8446c4($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section954922f74056d5492a960e51aac6be7e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="align-self-stretch" >
            <a class="h-100 d-flex me-2 align-items-center" href="#" data-route-back role="button">
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
                
                $buffer .= $indent . '        <div class="align-self-stretch" >
';
                $buffer .= $indent . '            <a class="h-100 d-flex me-2 align-items-center" href="#" data-route-back role="button">
';
                if ($partial = $this->mustache->loadPartial('core_message/message_drawer_icon_back')) {
                    $buffer .= $partial->renderInternal($context, $indent . '                ');
                }
                $buffer .= $indent . '            </a>
';
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section89fe6ec2ad927929ef01bc4d6a8446c4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' settings, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' settings, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
