<?php if (!defined('BASEPATH')) exit('Közvetlen elérés letiltva!');

// class MObil_model extends CI_Model {
class Hajduhelp_Model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    //*****************************************************************************
    // HB HUMAN - SZOCIÁLIS APP 
    //*****************************************************************************
    // 
    // PROVIDERS SECTION
    // 
    function social_select_providers_lista()
    {
        $strsql = 'SELECT  provid, name, mygroup, cardtitle, active '
            . ' FROM social_providers '
            . ' ORDER BY listorder ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    } // end   


    // Visszaadja a szolgáltatók listát
    function social_providers_lista($SQLrec)
    {
        $SQL_pars = array(
            'str_keres' => $SQLrec['str_keres'],
            'search_fields' => array('hk.nev', 'hk.varos', 'hk.megjegyzes', 'hk.kapcsolattarto_nev'),   // ezekben a mezőkben keres
            'geptipus' => '',
            'having' => '',
            'orderby' => '',
            'ordertype' => '',
            'page' => NULL,
            'per_page' => NULL
        );

        // AZ SQL string első része ugyanaz mindekét esetben
        $SQL_str = 'SELECT  '
            . ' id, listorder, group, name'
            . ' FROM social_providers '; {  // SQL lekérés
            // paraméterek kiegészítése   
            $SQL_pars['geptipus'] = $SQLrec['type'];
            $SQL_pars['orderby'] = $SQLrec['orderby'];
            $SQL_pars['ordertype'] = $SQLrec['ordertype'];
            $SQL_pars['page'] = $SQLrec['page'];
            $SQL_pars['per_page'] = $SQLrec['per_page'];

            $strsql = '';  //$this->where_string($SQL_str, $SQL_pars); 
            $query = $this->db->query($strsql);
            $result['query'] = $query->result_array(); // a lekérés eredménytöbmje
            return $result;
        }
    } // end of function
    // 

    // Egy szolgáltató adatlapját adja vissza
    public function social_admin_providers_read($provId)
    {
        $condition = "provid =" . "'" . $provId . "'";
        $this->db->select('*');
        $this->db->from('social_providers');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function social_admin_providers_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('social_providers', $data);
        return true;
    }

    // Meglévő adatrekord módosítása
    public function social_admin_providers_update($data)
    {
        $provId = $data['provid'];
        $this->db->where('provid', $provId);
        $this->db->update('social_providers', $data);
    }


    // Törlés
    public function social_admin_providers_delete($provId)
    {
        $this->db->where('provid', $provId);
        $this->db->delete('social_providers');
    } // END social_admin_providers_delete FUNCTION


    // PROVIDERS - SZOLGÁLTATÓK 
    public function social_admin_get_active_providers()
    {
        $query = $this->db->query('SELECT * FROM social_providers '
            . ' WHERE active = "Y" ORDER BY listorder ASC');

        return $query->result_array();
    }

    // PROVIDERS - SZOLGÁLTATÓK 
    public function social_json_providers()
    {
        $query = $this->db->query('SELECT provid, listorder, mygroup, cardtitle, '
            . ' name, vezeto, irszam, varos, utca, mobil, telefon, email, '
            . ' callnumber, facebook, web, folder, indexpic, szoveg, lng, lat '
            . ' FROM social_providers '
            . ' WHERE active = "Y" ORDER BY listorder ASC');

        return $query->result_array();
    }


    // Egy szolgáltatóhoz tartozó szolgáltatásokat adja vissza
    public function social_providers_services_list($provId)
    {
        $condition = "provid =" . "'" . $provId . "'";
        $this->db->select('*');
        $this->db->from('social_services');
        $this->db->where($condition);
        $this->db->order_by('listorder ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // END OF PROVIDERS SECTION

    //*************************************************************************
    //// DOCUMENTS SECTION
    // 
    function social_select_documents_lista()
    {
        $strsql = 'SELECT  dc.docid as docid, pr.provid as provid, dc.listorder, dc.doctitle as doctitle, docfilename, dc.active '
            . ' FROM social_documents dc '
            . ' LEFT OUTER JOIN social_providers pr ON pr.provid=dc.provid '
            . ' ORDER BY pr.provid, dc.listorder ASC';

        //   $strsql ='SELECT  docid, provid, listorder, doctitle, docpath, active '
        //           . ' FROM documents '
        //	    . ' ORDER BY listorder ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }

    function social_documents_lista()
    {
        $strsql = 'SELECT  dc.docid as docid, pr.provid as provid, dc.listorder, dc.doctitle as doctitle, '
            . 'docfilename, dc.active, pr.folder as folder '
            . ' FROM social_documents dc '
            . ' LEFT OUTER JOIN social_providers pr ON pr.provid=dc.provid '
            . ' ORDER BY pr.provid, dc.listorder ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }


    // Visszaadja a szolgáltatók listát
    function documents_lista($SQLrec)
    {
        $SQL_pars = array(
            'str_keres' => $SQLrec['str_keres'],
            'search_fields' => array('hk.nev', 'hk.varos', 'hk.megjegyzes', 'hk.kapcsolattarto_nev'),   // ezekben a mezőkben keres
            'geptipus' => '',
            'having' => '',
            'orderby' => '',
            'ordertype' => '',
            'page' => NULL,
            'per_page' => NULL
        );

        // AZ SQL string első része ugyanaz mindekét esetben
        $SQL_str = 'SELECT  '
            . ' id, listorder, group, name'
            . ' FROM social_providers '; {  // SQL lekérés
            // paraméterek kiegészítése   
            $SQL_pars['geptipus'] = $SQLrec['type'];
            $SQL_pars['orderby'] = $SQLrec['orderby'];
            $SQL_pars['ordertype'] = $SQLrec['ordertype'];
            $SQL_pars['page'] = $SQLrec['page'];
            $SQL_pars['per_page'] = $SQLrec['per_page'];

            $strsql = ''; // $this->where_string($SQL_str, $SQL_pars); 
            $query = $this->db->query($strsql);
            $result['query'] = $query->result_array(); // a lekérés eredménytöbmje
            return $result;
        }
    } // end of function
    // 

    // 
    public function social_admin_documents_read($docId)
    {
        $strsql = 'SELECT  dc.docid as docid, pr.provid as provid, dc.listorder, dc.doctitle as doctitle, docfilename, '
            . 'dc.active, pr.folder as folder, pr.web as web, pr.name as name '
            . ' FROM social_documents dc '
            . ' LEFT OUTER JOIN social_providers pr ON pr.provid=dc.provid '
            . ' WHERE dc.docid="' . $docId . '" LIMIT 1';

        $query = $this->db->query($strsql);
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    } // END social_admin_documents_read FUNCTION

    public function social_admin_documents_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('social_documents', $data);
        return true;
    }

    // Meglévő adatrekord módosítása
    public function social_admin_documents_update($data)
    {
        $docId = $data['docid'];
        $this->db->where('docid', $docId);
        $this->db->update('social_documents', $data);
    }

    // 
    public function social_get_active_documents()
    {
        $query = $this->db->query('SELECT * FROM social_documents '
            . ' WHERE active = "Y" ORDER BY listorder ASC');

        return $query->result_array();
    }



    // Email küldéshez útvonal
    public function social_documents_getpath($docid)
    {
        $strsql = 'SELECT  dc.docid as docid, pr.provid as provid, dc.listorder, dc.doctitle as doctitle, docfilename, '
            . 'dc.active, pr.folder as folder, pr.web as web, pr.name as name '
            . ' FROM social_documents dc '
            . ' LEFT OUTER JOIN social_providers pr ON pr.provid=dc.provid '
            . ' WHERE dc.docid="' . $docid . '" LIMIT 1';

        $query = $this->db->query($strsql);
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }


    // END OF PROVIDERS SECTION


    //************************************************************************
    // PAGES ADMIN
    //************************************************************************

    // 
    function social_select_pages_lista()
    {
        $strsql = 'SELECT  * '
            . ' FROM social_pages '
            . ' ORDER BY pagetitle ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }


    // Egy adott oldal tartalmát adja vissza
    public function social_admin_pages_read($pageId)
    {
        $condition = "pageid =" . "'" . $pageId . "'";
        $this->db->select('*');
        $this->db->from('social_pages');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    // Meglévő adatrekord módosítása
    public function social_admin_pages_update($data)
    {
        $pageId = $data['pageid'];
        $this->db->where('pageid', $pageId);
        $this->db->update('social_pages', $data);
    }

    public function social_admin_pages_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('social_pages', $data);
        return true;
    }


    // ***************************************************************************
    // Social listservices SECTION
    // 
    function social_listservices_lista()
    {
        $strsql = 'SELECT  * '
            . ' FROM social_listservices '
            . ' ORDER BY prior DESC, listtitle ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }


    // Egy szolgáltató adatlapját adja vissza
    public function social_listservices_read($listId)
    {
        $condition = "listid =" . "'" . $listId . "'";
        $this->db->select('*');
        $this->db->from('social_listservices');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function social_listservices_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('social_listservices', $data);
        return true;
    }

    // Meglévő adatrekord módosítása
    public function social_listservices_update($data)
    {
        $listId = $data['listid'];
        $this->db->where('listid', $listId);
        $this->db->update('social_listservices', $data);
    }

    // PROVIDERS - SZOLGÁLTATÓK 
    public function social_listservices()
    {
        $query = $this->db->query('SELECT * FROM social_providers '
            . ' WHERE active = "Y" ORDER BY listorder ASC');

        return $query->result_array();
    }
    // END OF LISTSERVICES SECTION


    //*****************************************************************************
    // Social Services Section

    function social_bindservices_lista()
    {
        $strsql = 'SELECT  bs.bindid as bindid, bs.listid as listid, ls.listtitle as listtitle, bs.provid as provid, '
            . ' bs.servid as servid, bs.bindorder, pr.name as provname, ss.servtitle as servtitle '
            . ' FROM social_bindservices bs '
            . ' LEFT OUTER JOIN social_providers pr ON pr.provid = bs.provid '
            . ' LEFT OUTER JOIN social_listservices ls ON ls.listid = bs.listid '
            . ' LEFT OUTER JOIN social_services ss ON ss.servid = bs.servid '
            . ' ORDER BY bs.listid, bs.provid, bs.bindorder ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }

    // ***************************************************************************
    // SZOLGÁLTATÁSOK kezelése
    // 
    function social_services_lista()
    {
        $strsql = 'SELECT  ss.*, sp.name as provname '
            . ' FROM social_services ss'
            . ' LEFT OUTER JOIN social_providers sp ON ss.provid = sp.provid '
            . ' ORDER BY listorder ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }

    // Egy szolgáltató adatlapját adja vissza
    public function social_services_read($servId)
    {
        $strsql = 'SELECT  ss.servid as servid, pr.provid as provid, pr.name as provname, '
            . ' ss.listorder as listorder, ss.servtitle as servtitle, ss.servcontent as servcontent '
            . ' FROM social_services ss '
            . ' LEFT OUTER JOIN social_providers pr ON pr.provid=ss.provid '
            . ' WHERE ss.servid="' . $servId . '" LIMIT 1';

        $query = $this->db->query($strsql);
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function social_services_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('social_services', $data);
        return true;
    }

    // Meglévő adatrekord módosítása
    public function social_services_update($data)
    {
        $servId = $data['servid'];
        $this->db->where('servid', $servId);
        $this->db->update('social_services', $data);
    }

    // Adott beküldő beküldéseit töröljk
    public function social_listservices_delete($listId)
    {
        $this->db->where('listid', $listId);
        $this->db->delete('social_listservices');
    }


    // END of Services - functions


    // ***************************************************************************
    // BINDSERVICES táblák kezelése
    // 


    function sadmin_bindservices_lista()
    {
        $strsql = 'SELECT  bs.bindid as bindid, bs.listid as listid, ls.listtitle as listtitle, bs.provid as provid, '
            . ' bs.servid as servid, bs.bindorder, pr.name as provname, ss.servtitle as servtitle '
            . ' FROM social_bindservices bs '
            . ' LEFT OUTER JOIN social_providers pr ON pr.provid = bs.provid '
            . ' LEFT OUTER JOIN social_listservices ls ON ls.listid = bs.listid '
            . ' LEFT OUTER JOIN social_services ss ON ss.servid = bs.servid '
            . ' ORDER BY bs.listid, bs.provid, bs.bindorder ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }


    // EWgy adott hozzárendelés adatait adja vissza
    public function social_bindservices_read($bindId)
    {
        $strsql = 'SELECT  bs.bindid as bindid, pr.provid as provid, pr.name as provname, '
            . 'ss.listorder, ss.servtitle as servtitle, ss.servcontent as servcontent '
            . ' FROM social_bindservices bs '
            . ' LEFT OUTER JOIN social_providers pr ON pr.provid = bs.provid '
            . ' LEFT OUTER JOIN social_services ss ON ss.servid = bs.servid '
            . ' WHERE bs.bindid="' . $bindId . '" LIMIT 1';

        $query = $this->db->query($strsql);
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }


    public function social_bindservices_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('social_bindservices', $data);
        return true;
    }

    // Meglévő adatrekord módosítása
    public function social_bindservices_update($data)
    {
        $bindId = $data['bindid'];
        $this->db->where('bindid', $bindId);
        $this->db->update('social_bindservices', $data);
    }


    // Adott beküldő beküldéseit töröljk
    public function social_bindservices_delete($bindId)
    {
        $this->db->where('bindid', $bindId);
        $this->db->delete('social_bindservices');
    }


    // Megadott listához tartozó minden hozzárendelést töröl
    public function social_bindservices_delete_list($listId)
    {
        $this->db->where('listid', $listId);
        $this->db->delete('social_bindservices');
    }

    // END of Services - functions




    function social_check_services_lista()
    {
        $strsql = ' SELECT  ss.servid, ss.provid, ss.listorder, ss.servtitle, COUNT(bs.servid) '
            . ' as counts, sp.name as provname '
            . ' FROM social_services ss '
            . ' LEFT OUTER JOIN social_providers sp ON ss.provid = sp.provid '
            . '	LEFT OUTER JOIN social_bindservices bs ON ss.servid = bs.servid '
            . ' GROUP BY ss.servid ORDER BY ss.provid, listorder ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }


    // szolgáltatások ellenőrzése, hogy hozzá van-e valamihez rendelve
    function social_checkbind_lista()
    {
        $strsql = 'SELECT  bs.bindid as bindid, bs.listid as listid, ls.listtitle as listtitle, ss.provid as provid, '
            . ' ss.servid as servid, bs.bindorder, pr.name as provname, ss.servtitle as servtitle '
            . ' FROM social_services ss '
            . 'LEFT OUTER JOIN social_bindservices bs ON ss.servid = bs.servid '
            . ' LEFT OUTER JOIN social_providers pr ON pr.provid = ss.provid '
            . ' LEFT OUTER JOIN social_listservices ls ON ls.listid = bs.listid '
            . ' ORDER BY ss.servid, ls.listtitle ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }


    // HELPDESK ADMIN
    // 
    function helpdesk_select_pages_lista()
    {
        $strsql = 'SELECT  * '
            . ' FROM helpdesk_pages '
            . ' ORDER BY pagetitle ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }


    // Egy adott oldal tartalmát adja vissza
    public function helpdesk_admin_pages_read($pageId)
    {
        $condition = "pageid =" . "'" . $pageId . "'";
        $this->db->select('*');
        $this->db->from('helpdesk_pages');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    // Meglévő adatrekord módosítása
    public function helpdesk_admin_pages_update($data)
    {
        $pageId = $data['pageid'];
        $this->db->where('pageid', $pageId);
        $this->db->update('helpdesk_pages', $data);
    }


    public function helpdesk_admin_pages_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('helpdesk_pages', $data);
        return true;
    }


    // ***************************************************************************
    // ÜGYEK ADMIN START
    // Helpdesk ÜGYEK lista
    function helpdesk_ugyek_lista($filtered, $filter)
    {
        if ($filtered == 'no') {
            $strsql = 'SELECT  * '
                . ' FROM helpdesk_ugyek'
                . ' ORDER BY ugytitle ASC';
        } else {
            $strsql = 'SELECT  * '
                . ' FROM helpdesk_ugyek'
                . ' WHERE (ugytitle LIKE "%' . $filter . '%")'
                . ' ORDER BY ugytitle ASC';
        }
        $query = $this->db->query($strsql);
        return $query->result_array();
    } // END ugyek_lista FUNCTION


    // Egy adott ügy adatait adja vissza
    public function helpdesk_ugyek_read($ugyid)
    {

        $strsql = 'SELECT  ug.ugyid, ug.provid, ug.tipus, ug.ugytitle, pr.name, pr.varos, '
            . 'pr.irszam, pr.utca, pr.telefon, ug.listorder '
            . ' FROM helpdesk_ugyek ug '
            . ' LEFT OUTER JOIN helpdesk_providers pr ON pr.provid = ug.provid '
            //    . ' LEFT OUTER JOIN social_services ss ON ss.servid = bs.servid '
            . ' WHERE ug.ugyid="' . $ugyid . '" LIMIT 1';

        $query = $this->db->query($strsql);
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    } // END ugyek_read FUNCTION


    public function helpdesk_admin_ugyek_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('helpdesk_ugyek', $data);
        return true;
    }   // END ugyek_insert FUNCTION

    // Meglévő adatrekord módosítása
    public function helpdesk_admin_ugyek_update($data)
    {
        $ugyid = $data['ugyid'];
        $this->db->where('ugyid', $ugyid);
        $this->db->update('helpdesk_ugyek', $data);
    } // END ugyek_update FUNCTION


    // Törlés
    public function helpdesk_admin_ugyek_delete($ugyid)
    {
        $this->db->where('ugyid', $ugyid);
        $this->db->delete('helpdesk_ugyek');
    } // END ugyek_delete FUNCTION

    // ÜGYEK ADMIN SECTION END


    // ***************************************************************************
    // PROVIDERS ADMIN SECTION START
    // 
    function helpdesk_select_providers_lista()
    {
        $strsql = 'SELECT  * '
            . ' FROM helpdesk_providers '
            . ' ORDER BY listorder ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }

    // MOBILAPP RÉSZÉRE IS!!!
    function helpdesk_providers_lista()
    {
        $strsql = 'SELECT  * '
            . ' FROM helpdesk_providers '
            . ' ORDER BY listorder ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }


    // HELPDESK - SZOLGÁLTATÓK 
    public function helpdesk_admin_get_active_providers()
    {
        $query = $this->db->query('SELECT * FROM helpdesk_providers '
            . ' WHERE active = "Y" ORDER BY listorder ASC');
        return $query->result_array();
    }


    // Egy szolgáltató adatlapját adja vissza
    public function helpdesk_admin_providers_read($provId)
    {
        $condition = "provid =" . "'" . $provId . "'";
        $this->db->select('*');
        $this->db->from('helpdesk_providers');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function helpdesk_admin_providers_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('helpdesk_providers', $data);
        return true;
    }

    // Meglévő adatrekord módosítása
    public function helpdesk_admin_providers_update($data)
    {
        $provId = $data['provid'];
        $this->db->where('provid', $provId);
        $this->db->update('helpdesk_providers', $data);
    }


    // Törlés
    public function helpdesk_admin_providers_delete($provId)
    {
        $this->db->where('provid', $provId);
        $this->db->delete('helpdesk_providers');
    }

    // Helpdesk DOKUMENTUMOK lista MOBILAPP részére
    function helpdesk_documents_lista($filtered, $filter)
    {
        if ($filtered == 'no') {
            $strsql = 'SELECT  * '
                . ' FROM helpdesk_documents'
                . ' ORDER BY doctitle ASC';
        } else {
            $strsql = 'SELECT  * '
                . ' FROM helpdesk_documents'
                . ' WHERE (doctitle LIKE "%' . $filter . '%")'
                . ' ORDER BY doctitle ASC';
        }
        $query = $this->db->query($strsql);
        return $query->result_array();
    } // FUNCTION END - helpdesk_documents_lista


    function helpdesk_admin_documents_lista()
    {
        $strsql = 'SELECT  dc.docid as docid, pr.provid as provid, dc.listorder, dc.doctitle as doctitle, '
            . ' docfilename, dc.active, pr.folder as folder, tipus, pr.name as name, '
            . ' (SELECT count(docid) FROM helpdesk_bind_doc bd WHERE bd.docid=dc.docid) as binds'
            . ' FROM helpdesk_documents dc '
            . ' LEFT OUTER JOIN helpdesk_providers pr ON pr.provid=dc.provid '
            //       . ' LEFT OUTER JOIN helpdesk_bind_doc db ON db.docid=dc.docid '
            . ' ORDER BY pr.provid, dc.listorder ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }




    // Egy adott dokumentum adatait adja vissza
    public function helpdesk_documents_read($docid)
    {
        $strsql = 'SELECT  dc.docid as docid, dc.docfilename as docfilename, dc.provid, '
            . 'dc.tipus as tipus, dc.doctitle, pr.name, pr.varos, dc.listorder, dc.active, '
            . 'pr.irszam, pr.utca, pr.telefon, pr.folder, pr.web '
            . ' FROM helpdesk_documents dc '
            . ' LEFT OUTER JOIN helpdesk_providers pr ON pr.provid = dc.provid '
            //    . ' LEFT OUTER JOIN social_services ss ON ss.servid = bs.servid '
            . ' WHERE dc.docid="' . $docid . '" LIMIT 1';

        $query = $this->db->query($strsql);
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    } // END helpdesk_documents_read FUNCTION

    // Email küldéshez útvonal
    public function helpdesk_documents_getpath($docid)
    {
        $strsql = 'SELECT  dc.docid, dc.tipus, dc.doctitle, pr.name, pr.folder, '
            . 'pr.irszam, pr.utca, pr.telefon '
            . ' FROM helpdesk_documents dc '
            . ' LEFT OUTER JOIN helpdesk_providers pr ON pr.provid = dc.provid '
            //    . ' LEFT OUTER JOIN social_services ss ON ss.servid = bs.servid '
            . ' WHERE dc.docid="' . $docid . '" LIMIT 1';

        $query = $this->db->query($strsql);
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    // HELPDESK DOCUMENTS - insert
    public function helpdesk_admin_documents_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('helpdesk_documents', $data);
        return true;
    }

    // HELPDESK DOCUMENTS - update
    public function helpdesk_admin_documents_update($data)
    {
        $docid = $data['docid'];
        $this->db->where('docid', $docid);
        $this->db->update('helpdesk_documents', $data);
    }




    // MOBILAPP RÉSZÉRE IS!!!
    function helpdesk_bind_doc_lista()
    {
        $strsql = 'SELECT  hd.doctitle, hb.bindid, hb.docid, hb.ugyid '
            . ' FROM helpdesk_bind_doc hb '
            . ' LEFT OUTER JOIN helpdesk_documents hd on hd.docid = hb.docid '
            . ' ORDER BY bindorder ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    } // END helpdesk_bind_doc FUNCTION



    // HELPDESK BIND DOCUMENTS - insert
    public function helpdesk_bind_doc_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('helpdesk_bind_doc', $data);
        return true;
    }

    // HELPDESK BIND DOCUMENTS - update
    public function helpdesk_bind_doc_update($data)
    {
        $bindid = $data['bindid'];
        $this->db->where('bindid', $bindid);
        $this->db->update('helpdesk_bind_doc', $data);
    }


    // Adott id-jű ügy-dokumentum összerendelést töröljük
    public function helpdesk_bind_doc_delete($bindid)
    {
        $this->db->where('bindid', $bindid);
        $this->db->delete('helpdesk_bind_doc');
    }


    // ügy - dokumentum összerendelés, hogy hozzá van-e valamihez rendelve
    function helpdesk_checkbind_lista()
    {

        $strsql = 'SELECT hu.ugyid as ugyid, hu.ugytitle as ugytitle, 
            hu.provid as provid, hp.name as provname, 
          (SELECT COUNT(hb.bindid) FROM helpdesk_bind_doc hb WHERE hb.ugyid = hu.ugyid) as binds	
            FROM helpdesk_ugyek hu 
            LEFT OUTER JOIN helpdesk_bind_doc hb ON hu.ugyid = hb.ugyid 
            LEFT OUTER JOIN helpdesk_providers hp ON hp.provid = hu.provid  
            GROUP BY hu.ugyid
            ORDER BY provname, ugytitle ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }



    // HELPDESK TELEFONKÖNYV
    // 
    function helpdesk_telefonkonyv_lista()
    {
        $strsql = 'SELECT  * '
            . ' FROM helpdesk_telefonkonyv '
            . ' ORDER BY telorder ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }

    // A telefonkönyv egy rekordját adja vissza
    public function helpdesk_telefonkonyv_read($telId)
    {
        $condition = "telid =" . "'" . $telId . "'";
        $this->db->select('*');
        $this->db->from('helpdesk_telefonkonyv');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    // HELPDESK TELEFONKÖNYV - insert
    public function helpdesk_telefonkonyv_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('helpdesk_telefonkonyv', $data);
        return true;
    }


    // HELPDESK TELEFONKÖNYV - update
    public function helpdesk_telefonkonyv_update($data)
    {
        $telid = $data['telid'];
        $this->db->where('telid', $telid);
        $this->db->update('helpdesk_telefonkonyv', $data);
    }



    //**************************************************************************
    // TRANSPORT

    // Egy adott oldal tartalmát adja vissza
    public function transport_admin_pages_read($pageId)
    {
        $condition = "pageid =" . "'" . $pageId . "'";
        $this->db->select('*');
        $this->db->from('transport_pages');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    // busz menetrendek
    function transport_admin_menetrend_lista()
    {
        $strsql = 'SELECT  * '
            . ' FROM transport_menetrend '
            . ' ORDER BY menetrend_id ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }


    // 
    public function transport_menetrend_read($menetrend_id)
    {
        $strsql = 'SELECT  * '
            . ' FROM transport_menetrend tm'
            . ' WHERE tm.menetrend_id="' . $menetrend_id . '"';

        $query = $this->db->query($strsql);
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    } // END 


    // transport_menetrend - insert
    public function transport_menetrend_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('transport_menetrend', $data);
        return true;
    }

    //  - update
    public function transport_menetrend_update($data)
    {
        $menetrend_id = $data['menetrend_id'];
        $this->db->where('menetrend_id', $menetrend_id);
        $this->db->update('transport_menetrend', $data);
    }


    // busz menetrendek tlepülések
    function transport_admin_telepulesek_lista()
    {
        $strsql = 'SELECT  * '
            . ' FROM transport_telepules'
            . ' ORDER BY varos_id ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }


    // busz menetrendek
    function transport_admin_buszjaratok_lista()
    {
        $strsql = 'SELECT  tm.menetrend_title, tm.menetrend_jarat, tb.bind_id, tt.varosnev '
            . ' FROM transport_buszjaratok tb'
            . ' LEFT OUTER JOIN transport_menetrend tm ON tm.menetrend_id = tb.jarat_id '
            . ' LEFT OUTER JOIN transport_telepules tt ON tt.varos_id = tb.varos_id '
            . ' ORDER BY tb.bind_id ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }


    // transport_menetrend - insert
    public function transport_buszjaratok_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('transport_buszjaratok', $data);
        return true;
    }

    //  - update
    public function transport_buszjaratok_update($data)
    {
        $bind_id = $data['bind_id'];
        $this->db->where('bind_id', $bind_id);
        $this->db->update('transport_buszjaratok', $data);
    }


    // busz menetrendek
    function transport_admin_buszjaratok_read($bind_id)
    {
        $strsql = 'SELECT  tm.menetrend_title, tm.menetrend_jarat, tb.bind_id, tb.varos_id, tb.jarat_id, tt.varosnev '
            . ' FROM transport_buszjaratok tb'
            . ' LEFT OUTER JOIN transport_menetrend tm ON tm.menetrend_id = tb.jarat_id '
            . ' LEFT OUTER JOIN transport_telepules tt ON tt.varos_id = tb.varos_id '
            . ' WHERE tb.bind_id="' . $bind_id . '"';

        $query = $this->db->query($strsql);
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }




        $query = $this->db->query($strsql);
        return $query->result_array();
    }

    // buszjáratok JSON
    public function transport_json_buszjaratok()
    {
        $query = $this->db->query('SELECT tt.varos_id, tt.varosnev, tm.menetrend_jarat, tm.menetrend_title, tm.menetrend_url '
            . ' FROM transport_buszjaratok tb '
            . ' LEFT OUTER JOIN transport_menetrend tm ON tm.menetrend_id = tb.jarat_id '
            . ' LEFT OUTER JOIN transport_telepules tt ON tt.varos_id = tb.varos_id '
            . ' ORDER BY tb.bind_id ASC');

        return $query->result_array();
    }



    // feedback section
    function transport_admin_feedback_lista()
    {
        $strsql = 'SELECT  * '
            . ' FROM transport_feedback '
            . ' ORDER BY insert_time DESC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }


    // 
    public function transport_feedback_read($feedback_id)
    {
        $strsql = 'SELECT  * '
            . ' FROM transport_feedback tf'
            . ' WHERE tf.id="' . $feedback_id . '"';

        $query = $this->db->query($strsql);
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    } // END 


    // transport_ - insert
    public function transport_feedback_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('transport_feedback', $data);
        return true;
    }

    //  - update
    public function transport_feedback_update($data)
    {
        $id = $data['id'];
        $this->db->where('id', $id);
        $this->db->update('transport_feedback', $data);
    }

    // userid section
    function transport_admin_userid_lista()
    {
        $strsql = 'SELECT  * '
            . ' FROM transport_userid '
            . ' ORDER BY insert_time DESC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }


    // 
    public function transport_userid_read($id)
    {
        $strsql = 'SELECT  * '
            . ' FROM transport_userid tu'
            . ' WHERE tu.id="' . $id . '"';

        $query = $this->db->query($strsql);
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    } // END 


    // transport_ - insert
    public function transport_userid_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('transport_userid', $data);
        return true;
    }




    //  - update
    public function transport_userid_update($data)
    {
        $id = $data['id'];
        $this->db->where('id', $id);
        $this->db->update('transport_userid', $data);
    }



    function transport_select_pages_lista()
    {
        $strsql = 'SELECT  * '
            . ' FROM transport_pages '
            . ' ORDER BY pagetitle ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }


    // Meglévő adatrekord módosítása
    public function transport_admin_pages_update($data)
    {
        $pageId = $data['pageid'];
        $this->db->where('pageid', $pageId);
        $this->db->update('transport_pages', $data);
    }

    public function transport_admin_pages_insert($data)
    {
        // Query to insert data in database
        $this->db->insert('transport_pages', $data);
        return true;
    }


    // kozlemeny lista
    function admin_kozlemeny_lista()
    {
        $strsql = 'SELECT  * '
            . ' FROM kozlemenyek '
            . ' ORDER BY id ASC';

        $query = $this->db->query($strsql);
        return $query->result_array();
    }

    // kozlemeny olvasása
    public function read_kozlemeny($app)
    {
        $strsql = 'SELECT  * '
            . ' FROM kozlemenyek'
            . ' WHERE app="' . $app . '"';

        $query = $this->db->query($strsql);
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    } // END 

    //  - update
    public function admin_kozlemeny_update($data)
    {
        $app = $data['app'];
        $this->db->where('app', $app);
        $this->db->update('kozlemenyek', $data);
    }



    /* End of file Hajduhelp_model.php */
}
