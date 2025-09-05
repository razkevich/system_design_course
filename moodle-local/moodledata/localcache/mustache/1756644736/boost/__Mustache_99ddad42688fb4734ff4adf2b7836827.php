<?php

class __Mustache_99ddad42688fb4734ff4adf2b7836827 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="fp-login-form">
';
        $buffer .= $indent . '    <div class="fp-content-center">
';
        $buffer .= $indent . '        <form class="form">
';
        $buffer .= $indent . '            <div class="fp-formset">
';
        $buffer .= $indent . '                <div class="fp-login-popup mb-3">
';
        $buffer .= $indent . '                    <div class="fp-popup">
';
        $buffer .= $indent . '                        <p class="mdl-align">
';
        $buffer .= $indent . '                            <button class="fp-login-popup-but btn-primary btn">';
        $value = $context->find('str');
        $buffer .= $this->section158a68299938d1165f3c2046ed2b5240($context, $indent, $value);
        $buffer .= '</button>
';
        $buffer .= $indent . '                        </p>
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="fp-login-textarea mb-3">
';
        $buffer .= $indent . '                    <textarea class="form-control"></textarea>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="fp-login-select mb-3">
';
        $buffer .= $indent . '                    <label class="form-control-label"></label>
';
        $buffer .= $indent . '                    <select class="custom-select"></select>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="fp-login-input mb-3">
';
        $buffer .= $indent . '                    <label class="form-control-label"></label>
';
        $buffer .= $indent . '                    <input class="form-control"/>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="fp-login-radiogroup mb-3">
';
        $buffer .= $indent . '                    <label class="form-control-label"></label>
';
        $buffer .= $indent . '                    <div class="fp-login-radio"><input class="form-control" /> <label></label></div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="fp-login-checkbox mb-3 d-flex flex-wrap align-items-center">
';
        $buffer .= $indent . '                    <label class="form-control-label"></label>
';
        $buffer .= $indent . '                    <input class="form-control"/>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '            <p class="mdl-align"><button class="fp-login-submit btn-primary btn">';
        $value = $context->find('str');
        $buffer .= $this->section834c00e4edc4b3f962d6edbae0f28e61($context, $indent, $value);
        $buffer .= '</button></p>
';
        $buffer .= $indent . '        </form>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section158a68299938d1165f3c2046ed2b5240(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'login, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'login, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section834c00e4edc4b3f962d6edbae0f28e61(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'submit, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'submit, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
