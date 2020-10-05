<?php
  if(validation_errors() != '' || isset($error_message)){
?>
  <div class="alert alert-danger" role="alert">
    <?php echo validation_errors(); ?>
    <?php if(isset($error_message)){  ?>
      <?php echo $error_message; ?>
    <?php
      }
    ?>
  </div>
  
<?php
  }
?>