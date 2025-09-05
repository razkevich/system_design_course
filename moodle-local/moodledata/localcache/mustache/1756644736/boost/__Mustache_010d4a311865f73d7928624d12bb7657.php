<?php

class __Mustache_010d4a311865f73d7928624d12bb7657 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        if ($partial = $this->mustache->loadPartial('core/chooser')) {
            $buffer .= $partial->renderInternal($context);
        }
        $value = $context->find('js');
        $buffer .= $this->section1af3716a6110357aebebc682a9302996($context, $indent, $value);

        return $buffer;
    }

    private function section1af3716a6110357aebebc682a9302996(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require([
    \'core/yui\'
], function(Y) {
    Y.use(\'moodle-mod_quiz-questionchooser\', function() {
        M.mod_quiz.init_questionchooser();
    });
});
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . 'require([
';
                $buffer .= $indent . '    \'core/yui\'
';
                $buffer .= $indent . '], function(Y) {
';
                $buffer .= $indent . '    Y.use(\'moodle-mod_quiz-questionchooser\', function() {
';
                $buffer .= $indent . '        M.mod_quiz.init_questionchooser();
';
                $buffer .= $indent . '    });
';
                $buffer .= $indent . '});
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
