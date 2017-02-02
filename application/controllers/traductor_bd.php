<?php
class Traductor_bd extends CI_Controller
{
	
	 public function __construct() 
    { 
        // Creamos el contructor y cargamos la librerias y modelos 
        parent::__construct(); 
        $this->load->dbforge();
        $this->load->model('traductor_bd_model');
    } 


    function index()
    {
	   echo "si jala";
    }	


    function traducir($tabla)
    {
    	$datos = $this->traductor_bd_model->tabla_mssql($tabla);

    	//print_r($datos);

    	 print_r($datos[0]);

    	 //echo br(3);

    	$fields = $this->traductor_bd_model->campos_tabla_mssql($tabla);

    	for($i=0;$i<count($fields);$i++)	
    	{	
    		$fields[$i] = (array) $fields[$i];

    		print_r($fields[$i]);

    		//echo br(3);

    		if ($fields[$i]['type'] == 'datetime') 
    		{
    			$campos[$fields[$i]['name']] = array('type' => $fields[$i]['type'], 'null' => TRUE);
    		}else{

    		$campos[$fields[$i]['name']] = array('type' => $fields[$i]['type'], 'constraint' => 255, 'primary_key' => $fields[$i]['primary_key'], 'null' => TRUE);
    		}
	   	}


	   	echo br(3);

    	print_r($campos);
		
					
		
		if ($this->db->table_exists($tabla) == FALSE)
		{
			$this->dbforge->add_field($campos);

			$this->dbforge->create_table($tabla);

			foreach ($datos as $key) 
			{
				$query = $this->traductor_bd_model->guardar_mysql($tabla, $key);
			}

		}else{

			echo br(5)."esta tabla ya existe";

		}

		

		
		
    }

}
