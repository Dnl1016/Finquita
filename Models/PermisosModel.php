<?php 

	class PermisosModel extends Mysql
	{
		public $intIdpermiso;
		public $intRolid;
		public $intModuloid;
		public $c;
		public $r;
		public $u;
		public $d;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectModulos()
		{
			$sql = "SELECT * FROM modules WHERE status != 0";
			$request = $this->select_all($sql);
			return $request;
		}	
		public function selectPermisosRol(int $idrol)
		{
			$this->intRolid = $idrol;
			$sql = "SELECT * FROM 	permissions WHERE rolId = $this->intRolid";
			$request = $this->select_all($sql);
			return $request;
		}

		public function deletePermisos(int $idrol)
		{
			$this->intRolid = $idrol;
			$sql = "DELETE FROM permissions WHERE rolId = $this->intRolid";
			$request = $this->delete($sql);
			return $request;
		}

		public function insertPermisos(int $idrol, int $idmodulo, int $r, int $w, int $u, int $d){
			$this->intRolid = $idrol;
			$this->intModuloid = $idmodulo;
			$this->r = $r;
			$this->c = $w;
			$this->u = $u;
			$this->d = $d;
			$query_insert  = "INSERT INTO permissions(rolId ,moduleId ,r,c,u,d) VALUES(?,?,?,?,?,?)";
        	$arrData = array($this->intRolid, $this->intModuloid, $this->r, $this->c, $this->u, $this->d);
        	$request_insert = $this->insert($query_insert,$arrData);		
	        return $request_insert;
		}

		public function permisosModulo(int $idrol){
			$this->intRolid = $idrol;
			$sql = "SELECT p.idPermission ,
						   p.moduleId ,
						   m.titleModule as modules,
						   p.r,
						   p.c,
						   p.u,
						   p.d 
					FROM permissions p 
					INNER JOIN modules m
					ON p.moduleId  = m.idModule  
					WHERE p.rolId = $this->intRolid";
			$request = $this->select_all($sql);
			$arrPermisos = array();
			for ($i=0; $i < count($request); $i++) { 
				$arrPermisos[$request[$i]['moduleId']] = $request[$i];
			}
			return $arrPermisos;
		}

		public function getRol(int $idrol){
			$this->intRolid = $idrol;
			$sql = "SELECT * FROM roles WHERE idRol = $this->intRolid";
			$request = $this->select($sql);
			return $request;
		}
	}
 ?>