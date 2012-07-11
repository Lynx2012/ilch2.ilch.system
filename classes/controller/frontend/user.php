<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_User extends Controller_Frontend_Template {
    
    public function action_login()
    {
        // Collect services with login view
        $services_view = array();

        // Collect services with login page
        $services_page = array();

        foreach (User_Auth_Service::$services AS $key => $val)
        {
            if (isset($val['login_view']) AND $val['login_view'])
            {
                $services_view[$key] = $val;
            }
            elseif (isset($val['login_page']) AND $val['login_page'])
            {
                $services_page[$key] = $val;
            }
        }

        // Login
        $this->template->title = __('Login');
        $this->template->content = View::factory('user/login', array(
                'services_view' => $services_view,
                'services_page' => $services_page
            ));
    }

    public function action_registration()
    {
        // No errors
        $errors = array();
        
        // Fields
        $fields = array(
            'nickname' => array(
                'element' => Bootstrap_Form_Input::init('nickname', Arr::get($_POST, 'nickname')),
                'label' => 'Nickname'
            ),
            'email' => array(
                'element' => Bootstrap_Form_Input::init('email', Arr::get($_POST, 'email')),
                'label' => 'Email address'
            ),
            'email_c' => array(
                'element' => Bootstrap_Form_Input::init('email_c', Arr::get($_POST, 'email_c')),
                'label' => 'Conf. email address',
                'rules' => array(
                    array('matches', array(
                        ':validation', 'email', ':field'
                    ))
                )
            ),
            'password' => array(
                'element' => Bootstrap_Form_Input::init('password', NULL, 'password'),
                'label' => 'Password',
                'rules' => array(
                    array('not_empty'),
                    array('min_length', array(
                        ':value', 6
                    ))
                )
            ),
            'password_c' => array(
                'element' => Bootstrap_Form_Input::init('password_c', NULL, 'password'),
                'label' => 'Conf. password',
                'rules' => array(
                    array('matches', array(
                        ':validation', 'password', ':field'
                    ))
                )
            ),
        );
        
        // There was a post
        if ($_POST)
        {
            // Validate
            try
            {
                // User
                $user = Jelly::factory('user');
                $user->nickname = Arr::get($_POST, 'nickname');
                $user->email = Arr::get($_POST, 'email');
                
                $post = Validation::factory($_POST);
                
                foreach ($fields AS $name => $field)
                {
                    if (isset($field['label']))
                    {
                        $post->label($name, $field['label']);
                    }
                    if (isset($field['rules']))
                    {
                        $post->rules($name, $field['rules']);
                    }
                }
                
                $user->save($post);
            }
            catch (Jelly_Validation_Exception $e)
            {
                // Get the error messages
                $errors = $e->errors('validation');
            }
        }
        
        // Create Form element
        $form = Bootstrap_Form::init();
        
        // Add fields
        foreach ($fields AS $name => $field)
        {
            $error = NULL;
            
            if (isset($errors[$name]))
            {
                $error = $errors[$name];
            }
            elseif (isset($errors['_external'][$name]))
            {
                $error = $errors['_external'][$name];
            }
            
            $form->append(Bootstrap_Form_Field::init(array(
                'element' => $field['element'],
                'label' => $field['label'],
                'help' => $error,
                'type' => ($error) ? Bootstrap_Form_Field::TYPE_ERROR : NULL
            )));
        }
        
        // Submit button
        $regist = Bootstrap_Button::init(
                    __('Register'),
                    Bootstrap_Button::TYPE_SUBMIT,
                    Bootstrap_Button::COLOR_SUCCESS
                );
        $regist->prepend(Bootstrap_Icon::init(Bootstrap_Icon::ICON_OK));

        // Abort button
        $abort = Bootstrap_Button::init(
                    __('Abort'),
                    URL::site('user/login')
                );

        // Add submit and abort button to actions field
        $form->append(Bootstrap_Form_Actions::init(array(
            $regist, $abort
        )));
        
        // Form
        $this->template->title = __('Registration');
        $this->template->content = View::factory('user/registration/system', array(
            'form' => $form,
        ));
    }
    
    public function action_logout()
    {
        // Logout
        $this->template->title = __('Logout');
        $this->template->content = View::factory('user/logout');
    }

}