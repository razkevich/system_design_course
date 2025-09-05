<?php

class __Mustache_5792b2d2421a02bb47eb96061b18e965 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div id="courseindexdrawercontrols" class="dropdown">
';
        $buffer .= $indent . '    <button class="btn btn-icon rounded-circle mx-2"
';
        $buffer .= $indent . '            type="button"
';
        $buffer .= $indent . '            data-toggle="dropdown"
';
        $buffer .= $indent . '            aria-haspopup="true"
';
        $buffer .= $indent . '            aria-expanded="false"
';
        $buffer .= $indent . '            title="';
        $value = $context->find('str');
        $buffer .= $this->section72de7bd71769771a8c5b8a91517a7a84($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '    >
';
        $buffer .= $indent . '        <i class="icon fa fa-ellipsis-v fa-fw m-0" aria-hidden="true"></i>
';
        $buffer .= $indent . '    </button>
';
        $buffer .= $indent . '    <div class="dropdown-menu dropdown-menu-right">
';
        $buffer .= $indent . '        <a class="dropdown-item"
';
        $buffer .= $indent . '           href="#"
';
        $buffer .= $indent . '           data-action="expandallcourseindexsections"
';
        $buffer .= $indent . '        >
';
        $buffer .= $indent . '            ';
        $value = $context->find('pix');
        $buffer .= $this->sectionC956bd408046825a22f12d78fd34eb0b($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '            ';
        $value = $context->find('str');
        $buffer .= $this->section5c42c2ba118f2e9924725a2f71fafad6($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        </a>
';
        $buffer .= $indent . '        <a class="dropdown-item"
';
        $buffer .= $indent . '           href="#"
';
        $buffer .= $indent . '           data-action="collapseallcourseindexsections"
';
        $buffer .= $indent . '        >
';
        $buffer .= $indent . '            <span class="dir-rtl-hide">';
        $value = $context->find('pix');
        $buffer .= $this->section8c98a143aad766c17f80893930467784($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '            <span class="dir-ltr-hide">';
        $value = $context->find('pix');
        $buffer .= $this->sectionB4c4513ed48dca32a697c66f27aba45d($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '            ';
        $value = $context->find('str');
        $buffer .= $this->sectionE1c5833858b6a763436e852c524f170c($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        </a>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';
        $value = $context->find('js');
        $buffer .= $this->sectionE33c0bb533527d1ee3483f1398bc6ede($context, $indent, $value);

        return $buffer;
    }

    private function section72de7bd71769771a8c5b8a91517a7a84(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'courseindexoptions, courseformat';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'courseindexoptions, courseformat';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC956bd408046825a22f12d78fd34eb0b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' t/angles-down, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' t/angles-down, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5c42c2ba118f2e9924725a2f71fafad6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'expandall';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'expandall';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8c98a143aad766c17f80893930467784(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' t/angles-right, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' t/angles-right, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB4c4513ed48dca32a697c66f27aba45d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' t/angles-left, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' t/angles-left, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE1c5833858b6a763436e852c524f170c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'collapseall';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'collapseall';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE33c0bb533527d1ee3483f1398bc6ede(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    require([\'theme_boost/courseindexdrawercontrols\'], function(component) {
    component.init(\'courseindexdrawercontrols\');
    });
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    require([\'theme_boost/courseindexdrawercontrols\'], function(component) {
';
                $buffer .= $indent . '    component.init(\'courseindexdrawercontrols\');
';
                $buffer .= $indent . '    });
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
