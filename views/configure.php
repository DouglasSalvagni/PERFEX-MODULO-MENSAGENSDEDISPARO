<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="col-md-12">
            <div class="panel_s">
                <div class="panel-body">
                    <h4 class="no-margin">Configurações do Agente IA</h4>
                    <hr>
                    <?php echo form_open(admin_url('leadstatusmessenger/index_save')); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="webhook_url">Webhook URL</label>
                                <input type="url" name="webhook_url" id="webhook_url" class="form-control" value="<?php echo $webhook_url; ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="webhook_token">Token</label>
                                <input type="text" name="webhook_token" id="webhook_token" class="form-control" value="<?php echo $webhook_token; ?>">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Configurações</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php init_tail(); ?>
</body>

</html>