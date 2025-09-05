<?php

class __Mustache_717f9dae7bd48da61285a0e348c336ec extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $context->find('moveicon');
        $buffer .= $this->section2e7d3cdfffee27291ffca5f384d8d23d($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '<div class="activity-grid ';
        $value = $context->find('hasname');
        if (empty($value)) {
            
            $buffer .= 'noname-grid';
        }
        $buffer .= '">
';
        $buffer .= $indent . '
';
        $value = $context->find('hasname');
        $buffer .= $this->sectionC44146697a33e42be418c265d7325e33($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('dates');
        $buffer .= $this->section4c8de9d74bfa9bc450d51cb0aa9173c8($context, $indent, $value);
        $buffer .= $indent . '
';
        $blockFunction = $context->findInBlock('core_courseformat/local/content/cm/badges');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/cm/badges')) {
                $buffer .= $partial->renderInternal($context, $indent . '        ');
            }
        }
        $buffer .= $indent . '
';
        $value = $context->find('groupmodeinfo');
        $buffer .= $this->sectionF5d18573a0da2899835fd40c262de556($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('completion');
        $buffer .= $this->sectionC5bb9010572231d5f22bc8e9c0ac1db4($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('controlmenu');
        $buffer .= $this->section6fe3218ba56c4097e85e2a8fc0597a37($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('altcontent');
        $buffer .= $this->section5eb38a27494659c38cbcf956ed2d3d80($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('modavailability');
        $buffer .= $this->sectionBdb1fabff9c35fbb10450efd02ed63b1($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('afterlink');
        $buffer .= $this->section561db450765feb91caa9161f28d7ad19($context, $indent, $value);
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section2e7d3cdfffee27291ffca5f384d8d23d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' {{{moveicon}}} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . ' ';
                $value = $this->resolveValue($context->find('moveicon'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionDd214457b3e379bea68b41a38de480be(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{$ core_courseformat/local/content/cm/cmname }}
                {{> core_courseformat/local/content/cm/cmname }}
            {{/ core_courseformat/local/content/cm/cmname }}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/cm/cmname');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/cm/cmname')) {
                        $buffer .= $partial->renderInternal($context, $indent . '                ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC44146697a33e42be418c265d7325e33(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{#cmname}}
            {{$ core_courseformat/local/content/cm/cmname }}
                {{> core_courseformat/local/content/cm/cmname }}
            {{/ core_courseformat/local/content/cm/cmname }}
        {{/cmname}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('cmname');
                $buffer .= $this->sectionDd214457b3e379bea68b41a38de480be($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAfb6fd07ae9e251f9844989d26fe82a9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    {{$core_course/activity_date}}
                        {{>core_course/activity_date}}
                    {{/core_course/activity_date}}
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_course/activity_date');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_course/activity_date')) {
                        $buffer .= $partial->renderInternal($context, $indent . '                        ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section12594cd97a324b580d856fff82823dee(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div data-region="activity-dates" class="activity-dates me-sm-2">
                {{#activitydates}}
                    {{$core_course/activity_date}}
                        {{>core_course/activity_date}}
                    {{/core_course/activity_date}}
                {{/activitydates}}
            </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div data-region="activity-dates" class="activity-dates me-sm-2">
';
                $value = $context->find('activitydates');
                $buffer .= $this->sectionAfb6fd07ae9e251f9844989d26fe82a9($context, $indent, $value);
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4c8de9d74bfa9bc450d51cb0aa9173c8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{#hasdates}}
            <div data-region="activity-dates" class="activity-dates me-sm-2">
                {{#activitydates}}
                    {{$core_course/activity_date}}
                        {{>core_course/activity_date}}
                    {{/core_course/activity_date}}
                {{/activitydates}}
            </div>
        {{/hasdates}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('hasdates');
                $buffer .= $this->section12594cd97a324b580d856fff82823dee($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF5d18573a0da2899835fd40c262de556(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div
            class="activity-groupmode-info align-self-start ms-sm-2"
            data-region="groupmode"
        >
            {{$ core_courseformat/local/content/cm/groupmode}}
                {{> core_courseformat/local/content/cm/groupmode}}
            {{/ core_courseformat/local/content/cm/groupmode}}
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
                $buffer .= $indent . '            class="activity-groupmode-info align-self-start ms-sm-2"
';
                $buffer .= $indent . '            data-region="groupmode"
';
                $buffer .= $indent . '        >
';
                $blockFunction = $context->findInBlock('core_courseformat/local/content/cm/groupmode');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/cm/groupmode')) {
                        $buffer .= $partial->renderInternal($context, $indent . '                ');
                    }
                }
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section28a1854fe0ea7eeab862d33284b356d7(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="activity-completion align-self-start ms-sm-2">
                {{$ core_courseformat/local/content/cm/activity_info}}
                    {{> core_courseformat/local/content/cm/activity_info}}
                {{/ core_courseformat/local/content/cm/activity_info}}
            </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div class="activity-completion align-self-start ms-sm-2">
';
                $blockFunction = $context->findInBlock('core_courseformat/local/content/cm/activity_info');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/cm/activity_info')) {
                        $buffer .= $partial->renderInternal($context, $indent . '                    ');
                    }
                }
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC5bb9010572231d5f22bc8e9c0ac1db4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{#hascompletion}}
            <div class="activity-completion align-self-start ms-sm-2">
                {{$ core_courseformat/local/content/cm/activity_info}}
                    {{> core_courseformat/local/content/cm/activity_info}}
                {{/ core_courseformat/local/content/cm/activity_info}}
            </div>
        {{/hascompletion}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('hascompletion');
                $buffer .= $this->section28a1854fe0ea7eeab862d33284b356d7($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6fe3218ba56c4097e85e2a8fc0597a37(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="activity-actions bulk-hidden align-self-start ms-sm-2">
            {{$ core_courseformat/local/content/cm/controlmenu }}
                {{> core_courseformat/local/content/cm/controlmenu }}
            {{/ core_courseformat/local/content/cm/controlmenu }}
        </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="activity-actions bulk-hidden align-self-start ms-sm-2">
';
                $blockFunction = $context->findInBlock('core_courseformat/local/content/cm/controlmenu');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/cm/controlmenu')) {
                        $buffer .= $partial->renderInternal($context, $indent . '                ');
                    }
                }
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE7700784befebc1262586a7c792a229c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'activity-description';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'activity-description';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5eb38a27494659c38cbcf956ed2d3d80(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="activity-altcontent text-break {{#hasname}}activity-description{{/hasname}}">
            {{{altcontent}}}
        </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="activity-altcontent text-break ';
                $value = $context->find('hasname');
                $buffer .= $this->sectionE7700784befebc1262586a7c792a229c($context, $indent, $value);
                $buffer .= '">
';
                $buffer .= $indent . '            ';
                $value = $this->resolveValue($context->find('altcontent'), $context);
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

    private function sectionBdb1fabff9c35fbb10450efd02ed63b1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{$ core_courseformat/local/content/cm/availability }}
            {{> core_courseformat/local/content/cm/availability }}
        {{/ core_courseformat/local/content/cm/availability }}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/cm/availability');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/cm/availability')) {
                        $buffer .= $partial->renderInternal($context, $indent . '            ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section561db450765feb91caa9161f28d7ad19(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="activity-afterlink afterlink d-flex align-items-center">
            {{{afterlink}}}
        </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="activity-afterlink afterlink d-flex align-items-center">
';
                $buffer .= $indent . '            ';
                $value = $this->resolveValue($context->find('afterlink'), $context);
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
