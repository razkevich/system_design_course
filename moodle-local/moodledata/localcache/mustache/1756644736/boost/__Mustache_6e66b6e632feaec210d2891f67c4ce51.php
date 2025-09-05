<?php

class __Mustache_6e66b6e632feaec210d2891f67c4ce51 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="bulkselect d-none" data-for="cmBulkSelect">
';
        $buffer .= $indent . '    <input
';
        $buffer .= $indent . '        id="cmCheckbox';
        $value = $this->resolveValue($context->find('cmid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '        type="checkbox"
';
        $buffer .= $indent . '        data-id="';
        $value = $this->resolveValue($context->find('cmid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '        data-action="toggleSelectionCm"
';
        $buffer .= $indent . '        data-bulkcheckbox="1"
';
        $buffer .= $indent . '    >
';
        $buffer .= $indent . '    <label class="sr-only" for="cmCheckbox';
        $value = $this->resolveValue($context->find('cmid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '">
';
        $buffer .= $indent . '        ';
        $value = $context->find('str');
        $buffer .= $this->section0e82f2f3adc96348ff91cde0c8358689($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '    </label>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section0e82f2f3adc96348ff91cde0c8358689(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' selectcm, core_courseformat, {{activityname}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' selectcm, core_courseformat, ';
                $value = $this->resolveValue($context->find('activityname'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
