<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="panel_s">
            <div class="panel-body">
                <h4>Disparo por status do lead</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th style="width: 60px; text-align:center">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($statuses as $status) : ?>
                            <tr>
                                <td><?php echo $status['name']; ?></td>
                                <td>
                                    <a href="<?php echo admin_url('leadstatusmessenger/configure_message/' . $status['id']); ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel_s">
            <div class="panel-body">
                <h4>Disparo para todos</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th style="width: 60px; text-align:center">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Todos</td>
                            <td>
                                <a href="<?php echo admin_url('leadstatusmessenger/configure_message/todos'); ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>