<?php

class __Mustache_87c70d9c32d42ac05c586f90105c3801 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<div
';
        $buffer .= $indent . '    class="section border-0 card rounded-0"
';
        $buffer .= $indent . '    data-region="';
        $blockFunction = $context->findInBlock('region');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '"
';
        $buffer .= $indent . '>
';
        $buffer .= $indent . '    <div id="';
        $blockFunction = $context->findInBlock('region');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '-toggle" class="card-header rounded-0" data-region="toggle">
';
        $buffer .= $indent . '        <button
';
        $buffer .= $indent . '            class="btn btn-link w-100 text-start p-1 p-sm-2 d-flex rounded-0 align-items-center overview-section-toggle ';
        $value = $context->find('expanded');
        if (empty($value)) {
            
            $buffer .= 'collapsed';
        }
        $buffer .= '"
';
        $buffer .= $indent . '            data-toggle="collapse"
';
        $buffer .= $indent . '            data-target="#';
        $blockFunction = $context->findInBlock('region');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '-target-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '            aria-expanded="';
        $value = $context->find('expanded');
        $buffer .= $this->section03a2cb78adf693fb240638cbbc7ea15e($context, $indent, $value);
        $value = $context->find('expanded');
        if (empty($value)) {
            
            $buffer .= 'false';
        }
        $buffer .= '"
';
        $buffer .= $indent . '            aria-controls="';
        $blockFunction = $context->findInBlock('region');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '-target-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '        >
';
        $buffer .= $indent . '            <span class="collapsed-icon-container">
';
        $buffer .= $indent . '                <span class="dir-rtl-hide">';
        $value = $context->find('pix');
        $buffer .= $this->sectionFb21be3147b00254c7256c9c85519aaf($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '                <span class="dir-ltr-hide">';
        $value = $context->find('pix');
        $buffer .= $this->sectionD8b2b5e9cb2ad16c466ba9dd3cf4a9ca($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '            </span>
';
        $buffer .= $indent . '            <span class="expanded-icon-container">
';
        $buffer .= $indent . '                ';
        $value = $context->find('pix');
        $buffer .= $this->section67c59c18302e3b6896a1ce2ba2852316($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '            </span>
';
        $buffer .= $indent . '            <span class="font-weight-bold ms-1">';
        $blockFunction = $context->findInBlock('title');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '</span>
';
        $buffer .= $indent . '            <small
';
        $buffer .= $indent . '                class="hidden ms-1"
';
        $buffer .= $indent . '                data-region="section-total-count-container" aria-labelledby="';
        $blockFunction = $context->findInBlock('region');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '-total-count-label"
';
        $buffer .= $indent . '            >
';
        $buffer .= $indent . '                (<span aria-hidden="true" data-region="section-total-count">';
        $value = $this->resolveValue($context->findDot('count.total'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '</span>)
';
        $buffer .= $indent . '                <span class="sr-only" id="';
        $blockFunction = $context->findInBlock('region');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '-total-count-label">
';
        $buffer .= $indent . '                    ';
        $value = $context->find('str');
        $buffer .= $this->section157ed066b52ac7131926b0c2638ed003($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                </span>
';
        $buffer .= $indent . '            </small>
';
        $buffer .= $indent . '            <span class="hidden ms-2" data-region="loading-icon-container">
';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context, $indent . '                ');
        }
        $buffer .= $indent . '            </span>
';
        $buffer .= $indent . '            <span
';
        $buffer .= $indent . '                class="';
        $value = $context->findDot('count.unread');
        if (empty($value)) {
            
            $buffer .= 'hidden';
        }
        $buffer .= ' badge rounded-pill bg-primary text-white ms-auto"
';
        $buffer .= $indent . '                data-region="section-unread-count-container" aria-labelledby="';
        $blockFunction = $context->findInBlock('region');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '-unread-count-label"
';
        $buffer .= $indent . '            >
';
        $buffer .= $indent . '                <span aria-hidden="true" data-region="section-unread-count">';
        $value = $this->resolveValue($context->findDot('count.unread'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '</span>
';
        $buffer .= $indent . '                <span class="sr-only" id="';
        $blockFunction = $context->findInBlock('region');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '-unread-count-label">
';
        $buffer .= $indent . '                    ';
        $value = $context->find('str');
        $buffer .= $this->section2583a6656b06f3645e457db265540388($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                </span>
';
        $buffer .= $indent . '            </span>
';
        $buffer .= $indent . '        </button>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    ';
        if ($parent = $this->mustache->loadPartial('core_message/message_drawer_lazy_load_list')) {
            $context->pushBlockContext(array(
                'rootclasses' => array($this, 'blockDdc0cfe2ccf734ee20370637cfbb62ea'),
                'rootattributes' => array($this, 'blockEd8489bdab608dc6b3e228b81947cd0e'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section03a2cb78adf693fb240638cbbc7ea15e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'true';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'true';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFb21be3147b00254c7256c9c85519aaf(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' t/collapsed, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' t/collapsed, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD8b2b5e9cb2ad16c466ba9dd3cf4a9ca(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' t/collapsed_rtl, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' t/collapsed_rtl, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section67c59c18302e3b6896a1ce2ba2852316(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' t/expanded, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' t/expanded, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section157ed066b52ac7131926b0c2638ed003(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' totalconversations, core_message, {{count.total}} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' totalconversations, core_message, ';
                $value = $this->resolveValue($context->findDot('count.total'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2583a6656b06f3645e457db265540388(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' unreadconversations, core_message, {{count.unread}} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' unreadconversations, core_message, ';
                $value = $this->resolveValue($context->findDot('count.unread'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section14c724f5a6859d4cc56d9befdffaeac5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'show';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'show';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function blockDdc0cfe2ccf734ee20370637cfbb62ea($context)
    {
        $indent = $buffer = '';
        $buffer .= 'collapse border-bottom ';
        $value = $context->find('expanded');
        $buffer .= $this->section14c724f5a6859d4cc56d9befdffaeac5($context, $indent, $value);
    
        return $buffer;
    }

    public function blockEd8489bdab608dc6b3e228b81947cd0e($context)
    {
        $indent = $buffer = '';
        $buffer .= '            id="';
        $blockFunction = $context->findInBlock('region');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '-target-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '            aria-labelledby="';
        $blockFunction = $context->findInBlock('region');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '-toggle"
';
        $buffer .= $indent . '            data-parent="#message-drawer-view-overview-container-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
    
        return $buffer;
    }
}
