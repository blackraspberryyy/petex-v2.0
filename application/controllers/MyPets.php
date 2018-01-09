<?php

class MyPets extends CI_Controller {

    function __construct() {
        parent::__construct();
        //---> MODELS HERE!
        $this->load->model('MyPets_model');
        //---> LIBRARIES HERE!
        //---> SESSIONS HERE!
        if ($this->session->has_userdata('isloggedin') == FALSE) {
            //user is not yet logged in
            $this->session->set_userdata("err_4", "Login First!");
            redirect(base_url() . 'main/');
        } else {
            $current_user = $this->session->userdata("current_user");
            if ($this->session->userdata("user_access") == "user") {
                //USER!
                //Do nothing
            } else if ($this->session->userdata("user_access") == "subadmin") {
                //SUBADMIN!
                $this->session->set_flashdata("err_5", "You are currently logged in as " . $current_user->user_firstname . " " . $current_user->user_lastname);
                redirect(base_url() . "SubadminDashboard");
            } else if ($this->session->userdata("user_access") == "admin") {
                //ADMIN!
                $this->session->set_flashdata("err_5", "You are currently logged in as " . $current_user->admin_firstname . " " . $current_user->admin_lastname);
                redirect(base_url() . "AdminDashboard");
            }
        }
    }

    //------------ FUNCTIONS ----------------
    function getTextBetween($start, $end, $text) {
        $text = str_replace(" ", "", $text);
        // explode the start string
        $holder = explode($start, $text, 2);
        $first_strip = end($holder);

        // explode the end string
        $final_strip = explode($end, $first_strip)[0];
        return $final_strip;
    }

    public function index() {
        $current_user = $this->ManageUsers_model->get_users("user", array("user_id" => $this->session->userdata("userid")))[0];

        $data = array(
            'title' => "My Pets | " . $current_user->user_firstname . " " . $current_user->user_lastname,
            //NAV INFO
            'user_name' => $current_user->user_firstname . " " . $current_user->user_lastname,
            'user_picture' => $current_user->user_picture,
            'user_access' => "User"
        );
        $this->load->view("my_pets/includes/header", $data);
        $this->load->view("user_nav/navheader");
        $this->load->view("my_pets/main");
        $this->load->view("my_pets/includes/footer");
    }

    public function edit_details_exec() {
        $animal_id = $this->uri->segment(3);
        $this->session->set_userdata("animal_id", $animal_id);
        redirect(base_url() . "MyPets/edit_details");
    }

    public function edit_details() {
        $animal_id = $this->session->userdata("animal_id");
        $current_animal = $this->PetManagement_model->get_animal_info(array("pet_id" => $animal_id))[0];
        $current_user = $this->ManageUsers_model->get_users("user", array("user_id" => $this->session->userdata("userid")))[0];
        $data = array(
            'title' => "Edit My Pet | " . $current_user->user_firstname . " " . $current_user->user_lastname,
            'animal' => $current_animal,
            //NAV INFO
            'user_name' => $current_user->user_firstname . " " . $current_user->user_lastname,
            'user_picture' => $current_user->user_picture,
            'user_access' => "User"
        );
        $this->load->view("my_pets/includes/header", $data);
        $this->load->view("user_nav/navheader");
        $this->load->view("my_pets/mypet_edit_detail");
        $this->load->view("my_pets/includes/footer");
    }

    public function edit_details_submit() {
        $animal = $this->PetManagement_model->get_animal_info(array("pet_id" => $this->uri->segment(3)))[0];

        $config['upload_path'] = './images/animal/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['file_ext_tolower'] = true;
        $config['max_size'] = 5120;
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);

        if (!empty($_FILES["pet_picture"]["name"])) {
            if ($this->upload->do_upload('pet_picture')) {
                $imagePath = "images/animal/" . $this->upload->data("file_name");
                unlink($animal->pet_picture);
            } else {
                echo $this->upload->display_errors();
                $this->session->set_flashdata("uploading_error", "Please make sure that the max size is 5MB the types may only be .jpg, .jpeg, .gif, .png");
            }
        } else {
            //DO METHOD WITHOUT PICTURE PROVIDED
            if ($animal->pet_picture == "images/animal/dog_temp_pic.png" || $animal->pet_picture == "images/animal/cat_temp_pic.png") {
                if ($this->input->post('pet_specie') == "canine") {
                    $imagePath = "images/animal/dog_temp_pic.png";
                } else {
                    $imagePath = "images/animal/cat_temp_pic.png";
                }
            } else {
                $imagePath = $animal->pet_picture;
            }
        }
        $pet = array(
            'pet_name' => $this->input->post("pet_name"),
            'pet_description' => $this->input->post("pet_description"),
            'pet_picture' => $imagePath,
            'pet_video' => $this->getTextBetween('src="', '"', $this->input->post("pet_video")),
            'pet_updated_at' => time()
        );
        if ($this->MyPets_model->update_animal_record($pet, array("pet_id" => $animal->pet_id))) {
            //SUCCESS
            $this->session->set_flashdata("uploading_success", "Successfully update the record of " . $animal->pet_name);
        } else {
            $this->session->set_flashdata("uploading_fail2", $animal->pet_name . " seems to not exist in the database.");
        }
        redirect(base_url() . "MyPets/");
    }

}
