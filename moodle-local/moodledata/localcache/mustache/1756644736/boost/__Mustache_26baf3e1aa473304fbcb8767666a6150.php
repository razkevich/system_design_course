<?php

class __Mustache_26baf3e1aa473304fbcb8767666a6150 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $context->find('showaddsection');
        $buffer .= $this->sectionBdc62449c8801b1133d9007151430c90($context, $indent, $value);

        return $buffer;
    }

    private function sectionD0146a3b4454c5bedc72ca5fe59e6e68(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' increasesections, moodle ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' increasesections, moodle ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section73299e9d0dd79cf4a0279246aa5b3dc9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 't/switch_plus, moodle, {{#str}} increasesections, moodle {{/str}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 't/switch_plus, moodle, ';
                $value = $context->find('str');
                $buffer .= $this->sectionD0146a3b4454c5bedc72ca5fe59e6e68($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9bc4955e97b3e03de23dae13ffa6f74c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <a href="{{{url}}}" class="increase-sections">
        {{#pix}}t/switch_plus, moodle, {{#str}} increasesections, moodle {{/str}}{{/pix}}
    </a>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <a href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '" class="increase-sections">
';
                $buffer .= $indent . '        ';
                $value = $context->find('pix');
                $buffer .= $this->section73299e9d0dd79cf4a0279246aa5b3dc9($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '    </a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section22686b7e0eacfe8762121dcc2f0e21db(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' reducesections, moodle ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' reducesections, moodle ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8dc0fa6941aa91b751a414ccbee7293e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 't/switch_minus, moodle, {{#str}} reducesections, moodle {{/str}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 't/switch_minus, moodle, ';
                $value = $context->find('str');
                $buffer .= $this->section22686b7e0eacfe8762121dcc2f0e21db($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE5a549f24b624d4beba7d1296af460e2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <a href="{{{url}}}" class="reduce-sections">
        {{#pix}}t/switch_minus, moodle, {{#str}} reducesections, moodle {{/str}}{{/pix}}
    </a>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <a href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '" class="reduce-sections">
';
                $buffer .= $indent . '        ';
                $value = $context->find('pix');
                $buffer .= $this->section8dc0fa6941aa91b751a414ccbee7293e($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '    </a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section95103e0b0ba93f642b5a789ad318f6ca(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' data-id="{{id}}" ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' data-id="';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9b089e00077ec061918a3e4dd2d05479(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' t/add, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' t/add, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB7490828c3c7b8a9a617bb9639c54b7a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 't/block, moodle';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 't/block, moodle';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCb51ddf0e37023e42a53528d46d6cfc3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'maxsectionaddmessage, core_courseformat';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'maxsectionaddmessage, core_courseformat';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAe11c1fb62945d2ccf78a7517a6d8008(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <a href="{{{url}}}"
           class="w-100 btn add-section justify-content-center align-items-center p-3"
           data-add-sections="{{title}}"
           data-new-sections="{{newsection}}"
           data-action="addSection"
            {{#insertafter}} data-id="{{id}}" {{/insertafter}}
        >
            {{#pix}} t/add, core {{/pix}}
            {{title}}
        </a>
        <div class="d-none p-3 max-section-alert" data-region="max-sections-warning">
            <div class="w-100 text-center">
                {{#pix}}t/block, moodle{{/pix}}
            </div>
            <div class="w-100 font-italic text-center">
                {{#str}}maxsectionaddmessage, core_courseformat{{/str}}
            </div>
        </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <a href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '"
';
                $buffer .= $indent . '           class="w-100 btn add-section justify-content-center align-items-center p-3"
';
                $buffer .= $indent . '           data-add-sections="';
                $value = $this->resolveValue($context->find('title'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '"
';
                $buffer .= $indent . '           data-new-sections="';
                $value = $this->resolveValue($context->find('newsection'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '"
';
                $buffer .= $indent . '           data-action="addSection"
';
                $buffer .= $indent . '            ';
                $value = $context->find('insertafter');
                $buffer .= $this->section95103e0b0ba93f642b5a789ad318f6ca($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '        >
';
                $buffer .= $indent . '            ';
                $value = $context->find('pix');
                $buffer .= $this->section9b089e00077ec061918a3e4dd2d05479($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '            ';
                $value = $this->resolveValue($context->find('title'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '
';
                $buffer .= $indent . '        </a>
';
                $buffer .= $indent . '        <div class="d-none p-3 max-section-alert" data-region="max-sections-warning">
';
                $buffer .= $indent . '            <div class="w-100 text-center">
';
                $buffer .= $indent . '                ';
                $value = $context->find('pix');
                $buffer .= $this->sectionB7490828c3c7b8a9a617bb9639c54b7a($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '            </div>
';
                $buffer .= $indent . '            <div class="w-100 font-italic text-center">
';
                $buffer .= $indent . '                ';
                $value = $context->find('str');
                $buffer .= $this->sectionCb51ddf0e37023e42a53528d46d6cfc3($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '            </div>
';
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBdc62449c8801b1133d9007151430c90(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
<div id="course-addsection" class="changenumsections bulk-hidden mt-5">
    {{#increase}}
    <a href="{{{url}}}" class="increase-sections">
        {{#pix}}t/switch_plus, moodle, {{#str}} increasesections, moodle {{/str}}{{/pix}}
    </a>
    {{/increase}}
    {{#decrease}}
    <a href="{{{url}}}" class="reduce-sections">
        {{#pix}}t/switch_minus, moodle, {{#str}} reducesections, moodle {{/str}}{{/pix}}
    </a>
    {{/decrease}}
    {{#addsections}}
        <a href="{{{url}}}"
           class="w-100 btn add-section justify-content-center align-items-center p-3"
           data-add-sections="{{title}}"
           data-new-sections="{{newsection}}"
           data-action="addSection"
            {{#insertafter}} data-id="{{id}}" {{/insertafter}}
        >
            {{#pix}} t/add, core {{/pix}}
            {{title}}
        </a>
        <div class="d-none p-3 max-section-alert" data-region="max-sections-warning">
            <div class="w-100 text-center">
                {{#pix}}t/block, moodle{{/pix}}
            </div>
            <div class="w-100 font-italic text-center">
                {{#str}}maxsectionaddmessage, core_courseformat{{/str}}
            </div>
        </div>
    {{/addsections}}
</div>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '<div id="course-addsection" class="changenumsections bulk-hidden mt-5">
';
                $value = $context->find('increase');
                $buffer .= $this->section9bc4955e97b3e03de23dae13ffa6f74c($context, $indent, $value);
                $value = $context->find('decrease');
                $buffer .= $this->sectionE5a549f24b624d4beba7d1296af460e2($context, $indent, $value);
                $value = $context->find('addsections');
                $buffer .= $this->sectionAe11c1fb62945d2ccf78a7517a6d8008($context, $indent, $value);
                $buffer .= $indent . '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
