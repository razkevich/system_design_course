<?php

class __Mustache_9d27527e4b0699c7bf35c0817eac1a78 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        if ($parent = $this->mustache->loadPartial('core/local/dropdown/dialog')) {
            $context->pushBlockContext(array(
                'dialogcontent' => array($this, 'block4d52894af2b01a050182660c5d27a26d'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $value = $context->find('js');
        $buffer .= $this->section089bb65385126842e4e0e5e6021c9374($context, $indent, $value);

        return $buffer;
    }

    private function sectionA5c0d3e9962c816b0fbbca97fe0e60c5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="pb-2 border-bottom">{{{dialogcontent}}}</div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="pb-2 border-bottom">';
                $value = $this->resolveValue($context->find('dialogcontent'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3aea061d488c8a53e6c1c39f25a9984e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{> core/local/choicelist }}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('core/local/choicelist')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5851aa9ef2803f3a4bcc89fb492924cb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{dropdownid}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->find('dropdownid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section089bb65385126842e4e0e5e6021c9374(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    require([\'core/local/dropdown/status\'], function(Module) {
        Module.init(\'#\' + \'{{$ dropdownid }}{{!
            }}{{#dropdownid}}{{dropdownid}}{{/dropdownid}}{{!
            }}{{^dropdownid}}dropdownDialog_{{uniqid}}{{/dropdownid}}{{!
        }}{{/ dropdownid }}\');
    });
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    require([\'core/local/dropdown/status\'], function(Module) {
';
                $buffer .= $indent . '        Module.init(\'#\' + \'';
                $blockFunction = $context->findInBlock('dropdownid');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    $value = $context->find('dropdownid');
                    $buffer .= $this->section5851aa9ef2803f3a4bcc89fb492924cb($context, $indent, $value);
                    $value = $context->find('dropdownid');
                    if (empty($value)) {
                        
                        $buffer .= 'dropdownDialog_';
                        $value = $this->resolveValue($context->find('uniqid'), $context);
                        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    }
                }
                $buffer .= '\');
';
                $buffer .= $indent . '    });
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block4d52894af2b01a050182660c5d27a26d($context)
    {
        $indent = $buffer = '';
        $value = $context->find('dialogcontent');
        $buffer .= $this->sectionA5c0d3e9962c816b0fbbca97fe0e60c5($context, $indent, $value);
        $value = $context->find('choices');
        $buffer .= $this->section3aea061d488c8a53e6c1c39f25a9984e($context, $indent, $value);
    
        return $buffer;
    }
}
