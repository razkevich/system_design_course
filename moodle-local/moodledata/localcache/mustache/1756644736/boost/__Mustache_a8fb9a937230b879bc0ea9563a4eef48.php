<?php

class __Mustache_a8fb9a937230b879bc0ea9563a4eef48 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="btn-group';
        $value = $context->find('manageurl');
        $buffer .= $this->section9fc76b4246a8311627091dab64d371ce($context, $indent, $value);
        $value = $context->find('courserequesturl');
        $buffer .= $this->sectionBd3acaef41e592bc6526d1fefc16177d($context, $indent, $value);
        $buffer .= '">
';
        $buffer .= $indent . '    <div class="my-action-buttons my-action-buttons-right">
';
        $value = $context->find('manageurl');
        $buffer .= $this->section491d3acf7c349df2946c4343d3a45b04($context, $indent, $value);
        $value = $context->find('newcourseurl');
        $buffer .= $this->section3322222fcd5c089102f1266087becd3d($context, $indent, $value);
        $value = $context->find('courserequesturl');
        $buffer .= $this->section0df934532684827763b862602e796d7a($context, $indent, $value);
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section9fc76b4246a8311627091dab64d371ce(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' course-manage';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' course-manage';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBd3acaef41e592bc6526d1fefc16177d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' course-request';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' course-request';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2cf7e0a94d6545a186ac3b96dad3f56f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' managecourses ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' managecourses ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section491d3acf7c349df2946c4343d3a45b04(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <form action="{{manageurl}}" method="post" id="managecoursesform">
                <button type="submit" class="btn btn-outline-primary m-1 w-100">{{#str}} managecourses {{/str}}</button>
            </form>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <form action="';
                $value = $this->resolveValue($context->find('manageurl'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" method="post" id="managecoursesform">
';
                $buffer .= $indent . '                <button type="submit" class="btn btn-outline-primary m-1 w-100">';
                $value = $context->find('str');
                $buffer .= $this->section2cf7e0a94d6545a186ac3b96dad3f56f($context, $indent, $value);
                $buffer .= '</button>
';
                $buffer .= $indent . '            </form>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section54edf46f6d0f5654fbdba98f93e7746d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' createcourse, block_myoverview ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' createcourse, block_myoverview ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3322222fcd5c089102f1266087becd3d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <form action="{{newcourseurl}}" method="post" id="newcourseform">
                <button type="submit" class="btn btn-primary m-1 w-100">{{#str}} createcourse, block_myoverview {{/str}}</button>
            </form>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <form action="';
                $value = $this->resolveValue($context->find('newcourseurl'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" method="post" id="newcourseform">
';
                $buffer .= $indent . '                <button type="submit" class="btn btn-primary m-1 w-100">';
                $value = $context->find('str');
                $buffer .= $this->section54edf46f6d0f5654fbdba98f93e7746d($context, $indent, $value);
                $buffer .= '</button>
';
                $buffer .= $indent . '            </form>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9ad2dd44d6e750dd1b7d24f857c63395(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' requestcourse ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' requestcourse ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0df934532684827763b862602e796d7a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <form action="{{courserequesturl}}" method="post" id="courserequestform">
                <button type="submit" class="btn btn-primary m-1 w-100">{{#str}} requestcourse {{/str}}</button>
            </form>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <form action="';
                $value = $this->resolveValue($context->find('courserequesturl'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" method="post" id="courserequestform">
';
                $buffer .= $indent . '                <button type="submit" class="btn btn-primary m-1 w-100">';
                $value = $context->find('str');
                $buffer .= $this->section9ad2dd44d6e750dd1b7d24f857c63395($context, $indent, $value);
                $buffer .= '</button>
';
                $buffer .= $indent . '            </form>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
