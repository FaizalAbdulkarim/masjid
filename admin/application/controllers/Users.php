<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Controller
{
    function  __construct() {
        parent::__construct();
        $this->load->model('user');
    }
    
    function add(){

       
        $this->form_validation->set_rules('title', 'Title','required');
        $this->form_validation->set_rules('content', 'Content','required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){
            $this->load->view('common/header');
            $this->load->view('users/add');
            $this->load->view('common/footer');
        }
       
        else{
        
            if($this->input->post('userSubmit'))
            {
                
                //Check whether user upload picture
                if(!empty($_FILES['picture']['name']))
                {
                    $config['upload_path'] = 'uploads/images/';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['max_size'] = '0';
                    $config['file_name'] = $_FILES['picture']['name'];
                    
                    //Load upload library and initialize configuration
                    $this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    
                    if($this->upload->do_upload('picture'))
                    {
                        $uploadData = $this->upload->data();
                        $picture = $uploadData['file_name'];
                    }else
                    {
                        $picture = '';
                    }
                }else{
                    $picture = '';
                }
                

                //Prepare array of user data
                $userData = array(
                    'title'     => $this->input->post('title'),
                    'slug'      => url_title($this->input->post('title')),
                    'content'   => $this->input->post('content'),
                    'picture'   => $picture
                );
                
                //Pass user data to model
                $insertUserData = $this->user->insert($userData);
                
                
                //Storing insertion status message.
                if($insertUserData){
                    
                    $this->session->set_flashdata('success_msg', '<div class="alert alert-success">Data have been added successfully.</div>');

                }else{
                    // $this->session->set_flashdata('error_msg', 'Some problems occured, please try again.');

                }
            }
                $this->load->view('common/header');
                $this->load->view('users/add');
        }

    //     if($this->input->post('userSubmit'))
    //     {
            
    //         //Check whether user upload picture
    //         if(!empty($_FILES['picture']['name']))
    //         {
    //             $config['upload_path'] = 'uploads/images/';
    //             $config['allowed_types'] = 'jpg|jpeg|png|gif';
    //             $config['max_size'] = '0';
    //             $config['file_name'] = $_FILES['picture']['name'];
                
    //             //Load upload library and initialize configuration
    //             $this->load->library('upload',$config);
    //             $this->upload->initialize($config);
                
    //             if($this->upload->do_upload('picture'))
    //             {
    //                 $uploadData = $this->upload->data();
    //                 $picture = $uploadData['file_name'];
    //             }else
    //             {
    //                 $picture = '';
    //             }
    //         }else{
    //             $picture = '';
    //         }
            

    //         //Prepare array of user data
    //         $userData = array(
    //             'title'     => $this->input->post('title'),
    //             'slug'      => url_title($this->input->post('title')),
    //             'content'   => $this->input->post('content'),
    //             'picture'   => $picture
    //         );
            
    //         //Pass user data to model
    //         $insertUserData = $this->user->insert($userData);
            
            
    //         //Storing insertion status message.
    //         if($insertUserData){
                
    //             $this->session->set_flashdata('success_msg', 'User data have been added successfully.');
    //         }else{
    //             // $this->session->set_flashdata('error_msg', 'Some problems occured, please try again.');

    //         }
    //     }
        // //Form for adding user data
        // $this->load->view('common/header');
        // $this->load->view('users/add');
    }
}