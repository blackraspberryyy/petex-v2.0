<?php

class ManageOfficer extends CI_Controller {
    function __construct() {
        parent::__construct();
        //---> MODELS HERE!

        
        //---> LIBRARIES HERE!

        
        //---> SESSIONS HERE!
        
    }
    
    public function index(){
        $data = array(
            'title' => "Manage Officer",
            'admins' => $this->ManageOfficer_model->get_admins(),
            //FOR DUMMY VARIABLES
            'user_name' => "Juan Carlo D.R. Valencia",
            'user_picture' => "images/user/jc.png",
            'user_access' => "Administrator"
            );
        $this->load->view("dashboard/includes/header", $data);
        $this->load->view("admin_nav/navheader");
        $this->load->view("manage_officer/main");
        $this->load->view("dashboard/includes/footer");
    }
    public function activate_officer_exec(){
        $this->session->set_userdata("activate_officer", $this->uri->segment(3));
        redirect(base_url()."ManageOfficer/activate_officer");
    }
    
    public function activate_officer(){
        $user = $this->ManageUsers_model->get_users("user", array("user_id" => $this->session->userdata("activate_officer")))[0];
        if($this->ManageUsers_model->activate_user("user", array("user_id" => $this->session->userdata("activate_officer")))){
            $this->session->set_flashdata("activation_success", "Successfully activated ".$user->user_firstname." ".$user->user_lastname."'s account.");
        }else{
            $this->session->set_flashdata("activation_fail", "Something went wrong while activating ".$user->user_firstname." ".$user->user_lastname."'s account.");
        }
        $this->session->unset_userdata("activate_officer");
        redirect(base_url()."ManageOfficer");
    }
    
    public function deactivate_officer_exec(){
        $this->session->set_userdata("deactivate_officer", $this->uri->segment(3));
        redirect(base_url()."ManageOfficer/deactivate_officer");
    }
    
    public function deactivate_officer(){
        $user = $this->ManageUsers_model->get_users("user", array("user_id" => $this->session->userdata("deactivate_officer")))[0];
        if($this->ManageUsers_model->deactivate_user("user", array("user_id" => $this->session->userdata("deactivate_officer")))){
            $this->session->set_flashdata("activation_success", "Successfully deactivated ".$user->user_firstname." ".$user->user_lastname."'s account.");
        }else{
            $this->session->set_flashdata("activation_fail", "Something went wrong while deactivating ".$user->user_firstname." ".$user->user_lastname."'s account.");
        }
        $this->session->unset_userdata("deactivate_officer");
        redirect(base_url()."ManageOfficer");
    }
    
    public function show_officer_info_exec(){
        $this->session->set_userdata("show_officer_info", $this->uri->segment(3));
        redirect(base_url()."ManageOfficer/show_officer_info");
    }
    
    public function show_officer_info(){
        $selected_officer = $this->ManageUsers_model->get_user_info("user", array("user_id" => $this->session->userdata("show_officer_info")))[0];
        $officer_transaction = $this->ManageUsers_model->get_user_transactions(array("transaction.user_id" => $this->session->userdata("show_officer_info")));
        $officer_activity = $this->ManageUsers_model->get_user_activities(array("event.user_id" => $this->session->userdata("show_officer_info")));
        $data = array(
            "title" => $selected_officer->user_firstname." ".$selected_officer->user_lastname." | Information",
            "officer" => $selected_officer,
            "transactions" => $officer_transaction,
            "activities" => $officer_activity,
            //FOR DUMMY VARIABLES
            'user_name' => "Juan Carlo D.R. Valencia",
            'user_picture' => "images/user/jc.png",
            'user_access' => "Administrator"
        );
        $this->load->view("dashboard/includes/header", $data);
        $this->load->view("admin_nav/navheader");
        $this->load->view("manage_officer/show_officer_information");
        $this->load->view("dashboard/includes/footer");
    }
    
    public function manage_module_exec(){
        $this->session->set_userdata("manage_module", $this->uri->segment(3));
        redirect(base_url()."ManageOfficer/manage_module");
    }
    
    public function manage_module(){
        $selected_officer = $this->ManageUsers_model->get_user_info("user", array("user_id" => $this->session->userdata("manage_module")))[0];
        $officer_modules = $this->ManageOfficer_model->get_officer_modules(array("module_access.user_id" => $this->session->userdata("manage_module")));
        $modules = $this->ManageOfficer_model->get_modules();
        $data = array(
            'title' => $selected_officer->user_firstname." ".$selected_officer->user_lastname. " | Module Access",
            'officer' => $selected_officer,
            'officer_modules' => $officer_modules,
            'modules' => $modules,
            //FOR DUMMY VARIABLES
            'user_name' => "Juan Carlo D.R. Valencia",
            'user_picture' => "images/user/jc.png",
            'user_access' => "Administrator"
        );
        $this->load->view("dashboard/includes/header", $data);
        $this->load->view("admin_nav/navheader");
        $this->load->view("manage_officer/manage_modules.php");
        $this->load->view("dashboard/includes/footer");
    }
    public function add_modules_exec(){
        $officer = $this->ManageUsers_model->get_users("user", array("user_id" => $this->uri->segment(3), "user_access" => "Subadmin"))[0];;
        $officer_module_access = $this->ManageOfficer_model->get_officer_modules(array("module_access.user_id" => $this->uri->segment(3)));
        $officer_module_id = array();
        for($i = 0; $i < sizeof($officer_module_access); $i++){
            if($officer_module_access[0] == NULL){
                break;
            }else{
                array_push($officer_module_id, $officer_module_access[$i]->module_id);
            }
        }
        if(empty($this->input->post("modules"))){
            // NO SELECTED MODULE. REMOVE ALL MODULES RELATED TO THIS OFFICER
            $this->ManageOfficer_model->remove_all_modules(array("module_access.user_id" => $this->uri->segment(3)));
        }else{
            $this->ManageOfficer_model->remove_all_modules(array("module_access.user_id" => $this->uri->segment(3)));
            $selected_modules = $this->input->post("modules");
            foreach($selected_modules as $selected_module){
                $data = array(
                    'user_id' => $this->uri->segment(3),
                    'module_id' => $selected_module
                );
                $this->ManageOfficer_model->add_module($data);
            }
        }
        $this->session->set_flashdata("module_update", "Successfully updated ".$officer->user_firstname." ".$officer->user_lastname."'s modules.");
        redirect(base_url()."ManageOfficer/manage_module");
    }
}