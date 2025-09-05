<?php

class __Mustache_7a843550b73e03a06bad031c9d44d200 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="hidden border-bottom p-1 px-sm-2 view-search" ';
        $value = $context->find('isdrawer');
        if (empty($value)) {
            
            $buffer .= 'data-in-panel="true"';
        }
        $buffer .= ' aria-hidden="true" data-region="view-search">
';
        $buffer .= $indent . '    <div class="d-flex align-items-center">
';
        $buffer .= $indent . '        <a
';
        $buffer .= $indent . '            class="me-2 align-self-stretch d-flex align-items-center"
';
        $buffer .= $indent . '            href="#"
';
        $buffer .= $indent . '            data-route-back
';
        $buffer .= $indent . '            data-action="cancel-search"
';
        $buffer .= $indent . '            role="button"
';
        $buffer .= $indent . '        >
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_icon_back')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '        </a>
';
        $buffer .= $indent . '        <div class="input-group simplesearchform" role="group" aria-labelledby="messagesearchgrouplabel">
';
        $buffer .= $indent . '            <span class="sr-only" id="messagesearchgrouplabel">';
        $value = $context->find('str');
        $buffer .= $this->sectionAa6674432a9d42371d0813175abcf02b($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '            <input
';
        $buffer .= $indent . '                type="text"
';
        $buffer .= $indent . '                class="form-control"
';
        $buffer .= $indent . '                placeholder="';
        $value = $context->find('str');
        $buffer .= $this->section507b9f28a10a9aed70b7b7a308c6a3ca($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '                aria-label="';
        $value = $context->find('str');
        $buffer .= $this->section507b9f28a10a9aed70b7b7a308c6a3ca($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '                data-region="search-input"
';
        $buffer .= $indent . '            >
';
        $buffer .= $indent . '            <div class="input-group-append">
';
        $buffer .= $indent . '                <button
';
        $buffer .= $indent . '                    class="btn btn-submit icon-no-margin"
';
        $buffer .= $indent . '                    type="button"
';
        $buffer .= $indent . '                    data-action="search"
';
        $buffer .= $indent . '                    aria-label="';
        $value = $context->find('str');
        $buffer .= $this->sectionFd1acb2100a5f54e396a9cb56c807301($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '                    title="';
        $value = $context->find('str');
        $buffer .= $this->sectionFd1acb2100a5f54e396a9cb56c807301($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '                >
';
        $buffer .= $indent . '                    <span data-region="search-icon-container">
';
        $buffer .= $indent . '                        ';
        $value = $context->find('pix');
        $buffer .= $this->section31a49b2ab335cdb4725ddb42ed8de96c($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                    </span>
';
        $buffer .= $indent . '                    <span class="hidden" data-region="loading-icon-container">
';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context, $indent . '                        ');
        }
        $buffer .= $indent . '                    </span>
';
        $buffer .= $indent . '                </button>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function sectionAa6674432a9d42371d0813175abcf02b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'searchcombined, message';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'searchcombined, message';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section507b9f28a10a9aed70b7b7a308c6a3ca(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' search, core_search ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' search, core_search ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFd1acb2100a5f54e396a9cb56c807301(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' performsearch, core_search ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' performsearch, core_search ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section31a49b2ab335cdb4725ddb42ed8de96c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' a/search, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' a/search, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
