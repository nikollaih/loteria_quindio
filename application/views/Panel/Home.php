

<div class="row">
  <div class="col-md-12">
    <?php $lottopoints = get_user_profile()["lotto_points"] ?>
    <?php $points_for_play = get_setting('points_for_play') ?>
    <?php if ($lottopoints >= $points_for_play && get_setting('enable_loto_game') == 1){ ?>
      <div class="card play_for_win">
        <div class="card-body">
          Tienes <?= $lottopoints ?> intentos disponibles para jugar y ganar productos.  <a href="<?= base_url() . 'games/slot_game'; ?>" class="btn btn-success btn-lg">Jugar</a>    
        </div>
      </div>
    <?php } ?>
    <div class="row">
    <div class="col-md-12 col-lg-12 col-xl-6 col-sm-12">
        <div class="card">
          <div class="card-body">
              <h4 class="header-title mt-0">Resultados del ultimo sorteo jugado el <?= ucfirst(strftime('%b %d, %Y',strtotime($draw["date"]))); ?></h4>
              <hr class="mb-4">
              <img width="100%" src="<?= base_url() ?>uploads/results/<?= $draw["image_result"] ?>" alt="" srcset="">
          </div>
        </div>
      </div>
      <div class="col-md-12 col-lg-12 col-xl-6 col-sm-12">
      <div class="card">
        <div class="card-body">
            <h4 class="header-title mt-0">Resultados del ultimo sorteo jugado el <?= ucfirst(strftime('%b %d, %Y',strtotime($draw["date"]))); ?></h4>
            <hr class="mb-4">
            <table id="table-results" class="custom-datatable table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Resultado</th>
                        <th scope="col">Serie</th>
                        <th scope="col">Sorteo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($results) && is_array($results)){
                            $x = 1;
                            foreach ($results as $result) {
                    ?>
                        <tr>
                            <td><strong><?= $result["award_name"] ?></strong></td>
                            <td><?= $result["result_number"] ?></td>
                            <td><?= $result["result_serie"] ?></td>
                            <td><?= $draw["draw_number"] ?></td>
                        </tr>
                    <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
      </div>
    </div>
  </div>
</div>