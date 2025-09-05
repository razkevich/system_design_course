<?php

class __Mustache_2e608a7ad06794dd9d9910070f6eaba2 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $context->find('editing');
        $buffer .= $this->sectionF8de480ede6e16602c850fdc3558a112($context, $indent, $value);
        $value = $context->find('editing');
        if (empty($value)) {
            
            $value = $context->find('iscurrent');
            $buffer .= $this->section0882a33c11d64f1581aab8d33d57de64($context, $indent, $value);
        }
        $value = $context->find('visibility');
        $buffer .= $this->section9a5932ac56f2782ffd4c4ea1a5ef11cb($context, $indent, $value);

        return $buffer;
    }

    private function sectionF8de480ede6e16602c850fdc3558a112(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <span class="badge rounded-pill bg-primary text-white order-1 {{^iscurrent}}d-none{{/iscurrent}}" data-type="iscurrent">
        {{ highlightedlabel }}
    </span>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <span class="badge rounded-pill bg-primary text-white order-1 ';
                $value = $context->find('iscurrent');
                if (empty($value)) {
                    
                    $buffer .= 'd-none';
                }
                $buffer .= '" data-type="iscurrent">
';
                $buffer .= $indent . '        ';
                $value = $this->resolveValue($context->find('highlightedlabel'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '
';
                $buffer .= $indent . '    </span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0882a33c11d64f1581aab8d33d57de64(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <span class="badge rounded-pill bg-primary text-white order-1">{{ highlightedlabel }}</span>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <span class="badge rounded-pill bg-primary text-white order-1">';
                $value = $this->resolveValue($context->find('highlightedlabel'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9a5932ac56f2782ffd4c4ea1a5ef11cb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{>core_courseformat/local/content/section/visibility}}
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/section/visibility')) {
                    $buffer .= $partial->renderInternal($context, $indent . '    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
