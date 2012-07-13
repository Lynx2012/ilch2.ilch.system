<?php

    // Create Form
    $form = Bootstrap_Form::init();
    
    // Mail address field
    $mail = Bootstrap_Form_Input::init('mail');
    $form->append(Bootstrap_Form_Field::init($mail, __('Email address')));
    
    // Password field
    $pass = Bootstrap_Form_Input::init('pass');
    $form->append(Bootstrap_Form_Field::init($pass, __('Password')));
    
    // Actions
    $login = Bootstrap_Button::init(
                __('Login'),
                Bootstrap_Button::TYPE_SUBMIT,
                Bootstrap_Button::COLOR_SUCCESS
            );
    $login->prepend(Bootstrap_Icon::init(Bootstrap_Icon::ICON_CHEVRON_RIGHT));
    
    $regist = Bootstrap_Button::init(
                __('Registration'),
                URL::site('user/registration')
            );
    
    $form->append(Bootstrap_Form_Actions::init(array(
        $login, $regist
    )));
?>

<?php echo $form; ?>