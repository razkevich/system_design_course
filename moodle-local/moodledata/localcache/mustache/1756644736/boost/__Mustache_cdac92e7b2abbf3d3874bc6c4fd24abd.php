<?php

class __Mustache_cdac92e7b2abbf3d3874bc6c4fd24abd extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        if ($parent = $this->mustache->loadPartial('theme_boost/drawer')) {
            $context->pushBlockContext(array(
                'id' => array($this, 'block713428f2c53de9aebab859391bdd84ed'),
                'drawerclasses' => array($this, 'blockD38028d67780ee6f785cf8e213f0a779'),
                'drawercloseonresize' => array($this, 'blockE052079a625ca42b568ba24af19cc7eb'),
                'drawerheading' => array($this, 'block02c7f35cc8f4fd4935515ac2700f58cc'),
                'drawercontent' => array($this, 'block465e4770df58e853c3956e6accd104e0'),
                'drawerstate' => array($this, 'blockA1dd4f2e68d7796ac435ab08723145ef'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }

        return $buffer;
    }

    private function sectionA64f0cb7e6e9ce5ffa12476ca05765a9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <img src="{{output.get_compact_logo_url}}" class="logo py-1 h-100" alt="{{sitename}}">
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                <img src="';
                $value = $this->resolveValue($context->findDot('output.get_compact_logo_url'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="logo py-1 h-100" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">
';
                $context->pop();
            }
        }
    
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

    private function section0ac795c23146489fad8f951c23f9a92a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' collapse, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' collapse, core ';
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

    private function section8b5765485c94c190bf567731edb08c3a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' expand, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' expand, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6d8e07b14a3c24382f60f6f77ecdf79c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'show ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'show ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5749c750acb0d7477dd5257d00cc6d53(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'active';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'active';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2835496f3585455c7830b624ece53c8c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                        {{^divider}}
                             <a href="{{{url}}}" class="ps-5 {{^isactive}}bg-light{{/isactive}}{{#isactive}}active{{/isactive}} list-group-item list-group-item-action">{{{text}}}</a>
                        {{/divider}}
                    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('divider');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                             <a href="';
                    $value = $this->resolveValue($context->find('url'), $context);
                    $buffer .= ($value === null ? '' : $value);
                    $buffer .= '" class="ps-5 ';
                    $value = $context->find('isactive');
                    if (empty($value)) {
                        
                        $buffer .= 'bg-light';
                    }
                    $value = $context->find('isactive');
                    $buffer .= $this->section5749c750acb0d7477dd5257d00cc6d53($context, $indent, $value);
                    $buffer .= ' list-group-item list-group-item-action">';
                    $value = $this->resolveValue($context->find('text'), $context);
                    $buffer .= ($value === null ? '' : $value);
                    $buffer .= '</a>
';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section50ac6cfc943625453568448825edf435(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <a id="drop-down-{{sort}}" href="#" class="list-group-item list-group-item-action icons-collapse-expand {{^isopen}}collapsed {{/isopen}}d-flex" data-toggle="collapse" data-target="#drop-down-menu-{{sort}}" aria-expanded="{{#isopen}}true{{/isopen}}{{^isopen}}false{{/isopen}}" aria-controls="drop-down-menu-{{sort}}">
                    {{{text}}}
                    <span class="ms-auto expanded-icon icon-no-margin mx-2">
                        {{#pix}} t/expanded, core {{/pix}}
                        <span class="sr-only">
                            {{#str}} collapse, core {{/str}}
                        </span>
                    </span>
                    <span class="ms-auto collapsed-icon icon-no-margin mx-2">
                        {{#pix}} t/collapsed, core {{/pix}}
                        <span class="sr-only">
                            {{#str}} expand, core {{/str}}
                        </span>
                    </span>
                </a>
                <div class="collapse {{#isopen}}show {{/isopen}}list-group-item p-0 border-0" role="menu" id="drop-down-menu-{{sort}}" aria-labelledby="drop-down-{{sort}}">
                    {{#children}}
                        {{^divider}}
                             <a href="{{{url}}}" class="ps-5 {{^isactive}}bg-light{{/isactive}}{{#isactive}}active{{/isactive}} list-group-item list-group-item-action">{{{text}}}</a>
                        {{/divider}}
                    {{/children}}
                </div>
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                <a id="drop-down-';
                $value = $this->resolveValue($context->find('sort'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" href="#" class="list-group-item list-group-item-action icons-collapse-expand ';
                $value = $context->find('isopen');
                if (empty($value)) {
                    
                    $buffer .= 'collapsed ';
                }
                $buffer .= 'd-flex" data-toggle="collapse" data-target="#drop-down-menu-';
                $value = $this->resolveValue($context->find('sort'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" aria-expanded="';
                $value = $context->find('isopen');
                $buffer .= $this->section03a2cb78adf693fb240638cbbc7ea15e($context, $indent, $value);
                $value = $context->find('isopen');
                if (empty($value)) {
                    
                    $buffer .= 'false';
                }
                $buffer .= '" aria-controls="drop-down-menu-';
                $value = $this->resolveValue($context->find('sort'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">
';
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('text'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '                    <span class="ms-auto expanded-icon icon-no-margin mx-2">
';
                $buffer .= $indent . '                        ';
                $value = $context->find('pix');
                $buffer .= $this->section67c59c18302e3b6896a1ce2ba2852316($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                        <span class="sr-only">
';
                $buffer .= $indent . '                            ';
                $value = $context->find('str');
                $buffer .= $this->section0ac795c23146489fad8f951c23f9a92a($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                        </span>
';
                $buffer .= $indent . '                    </span>
';
                $buffer .= $indent . '                    <span class="ms-auto collapsed-icon icon-no-margin mx-2">
';
                $buffer .= $indent . '                        ';
                $value = $context->find('pix');
                $buffer .= $this->sectionFb21be3147b00254c7256c9c85519aaf($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                        <span class="sr-only">
';
                $buffer .= $indent . '                            ';
                $value = $context->find('str');
                $buffer .= $this->section8b5765485c94c190bf567731edb08c3a($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                        </span>
';
                $buffer .= $indent . '                    </span>
';
                $buffer .= $indent . '                </a>
';
                $buffer .= $indent . '                <div class="collapse ';
                $value = $context->find('isopen');
                $buffer .= $this->section6d8e07b14a3c24382f60f6f77ecdf79c($context, $indent, $value);
                $buffer .= 'list-group-item p-0 border-0" role="menu" id="drop-down-menu-';
                $value = $this->resolveValue($context->find('sort'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" aria-labelledby="drop-down-';
                $value = $this->resolveValue($context->find('sort'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">
';
                $value = $context->find('children');
                $buffer .= $this->section2835496f3585455c7830b624ece53c8c($context, $indent, $value);
                $buffer .= $indent . '                </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5e96ec75439305fc88c78e77946e47bb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{.}} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFc0c0b051caebb6243b5c2bd6d728967(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'aria-current="true"';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'aria-current="true"';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBde0276478bac9139b7bdc89fdbbb5a8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                {{#haschildren}}
                <a id="drop-down-{{sort}}" href="#" class="list-group-item list-group-item-action icons-collapse-expand {{^isopen}}collapsed {{/isopen}}d-flex" data-toggle="collapse" data-target="#drop-down-menu-{{sort}}" aria-expanded="{{#isopen}}true{{/isopen}}{{^isopen}}false{{/isopen}}" aria-controls="drop-down-menu-{{sort}}">
                    {{{text}}}
                    <span class="ms-auto expanded-icon icon-no-margin mx-2">
                        {{#pix}} t/expanded, core {{/pix}}
                        <span class="sr-only">
                            {{#str}} collapse, core {{/str}}
                        </span>
                    </span>
                    <span class="ms-auto collapsed-icon icon-no-margin mx-2">
                        {{#pix}} t/collapsed, core {{/pix}}
                        <span class="sr-only">
                            {{#str}} expand, core {{/str}}
                        </span>
                    </span>
                </a>
                <div class="collapse {{#isopen}}show {{/isopen}}list-group-item p-0 border-0" role="menu" id="drop-down-menu-{{sort}}" aria-labelledby="drop-down-{{sort}}">
                    {{#children}}
                        {{^divider}}
                             <a href="{{{url}}}" class="ps-5 {{^isactive}}bg-light{{/isactive}}{{#isactive}}active{{/isactive}} list-group-item list-group-item-action">{{{text}}}</a>
                        {{/divider}}
                    {{/children}}
                </div>
                {{/haschildren}}
                {{^haschildren}}
                <a href="{{{url}}}" class="list-group-item list-group-item-action {{#isactive}}active{{/isactive}} {{#classes}}{{.}} {{/classes}}" {{#isactive}}aria-current="true"{{/isactive}}>
                    {{{text}}}
                </a>
                {{/haschildren}}
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('haschildren');
                $buffer .= $this->section50ac6cfc943625453568448825edf435($context, $indent, $value);
                $value = $context->find('haschildren');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                <a href="';
                    $value = $this->resolveValue($context->find('url'), $context);
                    $buffer .= ($value === null ? '' : $value);
                    $buffer .= '" class="list-group-item list-group-item-action ';
                    $value = $context->find('isactive');
                    $buffer .= $this->section5749c750acb0d7477dd5257d00cc6d53($context, $indent, $value);
                    $buffer .= ' ';
                    $value = $context->find('classes');
                    $buffer .= $this->section5e96ec75439305fc88c78e77946e47bb($context, $indent, $value);
                    $buffer .= '" ';
                    $value = $context->find('isactive');
                    $buffer .= $this->sectionFc0c0b051caebb6243b5c2bd6d728967($context, $indent, $value);
                    $buffer .= '>
';
                    $buffer .= $indent . '                    ';
                    $value = $this->resolveValue($context->find('text'), $context);
                    $buffer .= ($value === null ? '' : $value);
                    $buffer .= '
';
                    $buffer .= $indent . '                </a>
';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block713428f2c53de9aebab859391bdd84ed($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . 'theme_boost-drawers-primary';
    
        return $buffer;
    }

    public function blockD38028d67780ee6f785cf8e213f0a779($context)
    {
        $indent = $buffer = '';
        $buffer .= 'drawer drawer-left drawer-primary';
    
        return $buffer;
    }

    public function blockE052079a625ca42b568ba24af19cc7eb($context)
    {
        $indent = $buffer = '';
        $buffer .= '1';
    
        return $buffer;
    }

    public function block02c7f35cc8f4fd4935515ac2700f58cc($context)
    {
        $indent = $buffer = '';
        $buffer .= '        <a
';
        $buffer .= $indent . '            href="';
        $value = $this->resolveValue($context->findDot('config.homeurl'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '"
';
        $buffer .= $indent . '            title="';
        $value = $this->resolveValue($context->find('sitename'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '"
';
        $buffer .= $indent . '            data-region="site-home-link"
';
        $buffer .= $indent . '            class="aabtn text-reset d-flex align-items-center py-1 h-100"
';
        $buffer .= $indent . '        >
';
        $value = $context->findDot('output.should_display_navbar_logo');
        $buffer .= $this->sectionA64f0cb7e6e9ce5ffa12476ca05765a9($context, $indent, $value);
        $value = $context->findDot('output.should_display_navbar_logo');
        if (empty($value)) {
            
            $buffer .= $indent . '                <span class="sitename" title="';
            $value = $this->resolveValue($context->find('sitename'), $context);
            $buffer .= ($value === null ? '' : $value);
            $buffer .= '">';
            $value = $this->resolveValue($context->find('sitename'), $context);
            $buffer .= ($value === null ? '' : $value);
            $buffer .= '</span>
';
        }
        $buffer .= $indent . '        </a>
';
    
        return $buffer;
    }

    public function block465e4770df58e853c3956e6accd104e0($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . '        <div class="list-group">
';
        $value = $context->find('mobileprimarynav');
        $buffer .= $this->sectionBde0276478bac9139b7bdc89fdbbb5a8($context, $indent, $value);
        $buffer .= $indent . '        </div>
';
    
        return $buffer;
    }

    public function blockA1dd4f2e68d7796ac435ab08723145ef($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . 'show-drawer-primary';
    
        return $buffer;
    }
}
