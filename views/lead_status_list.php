<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <h4><?php echo $title; ?></h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Status ID</th>
                    <th>Status Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($statuses as $status) : ?>
                    <tr>
                        <td><?php echo $status['id']; ?></td>
                        <td><?php echo $status['name']; ?></td>
                        <td>
                            <a href="<?php echo admin_url('leadstatusmessenger/configure_message/' . $status['id']); ?>" class="btn btn-primary">Configure Message</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php init_tail(); ?>
