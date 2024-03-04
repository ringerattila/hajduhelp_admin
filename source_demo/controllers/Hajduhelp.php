<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Hajduhelp extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // saját config betöltése
        $this->config->load('hajduhelp');

        // Load form helper library
        $this->load->helper('form');

        // Load date helper library
        $this->load->helper('date');

        // Security helper - inputhoz - xss_clean
        $this->load->helper('security');

        // Load form validation library
        $this->load->library('form_validation');

        // Load form helper library
        $this->load->helper('hajduhelp');

        // Load database
        $this->load->model('hajduhelp_model');

        $this->load->library('Curl');

        $this->load->library('Googlemaps');

        // Időjárás 
        $this->load->library('Idojaras');
        // Load database
        $this->load->model('users_model');

        // Load email modul
        $this->load->library('email');
    }

    // ez a default CONTROLLER oldal    
    public function index()
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $this->load->view('templates/help_header', $data);
        $this->load->view('home', $data);
        $this->load->view('admin/admin_footer', $data);
    } // end of Index()

    // SZOCIÁLIS APP
    // ez a default menü oldal    
    public function social_index()
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['szocBasePath'] = base_url() . $this->config->config['szocialisPath'];

        $this->load->view('templates/help_header', $data);
        //$this->load->view('social/social_index_menu', $data);
        $this->load->view('social/social_index', $data);
        $this->load->view('templates/social_footer', $data);
    } // end of Index()

    // Mobil APP - adatszolgáltatás
    // ez a default menü oldal    
    public function app_human()
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['szocBasePath'] = base_url() . $this->config->config['szocialisPath'];

        $this->load->view('templates/help_header', $data);
        //$this->load->view('social/social_index_menu', $data);
        $this->load->view('social/social_index', $data);
        //   $this->load->view('templates/social_footer', $data);
    } // end of Index()

    // Mobil APP - adatszolgáltatás
    public function app_helpdesk($page)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['helpDeskPath'] = base_url() . $this->config->config['helpDeskPath'];

        $this->load->view('templates/help_header', $data);

        if ($page === 'greeting') {
            $this->load->view('helpdesk/helpdesk_index', $data);
        }

        $this->load->view('helpdesk/helpdesk_index', $data);
    } // end of app_helpdesk


    // ez a default menü oldal    
    public function social_greetings()
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $pageId = $this->config->config['social_greeting_page'];
        $datarec = $this->hajduhelp_model->social_admin_pages_read($pageId);
        $data['page'] = $datarec[0];
        $data['backhref'] = base_url() . 'index.php/social_index';

        $this->load->view('templates/help_header', $data);
        $this->load->view('social/social_top_menu', $data);
        $this->load->view('social/social_greetings', $data);
        $this->load->view('templates/social_footer', $data);
    } // end of function



    // ez a default menü oldal    
    public function social_providers()
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['szocBasePath'] = base_url() . $this->config->config['szocialisPath'];
        $data['providers'] = $this->hajduhelp_model->social_admin_get_active_providers();
        // $data['szocialisPath'] = $this->config->config['szocialisPath'];
        $data['jokerPic'] = $data['szocBasePath'] . $this->config->config['jokerPic'];
        $data['backhref'] = base_url() . 'index.php/social_index';

        $this->load->view('templates/help_header', $data);
        $this->load->view('social/social_top_menu', $data);
        $this->load->view('social/social_providers_list', $data);
        $this->load->view('templates/social_footer', $data);
    } // end of Index()

    // ez a default menü oldal    
    public function social_documents()
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['documents'] = $this->hajduhelp_model->social_documents_lista();
        $data['providers'] = $this->hajduhelp_model->social_admin_get_active_providers();
        $data['backhref'] = base_url() . 'index.php/social_index';
        $data['szocBasePath'] = base_url() . $this->config->config['szocialisPath'];

        $this->load->view('templates/help_header', $data);
        $this->load->view('social/social_top_menu', $data);
        $this->load->view('social/social_documents_list', $data);
        $this->load->view('templates/social_footer', $data);
    } // end of Index()

    // ez a 
    public function social_services()
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['listservices'] = $this->hajduhelp_model->social_listservices_lista();
        $data['bindservices'] = $this->hajduhelp_model->social_bindservices_lista();
        $data['szocBasePath'] = base_url() . $this->config->config['szocialisPath'];
        $data['backhref'] = base_url() . 'index.php/social_index';
        $this->load->view('templates/help_header', $data);
        $this->load->view('social/social_top_menu', $data);
        $this->load->view('social/social_listservices_list', $data);
        $this->load->view('templates/social_footer', $data);
    } // end of Index()



    // egy 
    public function social_services_show($servId)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $datarec = $this->hajduhelp_model->social_services_read($servId);
        $data['service'] = $datarec[0];
        $provId = $data['service']['provid'];
        $datarec = $this->hajduhelp_model->social_admin_providers_read($provId);
        $data['provider'] = $datarec[0];
        $data['pageheading'] = ' Szolgáltatás ismertetése';
        $data['backhref'] = base_url() . 'index.php/social_services';

        $this->load->view('templates/help_header', $data);
        $this->load->view('social/social_top_menu', $data);
        $this->load->view('social/social_services_show', $data);
        $this->load->view('templates/social_footer', $data);
    } // end of function




    // ez a default menü oldal    
    public function social_maps()
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['backhref'] = base_url() . 'index.php/social_index';
        $data['szocBasePath'] = base_url() . $this->config->config['szocialisPath'];
        $data['providers'] = $this->hajduhelp_model->social_admin_get_active_providers();
        // $data['szocialisPath'] = $this->config->config['szocialisPath'];
        $data['jokerPic'] = $data['szocBasePath'] . $this->config->config['jokerPic'];

        $provId = 112;
        $datarec = $this->hajduhelp_model->social_admin_providers_read($provId);
        $data['provider'] = $datarec[0];
        $data['coord']['lng'] = $data['provider']['lng'];
        $data['coord']['lat'] = $data['provider']['lat'];
        $this->load->view('templates/help_header', $data);
        $this->load->view('social/social_top_menu', $data);
        $this->load->view('social/social_maps_providers_list', $data);
        $this->load->view('templates/social_footer', $data);
    } // end of Index()





    // API kérésre - megmutatja a kívánt szolgháltató térképét
    public function social_show_map($provId)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['backhref'] = base_url() . 'index.php/social_maps';
        $data['szocBasePath'] = base_url() . $this->config->config['szocialisPath'];

        $datarec = $this->hajduhelp_model->social_admin_providers_read($provId);
        $data['provider'] = $datarec[0];
        $data['coord']['lng'] = $data['provider']['lng'];
        $data['coord']['lat'] = $data['provider']['lat'];
        $this->load->view('templates/help_header', $data);
        $this->load->view('social/social_maps_api', $data);
        //   $this->load->view('templates/social_footer', $data);
    } // end of Index()




    // megmutatja a kívánt szolgháltató térképét
    public function social_show_providers_maps($provId)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['backhref'] = base_url() . 'index.php/social_maps';
        $data['szocBasePath'] = base_url() . $this->config->config['szocialisPath'];
        //   $data['providers'] = $this->hajduhelp_model->social_admin_get_active_providers();
        // $data['szocialisPath'] = $this->config->config['szocialisPath'];
        //    $data['jokerPic'] = $data['szocBasePath'] . $this->config->config['jokerPic'];

        //    $provId = 112;
        $datarec = $this->hajduhelp_model->social_admin_providers_read($provId);
        $data['provider'] = $datarec[0];
        $data['coord']['lng'] = $data['provider']['lng'];
        $data['coord']['lat'] = $data['provider']['lat'];
        $this->load->view('templates/help_header', $data);
        $this->load->view('social/social_top_menu', $data);
        $this->load->view('social/social_maps', $data);
        $this->load->view('templates/social_footer', $data);
    } // end of Index()


    // Projekt bemutatása oldal
    public function social_about_project()
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $pageId = $pageId = $this->config->config['social_projekt_page']; // About projekt oldal azonosítója
        $datarec = $this->hajduhelp_model->social_admin_pages_read($pageId);
        $data['page'] = $datarec[0];
        $data['backhref'] = base_url() . 'index.php/social_index';

        $this->load->view('templates/help_header', $data);
        $this->load->view('social/social_top_menu', $data);
        $this->load->view('social/social_about_project', $data);
        $this->load->view('templates/social_footer', $data);
    } // end of function


    // egy szolgáltató adata
    public function social_provider_card($provId)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $datarec = $this->hajduhelp_model->social_admin_providers_read($provId);
        $data['provider'] = $datarec[0];
        $data['services'] = $this->hajduhelp_model->social_providers_services_list($provId);
        $data['pageheading'] = ' Szolgáltató adatlapja';
        $data['backhref'] = base_url() . 'index.php/social_providers';

        $this->load->view('templates/help_header', $data);
        $this->load->view('social/social_top_menu', $data);
        $this->load->view('social/social_provider_card', $data);
        $this->load->view('templates/social_footer', $data);
    } // end of function


    // egy szolgáltató adata
    public function social_documents_send($docId)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $datarec = $this->hajduhelp_model->social_admin_documents_read($docId);
        $data['document'] = $datarec[0];

        // Megnézzük, hogy a Mégsem-et nyomták-e
        $mybutton = $this->input->post('btn_cancel');
        if ($mybutton === 'cancel') {
            redirect('social_documents');
        }
        // Megnézzük, hogy a Küldés-t nyomták-e
        $mybutton = $this->input->post('btn_submit');
        if ($mybutton === 'ok') {  // ha van, akkor adattal jön a form, lekezeljük

            // levéküldés

            $maildata['email_from_address'] = $this->config->config['maildata']['email_from_address'];
            $maildata['email_from_text'] = $this->config->config['maildata']['email_from_text'];
            $maildata['email_reply_to'] = $this->config->config['maildata']['email_reply_to'];
            $maildata['email_html_header'] = $this->config->config['maildata']['email_html_header'];

            //    $maildata['mykod'] = $mykod;
            $maildata['subject'] = 'Szociális dokumentum küldése';
            //  $maildata['keresztnev'] = $adat['keresztnev'];
            $maildata['address'] = $this->input->post('email');
            //   $maildata['tipus'] = 'kupon';                        
            $maildata['doctitle'] = $data['document']['doctitle'];
            $maildata['web'] = $data['document']['web'];
            $maildata['docfilename'] = $this->config->config['pathToSocialDoc'] .  $data['document']['folder'] . '/nyomtatvany/' . $data['document']['docfilename'];
            $maildata['provname'] = $data['document']['name'];

            $this->hajduhelp_mail($maildata);

            //    $kadat['mess'] = $maildata['address'];
            //    $kadat['type'] = 'fel_pizza';
            //    $kadat['timestamp'] = date('Y-m-d H:i:s'); // now()
            // naplózzuk a kupon kiküldést
            //    $result = $this->pizzavia_model->kuponlog_insert($kadat); 


            // elküldtük! üzenet
            redirect('social_documents');
        }

        $data['pageheading'] = ' Dokumentum küldése';
        $data['backhref'] = base_url() . 'index.php/social_documents';

        $this->load->view('templates/help_header', $data);
        $this->load->view('social/social_top_menu', $data);
        $this->load->view('social/social_documents_send', $data);
        $this->load->view('templates/social_footer', $data);
    } // end of function


    // HELPDESK APP
    // ez a default menü oldal    
    public function helpdesk_index()
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['helpDeskPath'] = base_url() . $this->config->config['helpDeskPath'];

        $this->load->view('templates/help_header', $data);
        $this->load->view('helpdesk/helpdesk_index', $data);
        $this->load->view('templates/helpdesk_footer', $data);
    } // end of function

    // ez a default menü oldal    
    public function helpdesk_greetings($apptype)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $pageId = $this->config->config['helpdesk_greeting_page'];
        $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
        $data['page'] = $datarec[0];
        $data['backhref'] = base_url() . 'index.php/helpdesk_index';

        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('helpdesk/helpdesk_top_menu', $data);
        }
        $this->load->view('helpdesk/helpdesk_greetings', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/helpdesk_footer', $data);
        }
    } // end of function



    public function helpdesk_onkormanyzat($apptype)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $pageId = $this->config->config['helpdesk_onkormanyzat_page'];
        $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
        $data['page'] = $datarec[0];
        $data['backhref'] = base_url() . 'index.php/helpdesk_index';

        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('helpdesk/helpdesk_top_menu', $data);
        }
        $this->load->view('helpdesk/helpdesk_onkormanyzat', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/helpdesk_footer', $data);
        }
    } // end of function


    public function helpdesk_kormanyablak($apptype)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $pageId = $this->config->config['helpdesk_kormanyablak_page'];
        $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
        $data['page'] = $datarec[0];
        $data['backhref'] = base_url() . 'index.php/helpdesk_index';

        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('helpdesk/helpdesk_top_menu', $data);
        }
        $this->load->view('helpdesk/helpdesk_kormanyablak', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/helpdesk_footer', $data);
        }
    } // end of function

    public function helpdesk_kormanyablak_page($apptype, $hpage)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $pageId = $this->config->config['helpdesk_kormanyablak_page'];
        $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
        $data['page'] = $datarec[0];
        $data['backhref'] = base_url() . 'index.php/helpdesk_index';

        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('helpdesk/helpdesk_top_menu', $data);
        }

        switch ($hpage) {
            case 'adatlap':
                $pageId = $this->config->config['helpdesk_kormanyablak_adatlap_page'];
                $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
                $data['page'] = $datarec[0];
                break;

            case 'azonnali':
                $pageId = $this->config->config['helpdesk_kormanyablak_azonnali_page'];
                $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
                $data['page'] = $datarec[0];
                break;

            case 'sajat':
                $pageId = $this->config->config['helpdesk_kormanyablak_sajat_page'];
                $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
                $data['page'] = $datarec[0];
                break;

            case 'kiegeszito':
                $pageId = $this->config->config['helpdesk_kormanyablak_kiegeszito_page'];
                $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
                $data['page'] = $datarec[0];
                break;

            case 'idopont':
                $pageId = $this->config->config['helpdesk_kormanyablak_kiegeszito_page'];
                $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
                $data['page'] = $datarec[0];
                break;
        }

        $this->load->view('helpdesk/helpdesk_kormanyablak_page', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/helpdesk_footer', $data);
        }
    } // end of function


    public function helpdesk_onkormanyzat_page($apptype, $hpage)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        //$pageId = $this->config->config['helpdesk_kormanyablak_page']; 
        //$datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
        //$data['page'] = $datarec[0];
        $data['backhref'] = base_url() . 'index.php/helpdesk_index';

        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('helpdesk/helpdesk_top_menu', $data);
        }

        switch ($hpage) {
            case 'adatlap':
                $pageId = $this->config->config['helpdesk_onkormanyzat_adatlap_page'];
                $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
                $data['page'] = $datarec[0];
                break;

            case 'telefon':
                //  $pageId = $this->config->config['helpdesk_onkormanyzat_telefon_page']; 
                //  $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
                //  $data['page'] = $datarec[0];
                redirect('helpdesk_telefonkonyv/web');
                break;

            case 'gazdalkodasi':
                $pageId = $this->config->config['helpdesk_onkormanyzat_gazdalkodasi_page'];
                $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
                $data['page'] = $datarec[0];
                break;

            case 'varos':
                $pageId = $this->config->config['helpdesk_onkormanyzat_varos_page'];
                $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
                $data['page'] = $datarec[0];
                break;

            case 'palyazat':
                $pageId = $this->config->config['helpdesk_onkormanyzat_palyazat_page'];
                $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
                $data['page'] = $datarec[0];
                break;

            case 'jogi':
                $pageId = $this->config->config['helpdesk_onkormanyzat_jogi_page'];
                $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
                $data['page'] = $datarec[0];
                break;

            case 'hatosagi':
                $pageId = $this->config->config['helpdesk_onkormanyzat_hatosagi_page'];
                $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
                $data['page'] = $datarec[0];
                break;
        }

        $this->load->view('helpdesk/helpdesk_kormanyablak_page', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/helpdesk_footer', $data);
        }
    } // end of function



    // Projekt bemutatása oldal
    public function helpdesk_about_project($apptype)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $pageId = $pageId = $this->config->config['helpdesk_projekt_page']; // About projekt oldal azonosítója
        $datarec = $this->hajduhelp_model->helpdesk_admin_pages_read($pageId);
        $data['page'] = $datarec[0];
        $data['backhref'] = base_url() . 'index.php/helpdesk_index';

        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('helpdesk/helpdesk_top_menu', $data);
        }
        $this->load->view('helpdesk/helpdesk_about_project', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/helpdesk_footer', $data);
        }
    } // end of function


    public function helpdesk_ugyek($apptype)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['listugyek'] = $this->hajduhelp_model->helpdesk_ugyek_lista();
        //  $data['bindservices'] = $this->hajduhelp_model->social_bindservices_lista();
        $data['helpDeskPath'] = base_url() . $this->config->config['helpDeskPath'];
        $data['backhref'] = base_url() . 'index.php/helpdesk_index';
        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('helpdesk/helpdesk_top_menu', $data);
        }
        $this->load->view('helpdesk/helpdesk_ugyek_list', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/helpdesk_footer', $data);
        }
    } // end of Index()


    // MobilAPP + WEB is használja
    public function helpdesk_ugylap($apptype, $ugyid)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $datarec = $this->hajduhelp_model->helpdesk_ugyek_read($ugyid);
        $data['ugylap'] = $datarec[0];
        //  $data['bindservices'] = $this->hajduhelp_model->social_bindservices_lista();
        $data['helpDeskPath'] = base_url() . $this->config->config['helpDeskPath'];
        $data['backhref'] = base_url() . 'index.php/helpdesk_index';
        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('helpdesk/helpdesk_top_menu', $data);
        }
        $this->load->view('helpdesk/helpdesk_ugylap', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/helpdesk_footer', $data);
        }
    }

    // csak a WEB használja
    public function helpdesk_documents($apptype)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $filtered = "no";
        $filter = "";
        $data['documents'] = $this->hajduhelp_model->helpdesk_documents_lista($filtered, $filter);
        //$data['providers'] = $this->hajduhelp_model->social_admin_get_active_providers();
        $data['backhref'] = base_url() . 'index.php/helpdesk_index';
        $data['helpDeskPath'] = base_url() . $this->config->config['helpDeskPath'];

        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('helpdesk/helpdesk_top_menu', $data);
        }
        $this->load->view('helpdesk/helpdesk_documents_list', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/helpdesk_footer', $data);
        }
    } // end of Index()

    // MobilAPP + WEB is használja
    // Egy dokumentum adatlapja
    public function helpdesk_documents_card($apptype, $docid)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $datarec = $this->hajduhelp_model->helpdesk_documents_read($docid);
        $data['document'] = $datarec[0];
        //  $data['bindservices'] = $this->hajduhelp_model->social_bindservices_lista();
        $data['helpDeskPath'] = base_url() . $this->config->config['helpDeskPath'];
        $data['backhref'] = base_url() . 'index.php/helpdesk_index';
        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('helpdesk/helpdesk_top_menu', $data);
        }
        $this->load->view('helpdesk/helpdesk_documents_card', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/helpdesk_footer', $data);
        }
    } // Function END - helpdesk_documents_card



    // csak a WEB használja
    public function helpdesk_telefonkonyv($apptype)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        //$filtered = "no";
        //$filter = "";
        $data['telefonkonyv'] = $this->hajduhelp_model->helpdesk_telefonkonyv_lista();
        //$data['providers'] = $this->hajduhelp_model->social_admin_get_active_providers();
        $data['backhref'] = base_url() . 'index.php/helpdesk_index';
        $data['helpDeskPath'] = base_url() . $this->config->config['helpDeskPath'];

        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('helpdesk/helpdesk_top_menu', $data);
        }
        $this->load->view('helpdesk/helpdesk_telefonkonyv_list', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/helpdesk_footer', $data);
        }
    } // end of Index()



    // TRANSPORT APP
    // ez a default menü oldal    
    public function transport_index()
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();

        $data['base_url'] = base_url();
        $data['transportPath'] = base_url() . $this->config->config['transportPath'];

        $this->load->view('templates/help_header', $data);
        $this->load->view('transport/transport_index', $data);
        $this->load->view('templates/transport_footer', $data);
    } // end of function


    public function transport_idojaras($apptype)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['backhref'] = base_url() . 'index.php/transport_index';
        $data['transportPath'] = base_url() . $this->config->config['transportPath'];

        //idokep.hu
        //  $data['idokep'] = $this->transport_idojaras_curl();
        //   $data['idokep'] = 'időkép';

        //  $this->today_filename();

        // print $idojaras;
        $idojarasObject = new Idojaras;

        $idojaras = $idojarasObject->getIdojaras();

        $data['idojaras'] = $idojaras;

        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('transport/transport_top_menu', $data);
        }
        $this->load->view('transport/transport_idojaras', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/transport_footer', $data);
        }
    } // end of function

    public function transport_greetings($apptype)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['backhref'] = base_url() . 'index.php/transport_index';
        $data['transportPath'] = base_url() . $this->config->config['transportPath'];

        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('transport/transport_top_menu', $data);
        }
        $this->load->view('transport/transport_greetings', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/transport_footer', $data);
        }
    } // end of function

    public function transport_menetrend($apptype)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['backhref'] = base_url() . 'index.php/transport_index';
        $data['transportPath'] = base_url() . $this->config->config['transportPath'];

        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('transport/transport_top_menu', $data);
        }
        $this->load->view('transport/transport_menetrend', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/transport_footer', $data);
        }
    } // end of function

    public function transport_vekker($apptype)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['backhref'] = base_url() . 'index.php/transport_index';
        $data['transportPath'] = base_url() . $this->config->config['transportPath'];

        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('transport/transport_top_menu', $data);
        }
        $this->load->view('transport/transport_vekker', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/transport_footer', $data);
        }
    } // end of function

    public function transport_parkolo($apptype)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['backhref'] = base_url() . 'index.php/transport_index';
        $data['transportPath'] = base_url() . $this->config->config['transportPath'];


        $myLocation = $this->getMyLocation();
        $data['mylocation'] = $myLocation;

        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('transport/transport_top_menu', $data);
        }
        $this->load->view('transport/transport_parkolo', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/transport_footer', $data);
        }
    } // end of function

    public function transport_about_project($apptype)
    {
        $data['title'] = "Hajdú Help";
        $data['myversion'] = CI_VERSION;
        $data['base_url'] = base_url();
        $data['backhref'] = base_url() . 'index.php/transport_index';
        $data['transportPath'] = base_url() . $this->config->config['transportPath'];

        $this->load->view('templates/help_header', $data);
        if ($apptype != 'app') {
            $this->load->view('transport/transport_top_menu', $data);
        }
        $this->load->view('transport/transport_about_project', $data);
        if ($apptype != 'app') {
            $this->load->view('templates/transport_footer', $data);
        }
    } // end of function




    // Email küldése 
    public function doc_send_email()
    {
        // Az email állandó paramétereinek összeállítása
        $maildata['email_from_address'] = $this->config->config['maildata']['email_from_address'];
        $maildata['email_from_text'] = $this->config->config['maildata']['email_from_text'];
        $maildata['email_reply_to'] = $this->config->config['maildata']['email_reply_to'];
        $maildata['email_html_header'] = $this->config->config['maildata']['email_html_header'];

        // POST változók, nem JSON!!!
        if (isset($_POST["myrequest"])) {
            $myrequest = $this->security->xss_clean($_POST["myrequest"]);
        }
        // if (isset($_POST["apptype"])) { $apptype = $this->security->xss_clean($_POST["apptype"]); }
        //  if (isset($_POST["docid"])) { $docid = $this->security->xss_clean($_POST["docid"]); }
        //  if (isset($_POST["email"])) { $emailaddress = $this->security->xss_clean($_POST["email"]); }

        if (!isset($myrequest))  // ha nincs értéke, akkor távoli kérés
        { // igazi kérelem, nem a tesztfüggvényből
            $post = json_decode($this->security->xss_clean($this->input->raw_input_stream));

            $emailaddress = $post->{'emailaddress'};
            //  $docid = $post->{'docid'}; 
            $maildata['address'] = $emailaddress;

            $docid = $post->{'docid'};
            $apptype = $post->{'apptype'};

            if ($apptype == 'helpdesk') { // helpdesk apptól jön a kérés
                $datarec = $this->hajduhelp_model->helpdesk_documents_read($docid);
                $document = $datarec[0];
                $maildata['email_from_text'] = 'HB Helpdesk applikáció';  // ezt írja ki a levelezőkliens Feladóként

                $maildata['subject'] = 'Dokumentum küldése';
                $maildata['doctitle'] = $document['doctitle'];
                $maildata['web'] = $document['web'];
                $maildata['docfilename'] = $this->config->config['pathToHelpdeskDoc'] .  $document['folder']
                    . '/nyomtatvany/' . $document['docfilename'];
                $maildata['provname'] = $document['name'];
                // Levéltörzs összeállítása
                $maildata['body'] = $maildata['email_html_header'] . $maildata['address'] . '! </h2>';  // fejléc + név
                $maildata['body'] .=   '<div class="mailtext">A HB Helpdesk applikáció '
                    . ' kérésre ezt a csatolt dokumentumot küldi:</div>'
                    . '<h1>' . $maildata['doctitle'] . '</h1>'
                    . ' <div><p><br></p</div>'
                    . '<a href="' . $maildata['web'] . '">' . $maildata['provname'] . '</a>'
                    . '<br>DocId: ' . $document['docid'] . 'docPath: ' . $maildata['docfilename'] . '</body></html>';

                $this->hajduhelp_mail($maildata); // levél kiküldése

                $ackmessage = $document["doctitle"] . ' dokumentum elküldve.';
            }

            if ($apptype == 'social') { // human apptól jön a kérés
                $datarec = $this->hajduhelp_model->social_documents_getpath($docid);
                $document = $datarec[0];
                $maildata['email_from_text'] = 'HB Human applikáció';  // ezt írja ki a levelezőkliens Feladóként

                $maildata['subject'] = 'Dokumentum küldése';
                $maildata['doctitle'] = $document['doctitle'];
                $maildata['web'] = $document['web'];
                $maildata['docfilename'] = $this->config->config['pathToSocialDoc'] .  $document['folder']
                    . '/nyomtatvany/' . $document['docfilename'];
                $maildata['provname'] = $document['name'];
                // Levéltörzs összeállítása
                $maildata['body'] = $maildata['email_html_header'] . $maildata['address'] . '! </h2>';  // fejléc + név
                $maildata['body'] .=   '<div class="mailtext">A HB Human applikáció '
                    . ' kérésre ezt a csatolt dokumentumot küldi:</div>'
                    . '<h1>' . $maildata['doctitle'] . '</h1>'
                    . ' <div><p><br></p</div>'
                    . '<a href="' . $maildata['web'] . '">' . $maildata['provname'] . '</a></body></html>';
                $this->hajduhelp_mail($maildata); // levél kiküldése

                $ackmessage = $document["doctitle"] . ' dokumentum elküldve.';
            }
        }

        if (isset($myrequest)) { // teszt üzemmód
            if (isset($_POST["docid"])) {
                $docid = $this->security->xss_clean($_POST["docid"]);
            }
            if (isset($_POST["email"])) {
                $emailaddress = $this->security->xss_clean($_POST["email"]);
            }
            if (isset($_POST["apptype"])) {
                $apptype = $this->security->xss_clean($_POST["apptype"]);
            }
            $maildata['address'] = $emailaddress;
            $maildata['subject'] = 'HajdúHelp projekt teszt email';
            $maildata['email_from_text'] = 'Hajdúhelp projekt';  // ezt írja ki a levelezőkliens Feladóként

            $maildata['body'] = 'Hajdúhelp projekt teszt email.';  // teszt szöveg
            if ($apptype == 'helpdesk') { // helpdesk apptól jön a kérés
                if ($docid = -1) {
                    $docid = 109;
                }  // Teszt dokumentum
                $datarec = $this->hajduhelp_model->helpdesk_documents_read($docid);
                $document = $datarec[0];
                $maildata['docfilename'] = $this->config->config['pathToHelpdeskDoc'] .  $document['folder']
                    . '/nyomtatvany/' . $document['docfilename'];
            }
            if ($apptype == 'social') { // human apptól jön a kérés
                if ($docid = -1) {
                    $docid = 30;
                }  // Teszt dokumentum
                $datarec = $this->hajduhelp_model->social_admin_documents_read($docid);
                $document = $datarec[0];
                $maildata['docfilename'] = $this->config->config['pathToSocialDoc'] .  $document['folder']
                    . '/nyomtatvany/' . $document['docfilename'];
            }


            $this->hajduhelp_mail($maildata);
            $ackmessage = 'Teszt email kiküldve.';
        } // teszt mód vége

        $result = json_encode($ackmessage);
        echo $result;  // Json üzenetben nyugtázzuk az email küldési kérést.
    }   // END doc_send_mail FUNCTION

    public function hajduhelp_mail($maildata)
    {
        if (file_exists($maildata['docfilename'])) {
            $this->email->attach($maildata['docfilename']);
        } else { // nincs meg a csatolmány
            $maildata['body'] = 'Csatolmány nem található: ' . $maildata['docfilename'];
        }

        $result = $this->email
            ->from($maildata['email_from_address'], $maildata['email_from_text'])
            ->reply_to($maildata['email_reply_to'])    // Optional, an account where a human being reads.
            ->to($maildata['address'])
            ->subject($maildata['subject'])
            //  ->attach("/var/www/html/pizzavia/bc/barcode.jpg", "inline")
            ->message($maildata['body'])
            ->send();
        return $result;
    } // END hajduhelp_mail FUNCTION



    // Google Geolocation
    public function getMyLocation()
    {

        $goo = new Googlemaps;
        $coords = $goo->address2Coordinates('Hungary', 'Hajdúböszörmény', 'tizenhárom vértanú utca', '30');
        print('lat: ' . $coords["lat"] . ',  lng: ' . $coords["lng"]);

        $address = $goo->coordinates2Address($coords["lat"] + 1, $coords["lng"]);
        print('<br>Place ID: ' . $address["place_id"]);

        print_r($address);

        $myOrigin = '57+Árpád+utca+Hajdúböszörmény';
        $myDestination = '2+Kinizsi+tér+Hajdúböszörmény';
        $coords = $goo->directions($myOrigin, $myDestination, 'address', 'transit');


        return $address;
    }
}
