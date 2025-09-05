<?php

class __Mustache_6146440e93ae6538584bb5fa8dc24adb extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="bulkselect align-self-center d-none" data-for="sectionBulkSelect">
';
        $buffer .= $indent . '    <input
';
        $buffer .= $indent . '        id="sectionCheckbox';
        $value = $this->resolveValue($context->find('id'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '        type="checkbox"
';
        $buffer .= $indent . '        data-id="';
        $value = $this->resolveValue($context->find('id'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '        data-action="toggleSelectionSection"
';
        $buffer .= $indent . '        data-bulkcheckbox="1"
';
        $buffer .= $indent . '    >
';
        $buffer .= $indent . '    <label class="sr-only" for="sectionCheckbox';
        $value = $this->resolveValue($context->find('id'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '">
';
        $buffer .= $indent . '        ';
        $value = $context->find('selecttext');
        $buffer .= $this->section26a997c0706a0096a58ec0235558eded($context, $indent, $value);
        $buffer .= '
';
        $value = $context->find('selecttext');
        if (empty($value)) {
            
            $buffer .= $indent . '            ';
            $value = $context->find('str');
            $buffer .= $this->sectionE8b5bef0ea41b805e1300115bf34bde1($context, $indent, $value);
            $buffer .= '
';
        }
        $buffer .= $indent . '    </label>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section26a997c0706a0096a58ec0235558eded(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' {{selecttext}} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' ';
                $value = $this->resolveValue($context->find('selecttext'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE8b5bef0ea41b805e1300115bf34bde1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' selectsection, core_courseformat, {{name}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' selectsection, core_courseformat, ';
                $value = $this->resolveValue($context->find('name'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
