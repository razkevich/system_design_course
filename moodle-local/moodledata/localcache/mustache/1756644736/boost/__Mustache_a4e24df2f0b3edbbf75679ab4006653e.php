<?php

class __Mustache_a4e24df2f0b3edbbf75679ab4006653e extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<span class="badge bg-primary text-light">';
        $value = $this->resolveValue($context->find('versioninfo'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '</span>
';

        return $buffer;
    }
}
