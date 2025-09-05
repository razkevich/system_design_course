<?php

class __Mustache_f7f2c1a52621ec70d63a418a535c6b00 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<div id="block-myoverview-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" class="block-myoverview block-cards" data-region="myoverview" role="navigation">
';
        $buffer .= $indent . '    <div role="search" data-region="filter" class="d-flex align-items-center my-2" aria-label="';
        $value = $context->find('str');
        $buffer .= $this->section6dacaeff51ba425cb4a640a8ca853997($context, $indent, $value);
        $buffer .= '">
';
        $buffer .= $indent . '        <div class="row g-0">
';
        if ($partial = $this->mustache->loadPartial('block_myoverview/nav-grouping-selector')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '
';
        if ($partial = $this->mustache->loadPartial('block_myoverview/nav-search-widget')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '
';
        if ($partial = $this->mustache->loadPartial('block_myoverview/nav-sort-selector')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '
';
        $value = $context->find('displaydropdown');
        $buffer .= $this->section3d379ac8783236b6793f916ff2e85081($context, $indent, $value);
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <div class="container-fluid p-0">
';
        if ($partial = $this->mustache->loadPartial('block_myoverview/courses-view')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';
        $value = $context->find('js');
        $buffer .= $this->section386b7d71bdc9db8625cd5cfe5736c587($context, $indent, $value);

        return $buffer;
    }

    private function section6dacaeff51ba425cb4a640a8ca853997(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' aria:controls, block_myoverview ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' aria:controls, block_myoverview ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3d379ac8783236b6793f916ff2e85081(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                {{> block_myoverview/nav-display-selector }}
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('block_myoverview/nav-display-selector')) {
                    $buffer .= $partial->renderInternal($context, $indent . '                ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section386b7d71bdc9db8625cd5cfe5736c587(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require(
[
    \'jquery\',
    \'block_myoverview/main\',
],
function(
    $,
    Main
) {
    var root = $(\'#block-myoverview-{{uniqid}}\');
    Main.init(root);
});
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . 'require(
';
                $buffer .= $indent . '[
';
                $buffer .= $indent . '    \'jquery\',
';
                $buffer .= $indent . '    \'block_myoverview/main\',
';
                $buffer .= $indent . '],
';
                $buffer .= $indent . 'function(
';
                $buffer .= $indent . '    $,
';
                $buffer .= $indent . '    Main
';
                $buffer .= $indent . ') {
';
                $buffer .= $indent . '    var root = $(\'#block-myoverview-';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '\');
';
                $buffer .= $indent . '    Main.init(root);
';
                $buffer .= $indent . '});
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
