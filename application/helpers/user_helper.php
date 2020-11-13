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

  if(!function_exists('update_balance')){
    function update_balance($new_balance, $user_id = null){
      $CI = &get_instance();
      $CI->load->model(['Usuario']);

      $user_update["id"] = $user_id;
      if($user_id == null){
        $user_update["id"] = logged_user()["id"];
      }

      $user_update["balance_total"] = $new_balance;
      // Update the user balance
      return $CI->Usuario->update($user_update);
    }
  }

  if(!function_exists('get_user_profile')){
    function get_user_profile($user_id = null){
      $CI = &get_instance();
      $CI->load->model(['Usuario']);


      if($user_id == null){
        $user_id = logged_user()["id"];
      }

      return $CI->Usuario->get_user_by_param("u.id", $user_id);
    }
  }
?>
