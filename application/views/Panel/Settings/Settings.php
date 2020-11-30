<form action="" method="post" id="form-settings">
<?php
    if(isset($message)){
?>
    <div class="alert alert-success" role="alert">
        <?= $message["message"] ?>
    </div>
<?php
    }
?>

            <?php 
                if(is_array($settings)){
            ?>
                    
                    <?php
                        if(is_array($settings)){
                            foreach ($settings as $setting) {
                    ?>
                        <div class="row">
        <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mt-0 add-draw-title"><?= $setting["title"] ?></h4>
                                        <hr class="mb-4">
                                        <div class="row">
                                            <?php
                                                switch ($setting["type"]) {
                                                    case 'input':
                                                        ?>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input id="<?= $setting["key"] ?>" required name="data[<?= $setting["key"] ?>]" type="<?= $setting["input_type"] ?>" class="form-control"  value="<?= $setting["value"] ?>">
                                                                </div>
                                                            </div>
                                                        <?php
                                                        break;
                                                    
                                                    default:
                                                        ?>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input id="<?= $setting["key"] ?>" required name="<?= $setting["key"] ?>" type="<?= $setting["input_type"] ?>" class="form-control"  value="<?= $setting["value"] ?>">
                                                                </div>
                                                            </div>
                                                        <?php
                                                        break;
                                                }
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    ?>
                </div>
    </div>
            <?php
                }
            ?>
        </div>
    </div>
    <div class="row justify-content-end">
        <div class="col-md-3">
            <div class="form-group">    
                <a class="btn btn-light btn-block cancel-edit-draw-button invisible" type="submit">Cancelar</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <button class="btn btn-success btn-block" type="submit">Guardar</button>
            </div>
        
</form>