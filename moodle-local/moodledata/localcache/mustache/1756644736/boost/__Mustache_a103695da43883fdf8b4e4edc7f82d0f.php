<?php

class __Mustache_a103695da43883fdf8b4e4edc7f82d0f extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="mod-indent-outer" id="mod-indent-outer-slot-';
        $value = $this->resolveValue($context->find('slotid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '">
';
        $buffer .= $indent . '    ';
        $value = $this->resolveValue($context->find('checkbox'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '    ';
        $value = $this->resolveValue($context->find('questionnumber'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '    <div class="mod-indent"></div>
';
        $buffer .= $indent . '    <div class="activityinstance">
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('questionname'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <span class="actions">
';
        $value = $context->find('versionselection');
        $buffer .= $this->sectionF10efbea78eda8224f1f3235aa922115($context, $indent, $value);
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('questionicons'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '    </span>
';
        $value = $context->find('canbeedited');
        $buffer .= $this->section4b71f6da3e03ad0cc213f7a1f782f894($context, $indent, $value);
        $buffer .= $indent . '</div>
';
        $value = $context->find('draftversion');
        $buffer .= $this->section6235d797c64977351497cea82732f236($context, $indent, $value);

        return $buffer;
    }

    private function sectionFe09b357a29a3cc9b74bb8f59ccb8198(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'question_version, question';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'question_version, question';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC877874b20aed109ed5be9bdc0ef9c49(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'selected="selected"';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'selected="selected"';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section06dbc834d2b496a56070a017b145631d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    <option value="{{version}}" {{#selected}}selected="selected"{{/selected}}>{{versionvalue}}</option>
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                    <option value="';
                $value = $this->resolveValue($context->find('version'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" ';
                $value = $context->find('selected');
                $buffer .= $this->sectionC877874b20aed109ed5be9bdc0ef9c49($context, $indent, $value);
                $buffer .= '>';
                $value = $this->resolveValue($context->find('versionvalue'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</option>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF10efbea78eda8224f1f3235aa922115(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <label for="version-{{slotid}}" class="sr-only">{{#str}}question_version, question{{/str}}</label>
            <select id="version-{{slotid}}" name="version" class="form-control me-2 h-auto version-selection"
            data-action="mod_quiz-select_slot" data-slot-id="{{slotid}}">
                {{#versionoption}}
                    <option value="{{version}}" {{#selected}}selected="selected"{{/selected}}>{{versionvalue}}</option>
                {{/versionoption}}
            </select>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <label for="version-';
                $value = $this->resolveValue($context->find('slotid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="sr-only">';
                $value = $context->find('str');
                $buffer .= $this->sectionFe09b357a29a3cc9b74bb8f59ccb8198($context, $indent, $value);
                $buffer .= '</label>
';
                $buffer .= $indent . '            <select id="version-';
                $value = $this->resolveValue($context->find('slotid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" name="version" class="form-control me-2 h-auto version-selection"
';
                $buffer .= $indent . '            data-action="mod_quiz-select_slot" data-slot-id="';
                $value = $this->resolveValue($context->find('slotid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">
';
                $value = $context->find('versionoption');
                $buffer .= $this->section06dbc834d2b496a56070a017b145631d($context, $indent, $value);
                $buffer .= $indent . '            </select>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4b71f6da3e03ad0cc213f7a1f782f894(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{{questiondependencyicon}}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        ';
                $value = $this->resolveValue($context->find('questiondependencyicon'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFb6adbceb1eaf7151169d73586ed9835(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'questiondraftwillnotwork, mod_quiz';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'questiondraftwillnotwork, mod_quiz';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6235d797c64977351497cea82732f236(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
<div class="alert alert-danger" role="alert">{{#str}}questiondraftwillnotwork, mod_quiz{{/str}}</div>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '<div class="alert alert-danger" role="alert">';
                $value = $context->find('str');
                $buffer .= $this->sectionFb6adbceb1eaf7151169d73586ed9835($context, $indent, $value);
                $buffer .= '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
