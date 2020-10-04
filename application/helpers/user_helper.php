<?php 

  if(!function_exists('generate_change_password_url')){
    function generate_change_password_url($user){
      return base_url() . 'passwords/change_password_form/' . $user['slug'] . '/' . $user['change_password_salt'];
    }
  }

  if(!function_exists('validate_passsword_form')){
    function validate_passsword_form($scope){
      $required_message = 'El campo %s es requerido';

      $config = array(
        array(
          'field' => 'password',
          'label' => 'Contraseña',
          'rules' => 'required',
          'errors' => array(
            'required' => $required_message,
          )
        ),
        array(
          'field' => 'password_repeated',
          'label' => 'Repetir Contraseña',
          'rules' => 'required|matches[password]',
          'errors' => array(
            'required' => $required_message,
            'matches' => 'Las contraseñas no coinciden'
          )
        )
      );

      $scope->form_validation->set_rules($config);
      return $scope->form_validation->run();
    }
  }

  if(!function_exists('validate_send_instructions_form')){
    function validate_send_instructions_form($scope){
      $required_message = 'El campo %s es requerido';

      $config = array(
        array(
          'field' => 'email',
          'label' => 'Email',
          'rules' => 'required|valid_email',
          'errors' => array(
            'required' => $required_message,
            'valid_email' => 'El %s debe ser un formato valido.'
          )
        )
      );

      $scope->form_validation->set_rules($config);
      return $scope->form_validation->run();
    }
  }
?>
