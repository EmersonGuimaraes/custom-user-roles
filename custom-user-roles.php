<?php
/*
Plugin Name: Custom User Roles
Plugin URI: https://github.com/EmersonGuimaraes/custom-user-roles
Description: Adiciona ou remove funções de usuário via API REST.
Version: 1.0
Author: Emerson Guimarães
Author URI: https://github.com/EmersonGuimaraes
License: GPL2
*/

// Verifica se o arquivo é acessado diretamente e impede o acesso se for o caso.
if (!defined('ABSPATH')) {
    exit; // Evita acesso direto ao arquivo.
}

// Define a classe principal do plugin.
class CustomUserRoles {
    // Construtor da classe. Registra os endpoints da API REST ao inicializar o plugin.
    public function __construct() {
        add_action('rest_api_init', array($this, 'register_api_endpoints'));
    }

    // Registra os endpoints da API REST para o plugin.
    public function register_api_endpoints() {
        register_rest_route('custom-user-roles/v1', '/add-role', array(
            'methods' => 'POST',
            'callback' => array($this, 'add_user_role'),
            'permission_callback' => array($this, 'permissions_check')
        ));
        register_rest_route('custom-user-roles/v1', '/remove-role', array(
            'methods' => 'POST',
            'callback' => array($this, 'remove_user_role'),
            'permission_callback' => array($this, 'permissions_check')
        ));
        register_rest_route('custom-user-roles/v1', '/list-roles', array(
            'methods' => 'GET',
            'callback' => array($this, 'list_roles'),
            'permission_callback' => array($this, 'permissions_check')
        ));
        register_rest_route('custom-user-roles/v1', '/create-role', array(
            'methods' => 'POST',
            'callback' => array($this, 'create_role'),
            'permission_callback' => array($this, 'permissions_check')
        ));
        register_rest_route('custom-user-roles/v1', '/user-roles', array(
            'methods' => 'GET',
            'callback' => array($this, 'user_roles'),
            'permission_callback' => array($this, 'permissions_check')
        ));
    }

    // Adiciona um papel (função) a um usuário.
    public function add_user_role($request) {
        $user_id = $request->get_param('user_id');
        $role = $request->get_param('role');

        if (empty($user_id) || empty($role)) {
            return new WP_Error('missing_parameter', 'User ID and Role are required', array('status' => 400));
        }

        $user = get_userdata($user_id);
        if (!$user) {
            return new WP_Error('invalid_user', 'Invalid user ID', array('status' => 404));
        }

        $user->add_role($role);
        return rest_ensure_response(array('message' => 'Role added successfully', 'user_id' => $user_id, 'role' => $role));
    }

    // Remove um papel (função) de um usuário.
    public function remove_user_role($request) {
        $user_id = $request->get_param('user_id');
        $role = $request->get_param('role');

        if (empty($user_id) || empty($role)) {
            return new WP_Error('missing_parameter', 'User ID and Role are required', array('status' => 400));
        }

        $user = get_userdata($user_id);
        if (!$user) {
            return new WP_Error('invalid_user', 'Invalid user ID', array('status' => 404));
        }

        $user->remove_role($role);
        return rest_ensure_response(array('message' => 'Role removed successfully', 'user_id' => $user_id, 'role' => $role));
    }

    // Lista todas as funções de usuário.
    public function list_roles() {
        global $wp_roles;
        return rest_ensure_response($wp_roles->roles);
    }

    // Cria uma nova função de usuário.
    public function create_role($request) {
        $new_role = $request->get_param('role');
        $display_name = $request->get_param('display_name');

        if (empty($new_role) || empty($display_name)) {
            return new WP_Error('missing_parameter', 'Role and Display Name are required', array('status' => 400));
        }

        $subscriber = get_role('subscriber');
        if (!$subscriber) {
            return new WP_Error('invalid_role', 'Subscriber role does not exist', array('status' => 404));
        }

        add_role($new_role, $display_name, $subscriber->capabilities);
        return rest_ensure_response(array('message' => 'Role created successfully', 'role' => $new_role, 'display_name' => $display_name));
    }

    // Lista todas as funções associadas a um usuário específico.
    public function user_roles($request) {
        $user_id = $request->get_param('user_id');

        if (empty($user_id)) {
            return new WP_Error('missing_parameter', 'User ID is required', array('status' => 400));
        }

        $user = get_userdata($user_id);
        if (!$user) {
            return new WP_Error('invalid_user', 'Invalid user ID', array('status' => 404));
        }

        return rest_ensure_response(array('user_id' => $user_id, 'roles' => $user->roles));
    }

    // Verifica se o usuário atual tem permissão para acessar os endpoints.
    public function permissions_check($request) {
        return current_user_can('edit_users');
    }
}

// Instancia a classe do plugin.
new CustomUserRoles();
