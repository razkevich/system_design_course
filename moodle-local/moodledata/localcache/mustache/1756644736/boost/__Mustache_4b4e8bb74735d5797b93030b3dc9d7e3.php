<?php

class __Mustache_4b4e8bb74735d5797b93030b3dc9d7e3 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="section_availability">
';
        $value = $context->find('hasavailability');
        $buffer .= $this->section85d5c76946ccd7cbbf9acbcd25e5dfce($context, $indent, $value);
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function sectionDd3ad1e0227838ab66da2091a17f59a2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{> core_courseformat/local/content/availability }}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/availability')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEac66641554c80612e492bf7cfab5bbb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="availabilityinfo {{classes}}" data-region="availabilityinfo">
        {{^isrestricted}}
            <span class="badge rounded-pill bg-warning text-dark">{{{text}}}</span>
        {{/isrestricted}}
        {{#isrestricted}}
            {{> core_courseformat/local/content/availability }}
        {{/isrestricted}}
        </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="availabilityinfo ';
                $value = $this->resolveValue($context->find('classes'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" data-region="availabilityinfo">
';
                $value = $context->find('isrestricted');
                if (empty($value)) {
                    
                    $buffer .= $indent . '            <span class="badge rounded-pill bg-warning text-dark">';
                    $value = $this->resolveValue($context->find('text'), $context);
                    $buffer .= ($value === null ? '' : $value);
                    $buffer .= '</span>
';
                }
                $value = $context->find('isrestricted');
                $buffer .= $this->sectionDd3ad1e0227838ab66da2091a17f59a2($context, $indent, $value);
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section85d5c76946ccd7cbbf9acbcd25e5dfce(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{#info}}
        <div class="availabilityinfo {{classes}}" data-region="availabilityinfo">
        {{^isrestricted}}
            <span class="badge rounded-pill bg-warning text-dark">{{{text}}}</span>
        {{/isrestricted}}
        {{#isrestricted}}
            {{> core_courseformat/local/content/availability }}
        {{/isrestricted}}
        </div>
    {{/info}}
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('info');
                $buffer .= $this->sectionEac66641554c80612e492bf7cfab5bbb($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
