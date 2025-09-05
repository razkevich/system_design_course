<?php

class __Mustache_ee255af427eed6dad70a425ef0bdca5c extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<button type="button" id="';
        $value = $this->resolveValue($context->find('id'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" name="';
        $value = $this->resolveValue($context->find('name'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" class="btn ';
        $value = $context->find('classes');
        if (empty($value)) {
            
            $buffer .= 'btn-secondary';
        }
        $value = $context->find('classes');
        $buffer .= $this->sectionE6922901afa7b60d3ce7403587f8d6c3($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '        data-action="toggle"
';
        $buffer .= $indent . '        data-toggle="master"
';
        $buffer .= $indent . '        data-togglegroup="';
        $value = $this->resolveValue($context->find('togglegroup'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '        data-toggle-selectall="';
        $value = $this->resolveValue($context->find('selectall'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '        data-toggle-deselectall="';
        $value = $this->resolveValue($context->find('deselectall'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '        data-checkall="';
        $value = $context->find('checked');
        $buffer .= $this->section25ed38da0604bdcd7bd0273e4c22c02f($context, $indent, $value);
        $value = $context->find('checked');
        if (empty($value)) {
            
            $buffer .= '1';
        }
        $buffer .= '">
';
        $buffer .= $indent . '    ';
        $value = $context->find('checked');
        $buffer .= $this->sectionC9e15905ecd0bd243cdfd871396c8467($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '    ';
        $value = $context->find('checked');
        if (empty($value)) {
            
            $value = $this->resolveValue($context->find('selectall'), $context);
            $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        }
        $buffer .= '
';
        $buffer .= $indent . '</button>
';
        $buffer .= $indent . '
';
        $value = $context->find('js');
        $buffer .= $this->section451b44f1418afb36761b48b7959f5770($context, $indent, $value);

        return $buffer;
    }

    private function sectionE6922901afa7b60d3ce7403587f8d6c3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{.}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section25ed38da0604bdcd7bd0273e4c22c02f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '0';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '0';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC9e15905ecd0bd243cdfd871396c8467(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{deselectall}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->find('deselectall'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section451b44f1418afb36761b48b7959f5770(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    require([\'core/checkbox-toggleall\'], function(ToggleAll) {
        ToggleAll.init();
    });
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    require([\'core/checkbox-toggleall\'], function(ToggleAll) {
';
                $buffer .= $indent . '        ToggleAll.init();
';
                $buffer .= $indent . '    });
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
