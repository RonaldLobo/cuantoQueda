<?php 

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Service extends REST_Controller
{
	function user_get()
    {
        $query = "";
        if($this->get('id'))
        {
         	$query = "SELECT * FROM tbl_Usuario where var_Id_Usuario ='".$this->get('id')."';";
        }
        else{
            $query = "SELECT * FROM tbl_Usuario;";
        }

        $queryRes = $this->db->query($query);
        $users = array();
        $user = array();
        if ($queryRes->num_rows() > 0)
        {
            foreach ($queryRes->result() as $row)
            {
               $user['id'] = $row->var_Id_Usuario; // call attributes ID
               $user['password'] = $row->var_Password; // call attributes Password
               array_push($users,$user);
            } 
        }
    	
        if($users)
        {
            $this->response($users, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }
    
    function user_post()
    {
        $query = "";
        $info = $this->post('info');
        $data = array(
                   'var_Id_Usuario' => $info->idUsuario,
                   'var_Password' => $info->password 
                );
        switch ($info->action) {
            case 'add':
                $query = $this->db->insert('tbl_Usuario', $data); 
                break;
            case 'update':
                $query = $this->db->update('tbl_Usuario', $data, array('var_Id_Usuario' => $data['var_Id_Usuario'])); 
                break;
            
            default:
                # code...
                break;
        }
        
        $this->response($query, 200); // 200 being the HTTP response code
    }
    
    function user_delete()
    {
    	$query = "";
        $info = $this->post('info');
        $query = $this->db->delete('tbl_Usuario', array('id' => $info->idUsuario)); 
        $this->response($query, 200); // 200 being the HTTP response code
    }
    

	public function send_post()
	{
		var_dump($this->request->body);
	}


	public function send_put()
	{
		var_dump($this->put('foo'));
	}
}