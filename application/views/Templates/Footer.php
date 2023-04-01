<footer class="footer mt-4 bg-light">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
            <ul id="footer-list">
                <li>
                <p style="cursor:pointer;text-decoration:underline;" data-toggle="modal" data-target="#frequent_questions">Preguntas Frecuentes</p>
                </li>
                <li>
                    <a target="_blank" href="mailto:<?= get_setting("commerce_email") ?>">
                    <p style="text-decoration:underline;"> <?= get_setting("commerce_email") ?></p>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="https://web.whatsapp.com/send?phone=57<?= get_setting("whatsapp_number") ?>">
                    <img style="margin-right: 5px;" width="30px" src="<?= base_url() ?>assets/images/whatsapp_icon.png" alt="Whatsapp icon" srcset="">
                    <p style="text-decoration:underline;">Enviar mensaje a whatsapp</p>
                    </a>
                </li>
            </ul>
            </div>
            <div class="col-md-4 text-right">
                <a href="https://www.placetopay.com/web" target="_blank"><img width="120" src="https://static.placetopay.com/placetopay-logo.svg" alt="PlaceToPay" srcset=""></a>
            </div>
        </div>
    </div>
</footer>
<script type="module" src="<?= base_url().'assets/js/main.js' ?>"></script>
<script src="<?= base_url().'assets/libs/select2/select2.min.js' ?>"></script>
<!-- end Footer -->