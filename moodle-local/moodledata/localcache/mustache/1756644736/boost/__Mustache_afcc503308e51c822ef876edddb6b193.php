<?php

class __Mustache_afcc503308e51c822ef876edddb6b193 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div data-region="loading-placeholder-content" aria-hidden="true">
';
        $value = $context->find('card');
        $buffer .= $this->sectionDce17ee91a069a434503be4b0fa5f859($context, $indent, $value);
        $value = $context->find('list');
        $buffer .= $this->sectionC17006aea523256ae596d7d23e916da4($context, $indent, $value);
        $value = $context->find('summary');
        $buffer .= $this->sectionC17006aea523256ae596d7d23e916da4($context, $indent, $value);
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function sectionDce17ee91a069a434503be4b0fa5f859(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="card-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 mx-0 flex-nowrap overflow-hidden" style="height: 13rem">
            <div class="col d-flex px-1">{{> core_course/placeholder-course }}</div>
            <div class="col d-flex px-1">{{> core_course/placeholder-course }}</div>
            <div class="col d-flex px-1">{{> core_course/placeholder-course }}</div>
        </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="card-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 mx-0 flex-nowrap overflow-hidden" style="height: 13rem">
';
                $buffer .= $indent . '            <div class="col d-flex px-1">';
                if ($partial = $this->mustache->loadPartial('core_course/placeholder-course')) {
                    $buffer .= $partial->renderInternal($context);
                }
                $buffer .= '</div>
';
                $buffer .= $indent . '            <div class="col d-flex px-1">';
                if ($partial = $this->mustache->loadPartial('core_course/placeholder-course')) {
                    $buffer .= $partial->renderInternal($context);
                }
                $buffer .= '</div>
';
                $buffer .= $indent . '            <div class="col d-flex px-1">';
                if ($partial = $this->mustache->loadPartial('core_course/placeholder-course')) {
                    $buffer .= $partial->renderInternal($context);
                }
                $buffer .= '</div>
';
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC17006aea523256ae596d7d23e916da4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <ul class="list-group">
            {{> block_myoverview/placeholder-course-list-item }}
            {{> block_myoverview/placeholder-course-list-item }}
            {{> block_myoverview/placeholder-course-list-item }}
            {{> block_myoverview/placeholder-course-list-item }}
        </ul>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <ul class="list-group">
';
                if ($partial = $this->mustache->loadPartial('block_myoverview/placeholder-course-list-item')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                if ($partial = $this->mustache->loadPartial('block_myoverview/placeholder-course-list-item')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                if ($partial = $this->mustache->loadPartial('block_myoverview/placeholder-course-list-item')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                if ($partial = $this->mustache->loadPartial('block_myoverview/placeholder-course-list-item')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                $buffer .= $indent . '        </ul>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
