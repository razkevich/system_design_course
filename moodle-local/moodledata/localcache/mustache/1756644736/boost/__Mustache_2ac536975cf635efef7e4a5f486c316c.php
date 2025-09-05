<?php

class __Mustache_2ac536975cf635efef7e4a5f486c316c extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div
';
        $buffer .= $indent . '    class="d-flex flex-row align-items-start p-2 mb-1 ';
        $buffer .= ' position-relative rounded dropdown-item-outline ';
        $buffer .= ' ';
        $value = $context->find('disabled');
        $buffer .= $this->section2446e1efa274c39c0eab1ef564e1f8ed($context, $indent, $value);
        $buffer .= ' ';
        $buffer .= ' ';
        $value = $context->find('selected');
        $buffer .= $this->section92fff7894386bb3dd9b9daa90da6b9b1($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '    data-optionnumber="';
        $value = $this->resolveValue($context->find('optionnumber'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '    data-selected="';
        $value = $this->resolveValue($context->find('selected'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '    data-selected-classes = "border bg-primary-light selected"
';
        $buffer .= $indent . '>
';
        $buffer .= $indent . '    <div class="option-select-indicator">
';
        $buffer .= $indent . '        <span class="';
        $value = $context->find('selected');
        if (empty($value)) {
            
            $buffer .= ' d-none ';
        }
        $buffer .= '" data-for="checkedIcon">
';
        $buffer .= $indent . '            ';
        $value = $context->find('pix');
        $buffer .= $this->section76d0d604f9a1462f55a319589ac38592($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        </span>
';
        $buffer .= $indent . '        <span class="';
        $value = $context->find('selected');
        $buffer .= $this->section4fc26969ddd918e0a280a1daa10d7757($context, $indent, $value);
        $buffer .= '" data-for="uncheckedIcon">
';
        $buffer .= $indent . '            ';
        $value = $context->find('pix');
        $buffer .= $this->section81f0fba5d686f839b1029898e81ce623($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        </span>
';
        $buffer .= $indent . '    </div>
';
        $value = $context->find('icon');
        $buffer .= $this->sectionE885eb6ce3e21191416a5482407c21cb($context, $indent, $value);
        $buffer .= $indent . '    <div class="option-name">
';
        $buffer .= $indent . '        <a
';
        $buffer .= $indent . '            class="stretched-link text-wrap font-weight-bold ';
        $buffer .= ' ';
        $value = $context->find('disabled');
        if (empty($value)) {
            
            $buffer .= ' text-dark ';
        }
        $buffer .= ' ';
        $buffer .= ' ';
        $value = $context->find('disabled');
        $buffer .= $this->sectionBf56c8e328a01fcaf9e7fe3d575753a9($context, $indent, $value);
        $buffer .= ' ';
        $buffer .= ' ';
        $value = $context->find('selected');
        $buffer .= $this->sectionB62c8366e1664f42966bcc54fdec5e27($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '            role="option"
';
        $buffer .= $indent . '            ';
        $value = $context->find('selected');
        $buffer .= $this->section07962b8c5a8473a409ee2c974728d031($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '            ';
        $value = $context->find('description');
        $buffer .= $this->sectionC05402e6e738af3b37fff07754130b33($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '            data-value="';
        $value = $this->resolveValue($context->find('value'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '            ';
        $value = $context->find('hasurl');
        $buffer .= $this->section77d4c4f49298096d6518171b61466bdc($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '            ';
        $value = $context->find('hasurl');
        if (empty($value)) {
            
            $buffer .= ' href="#" ';
        }
        $buffer .= '
';
        $buffer .= $indent . '            ';
        $value = $context->find('disabled');
        $buffer .= $this->section205b588c373e862656fd60dd3ee9191d($context, $indent, $value);
        $buffer .= '
';
        $value = $context->find('extras');
        $buffer .= $this->sectionD39a984bc52c70a02b7e0caba0f666d9($context, $indent, $value);
        $buffer .= $indent . '        >
';
        $buffer .= $indent . '            ';
        $value = $this->resolveValue($context->find('name'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '
';
        $buffer .= $indent . '        </a>
';
        $value = $context->find('description');
        $buffer .= $this->section5b6140308ec0792ae68ef27ad8eff131($context, $indent, $value);
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section2446e1efa274c39c0eab1ef564e1f8ed(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' dimmed_text ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' dimmed_text ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section92fff7894386bb3dd9b9daa90da6b9b1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' border bg-primary-light selected ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' border bg-primary-light selected ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5f59d5dc38f555f4e7a313f57c501d32(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' selected, form ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' selected, form ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section76d0d604f9a1462f55a319589ac38592(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' i/checkedcircle, core, {{#str}} selected, form {{/str}} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' i/checkedcircle, core, ';
                $value = $context->find('str');
                $buffer .= $this->section5f59d5dc38f555f4e7a313f57c501d32($context, $indent, $value);
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4fc26969ddd918e0a280a1daa10d7757(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' d-none ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' d-none ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section81f0fba5d686f839b1029898e81ce623(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' i/uncheckedcircle';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' i/uncheckedcircle';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF8bc88bd0061bedf9c626efe42e91428(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{key}}, {{component}}, {{title}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->find('key'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ', ';
                $value = $this->resolveValue($context->find('component'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ', ';
                $value = $this->resolveValue($context->find('title'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE885eb6ce3e21191416a5482407c21cb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="option-icon">
        {{#pix}}{{key}}, {{component}}, {{title}}{{/pix}}
    </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div class="option-icon">
';
                $buffer .= $indent . '        ';
                $value = $context->find('pix');
                $buffer .= $this->sectionF8bc88bd0061bedf9c626efe42e91428($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBf56c8e328a01fcaf9e7fe3d575753a9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' disabled ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' disabled ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB62c8366e1664f42966bcc54fdec5e27(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' selected ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' selected ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section07962b8c5a8473a409ee2c974728d031(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' aria-selected="true" ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' aria-selected="true" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC05402e6e738af3b37fff07754130b33(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' aria-describedby="{{optionuniqid}}" ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' aria-describedby="';
                $value = $this->resolveValue($context->find('optionuniqid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section77d4c4f49298096d6518171b61466bdc(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' href="{{{url}}}" ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section205b588c373e862656fd60dd3ee9191d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' tabindex="-1" ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' tabindex="-1" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD39a984bc52c70a02b7e0caba0f666d9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                {{attribute}}="{{value}}"
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                ';
                $value = $this->resolveValue($context->find('attribute'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '="';
                $value = $this->resolveValue($context->find('value'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '"
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5b6140308ec0792ae68ef27ad8eff131(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div
            id="{{optionuniqid}}"
            class="option-description small text-muted text-wrap">
            {{{description}}}
        </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div
';
                $buffer .= $indent . '            id="';
                $value = $this->resolveValue($context->find('optionuniqid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '"
';
                $buffer .= $indent . '            class="option-description small text-muted text-wrap">
';
                $buffer .= $indent . '            ';
                $value = $this->resolveValue($context->find('description'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
