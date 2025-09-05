<?php

class __Mustache_7281db8c4a5d5669438ccf2d8dcc6744 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $context->find('editing');
        $buffer .= $this->section80e21989d5fdd3d00773427c1afd4404($context, $indent, $value);
        $buffer .= $indent . '<div class="activity-item focus-control ';
        $value = $context->find('modstealth');
        $buffer .= $this->section814a15334b0fb146a25cc098588d4305($context, $indent, $value);
        $value = $context->find('modhiddenfromstudents');
        $buffer .= $this->section814a15334b0fb146a25cc098588d4305($context, $indent, $value);
        $value = $context->find('modinline');
        $buffer .= $this->sectionF4430bb1912fef25dc28340642a01da8($context, $indent, $value);
        $buffer .= '" data-activityname="';
        $value = $this->resolveValue($context->find('activityname'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" data-region="activity-card">
';
        $value = $context->find('cmbulk');
        $buffer .= $this->section6f52f19ec19a16e36719dc3780e54aa5($context, $indent, $value);
        $blockFunction = $context->findInBlock('core_courseformat/local/content/cm/activity');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/cm/activity')) {
                $buffer .= $partial->renderInternal($context, $indent . '        ');
            }
        }
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function sectionEb03b5bcdb70aa4ea488d5eb87d6ff9b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{> core_course/activitychooserbutton}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('core_course/activitychooserbutton')) {
                    $buffer .= $partial->renderInternal($context);
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section80e21989d5fdd3d00773427c1afd4404(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{< core_courseformat/local/content/divider}}
        {{$content}}
            {{#activitychooserbutton}}{{> core_course/activitychooserbutton}}{{/activitychooserbutton}}
        {{/content}}
    {{/ core_courseformat/local/content/divider}}
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    ';
                if ($parent = $this->mustache->loadPartial('core_courseformat/local/content/divider')) {
                    $context->pushBlockContext(array(
                        'content' => array($this, 'block55bdb099b18b9cee0a91e98e82462e23'),
                    ));
                    $buffer .= $parent->renderInternal($context, $indent);
                    $context->popBlockContext();
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section814a15334b0fb146a25cc098588d4305(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'hiddenactivity';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'hiddenactivity';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF4430bb1912fef25dc28340642a01da8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'activityinline';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'activityinline';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6f52f19ec19a16e36719dc3780e54aa5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{$ core_courseformat/local/content/cm/bulkselect }}
            {{> core_courseformat/local/content/cm/bulkselect }}
        {{/ core_courseformat/local/content/cm/bulkselect }}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/cm/bulkselect');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/cm/bulkselect')) {
                        $buffer .= $partial->renderInternal($context, $indent . '            ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block55bdb099b18b9cee0a91e98e82462e23($context)
    {
        $indent = $buffer = '';
        $buffer .= '            ';
        $value = $context->find('activitychooserbutton');
        $buffer .= $this->sectionEb03b5bcdb70aa4ea488d5eb87d6ff9b($context, $indent, $value);
        $buffer .= '
';
    
        return $buffer;
    }
}
