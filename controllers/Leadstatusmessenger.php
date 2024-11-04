<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LeadStatusMessenger extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        // Verificar se o usuário está logado e tem permissão
        if (!is_staff_logged_in()) {
            redirect(admin_url('authentication'));
        }

        // Carregar modelos e bibliotecas necessárias
        $this->load->model('leads_model');
    }

    public function list_status()
    {
        $data['statuses'] = $this->leads_model->get_status();
        $this->load->view('lead_status_list', $data);
    }

    public function configure_message($status_id)
    {
        if ($this->input->post()) {

            if ($status_id == 'todos') {
                $mensagem_whats_massa = $this->input->post('message');
                update_option(LEADSTATUSMESSENGER_MODULE_NAME . '_mensagem_whats_massa', $mensagem_whats_massa);

                set_alert('success', 'Mensagem salva com sucesso.');
                redirect(admin_url('leadstatusmessenger/configure_message/todos'));
            } else {
                $message = $this->input->post('message');
    
                // Salvar a mensagem associada ao status_id
                $this->db->where('status_id', $status_id);
                $exists = $this->db->get('lead_status_messages')->row();
    
                if ($exists) {
                    // Atualizar a mensagem existente
                    $this->db->where('status_id', $status_id);
                    $this->db->update('lead_status_messages', ['message' => $message]);
                } else {
                    // Inserir uma nova mensagem
                    $this->db->insert('lead_status_messages', ['status_id' => $status_id, 'message' => $message]);
                }
                set_alert('success', 'Mensagem salva com sucesso.');
                redirect(admin_url('leadstatusmessenger/configure_message/' . $status_id));
            }

        } else {

            if ($status_id == 'todos') {
                $message = get_option(LEADSTATUSMESSENGER_MODULE_NAME . '_mensagem_whats_massa');
                $data['message'] = $message ? $message : '';
                $data['status_name'] = 'Todos';
                $data['status_color'] = '#22c55e';
                $data['status_id'] = 'todos';
                $data['title'] = 'Configurar Mensagem';
    
                $this->load->view('leadstatusmessenger/configure_message', $data);
            } else {

                // Carregar a mensagem existente e o nome do status
                $this->db->select('lead_status_messages.message, leads_status.name, leads_status.color');
                $this->db->from('lead_status_messages');
                $this->db->join('leads_status', 'leads_status.id = lead_status_messages.status_id');
                $this->db->where('lead_status_messages.status_id', $status_id);
                $message = $this->db->get()->row();
    
                $data['message'] = $message ? $message->message : '';
                $data['status_name'] = $message ? $message->name : '';
                $data['status_color'] = $message ? $message->color : '';
                $data['status_id'] = $status_id;
                $data['title'] = 'Configurar Mensagem';
    
                $this->load->view('leadstatusmessenger/configure_message', $data);
            }

        }
    }

    public function send_message($status_id)
    {
        // Verificar se a requisição é AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // Carregar a mensagem
        $this->db->where('status_id', $status_id);
        $message = $this->db->get('lead_status_messages')->row();

        if ($message) {
            // Preparar os dados para o webhook
            $postData = [
                'status_id' => $status_id,
                'message' => $message->message,
            ];

            $webhook_url = get_option(LEADSTATUSMESSENGER_MODULE_NAME . '_webhook_url');
            $webhook_token = get_option(LEADSTATUSMESSENGER_MODULE_NAME . '_webhook_token');

            if (!$webhook_url || !$webhook_token) {
                $response = ['success' => false, 'message' => 'O webhookou ou token não foi configurado.'];
                echo json_encode($response);
                return;
            }

            // Enviar a requisição HTTP para o webhook
            $ch = curl_init($webhook_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

            // Configurar o cabeçalho Authorization com o token
            $headers = [
                'Authorization: Bearer ' . $webhook_token,
                'Content-Type: application/x-www-form-urlencoded'
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // Executar a requisição
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);


            // Verificar a resposta
            if ($httpCode == 200) {
                $response = ['success' => true, 'message' => 'Mensagem enviada com sucesso.'];
            } else {
                $response = ['success' => false, 'message' => 'Falha ao enviar a mensagem.'];
            }
        } else {
            $response = ['success' => false, 'message' => 'Nenhuma mensagem configurada para este status.'];
        }

        echo json_encode($response);
    }
}
