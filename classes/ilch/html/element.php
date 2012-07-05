<?php

defined('SYSPATH') or die('No direct script access.');

class Ilch_HTML_Element
{

    public static $content_free = array(
        'img',
        'hr',
        'br',
        'input',
        'meta',
        'link'
    );
    protected $_element = NULL;
    protected $_attr = array();
    protected $_content = '';

    public function __construct($element, $options = array())
    {
        // Set tag name
        $this->set_element($element);

        // Set attributes
        if (isset($options['attr']))
            $this->set_attr($options['attr']);

        // Set content
        if (isset($options['content']))
            $this->set_content($options['content']);
    }
    
    public static function init($element, $options = array())
    {
        return new HTML_Element($element, $options);
    }

    /**
     * @param string $value
     * @return Ilch_HTML_Element
     */
    public function set_element($value)
    {
        $this->_element = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function get_element()
    {
        return $this->_element;
    }

    /**
     * @param array $value
     * @return Ilch_HTML_Element
     */
    public function set_attr(array $value)
    {
        $this->_attr = $value;
        return $this;
    }
    
    public function add_attr(array $value)
    {
        return $this->set_attr(array_merge($this->get_attr(), $value));
    }

    /**
     * @return array
     */
    public function get_attr()
    {
        return $this->_attr;
    }
    
    public function set_content($value)
    {
        $this->_content = $value;
        return $this;
    }
    
    public function set($value)
    {
        return $this->set_content($value);
    }
    
    public function prepend($value)
    {
        $value = $value.$this->get_content();
        return $this->set_content($value);
    }
    
    public function append($value)
    {
        $value = $this->get_content().$value;
        return $this->set_content($value);
    }
    
    public function get_content()
    {
        return $this->_content;
    }
    
    public function get()
    {
        return $this->get_content();
    }

    public function parse_attr($attr = NULL)
    {
        if ($attr === NULL)
            $attr = $this->get_attr();

        $string = '';

        foreach ($attr AS $key => $val)
        {
            $string . ' ' . $key . '="' . str_replace('"', '\"', $val) . '"';
        }

        return $string;
    }

    public function render($return = FALSE)
    {
        if (in_array($this->get_element(), HTML_Element::$content_free))
        {
            $f = '<%1$s%2$s />';
        }
        else
        {
            $f = '<%1$s%2$s>%3$s</%1$s>';
        }
        
        $c = sprintf($f,$this->get_element(), $this->parse_attr(), $this->get_content());
        
        if ($return)
        {
            return $c;
        }
        else
        {
            echo $c;
        }
    }
    
    public function __toString()
    {
        return $this->render(TRUE);
    }

}