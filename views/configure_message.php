<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();

if (isset($status_name)) {
    $status_bullet = $status_name != '' ? ('<span class="lead-status-' . e($status_id) . ' label' . (empty($status_color) ? ' label-default' : '') . ' text-uppercase" style="color:' . e($status_color) . ';border:1px solid ' . adjust_hex_brightness($status_color, 0.4) . ';background: ' . adjust_hex_brightness($status_color, 0.04) . ';">' . e($status_name) . '</span>') : '-';
} else {
    $status_bullet = '-';
}
?>


<div id="wrapper">
    <div class="content">
        <h4><?php echo htmlspecialchars($title); ?></h4>
        <?php echo form_open(admin_url('leadstatusmessenger/configure_message/' . $status_id)); ?>
        <div class="form-group">
            <label for="message">Mensagem para o status <?php echo $status_bullet ?></label>
            <textarea name="message" id="message" class="form-control" rows="5"><?php echo set_value('message', $message); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Mensagem</button>
        <button type="button" class="btn btn-success" onclick="sendMessage()">Enviar Mensagem</button>
        <a href="<?php echo admin_url('leadstatusmessenger'); ?>" class="btn btn-default">Voltar para a Lista</a>
        <?php echo form_close(); ?>
    </div>
</div>

<script>
    function sendMessage() {
        // if (confirm('Tem certeza de que deseja enviar esta mensagem?')) {
        if (true) {
            $.ajax({
                url: '<?php echo admin_url('leadstatusmessenger/send_message/' . $status_id); ?>',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    alert_float(response.success ? 'success' : 'danger', response.message);
                },
                error: function(xhr, status, error) {
                    alert_float('danger', 'Ocorreu um erro ao enviar a mensagem.' + error);
                }
            });
        }
    }
</script>

<?php init_tail(); ?>