<?php 
class Admin_LoginController extends Zend_Controller_Action{
	
	 public function preDispatch(){
		$layoutPath = APP_PATH  . '/templates/admin/';
		$option = array ('layout'     => 'login',
						 'layoutPath' => $layoutPath,
						 'contentKey' => 'content' );
		Zend_Layout::startMvc ( $option );
	}
	
	public function init()
	{
		
		/* Initialize action controller here */
	}
	
	public function indexAction(){
		$login = Zend_Auth::getInstance();
		if($login->hasIdentity()){
			$this->_redirect('admin/index');
		}
		$dosave=0;
		
		if($this->_request->isPost()){ 
			$err='';
			$value['username'] = $this->_request->getParam('usrlogin'); 
			echo $value['username'];
			$value['password'] = $this->_request->getParam('pwdlogin');
			//print_r($value);exit;
			
			if($value['username']==''){
				$dosave=-1;
				$err.="<li>username must be not null.</li>";
			}
			if($value['password']==''){
				$dosave=-1;
				$err.="<li>password must be not null!.</li>";
			}
			
			if ($dosave != -1) {                    
				if ($this->_process($value)) {
					$this->_redirect('admin/index');
				}else{
					$err.= "<li>Username or Password incorrect!</li>";
					$this->view->error = $err;
					$this->view->data = $value;
				}
			}else{
				$this->view->error = $err;
				$this->view->data = $value;
			}               
		}
    }
	
	protected function _process($values){
		// Get our authentication adapter and check credentials
		$adapter = $this->_getAuthAdapter();
		$adapter->setIdentity($values['username']);
		$adapter->setCredential(md5($values['password']));

		$auth = Zend_Auth::getInstance();
		$result = $auth->authenticate($adapter);
		if ($result->isValid()) {
			$user = $adapter->getResultRowObject();
			$auth->getStorage()->write($user);
			return true;
		}
		return false;
	}
	
	protected function _getAuthAdapter(){
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		
		$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
		
		$authAdapter->setTableName('admin')
					->setIdentityColumn('adm_usr')
					->setCredentialColumn('adm_pwd');
					//->setCredentialTreatment("MD5(adm_pwd)");
		return $authAdapter;
	}
		
	public function logoutAction()  
	{  
		// clear everything - session is cleared also!  
		/* Zend_Auth::getInstance()->clearIdentity();  
		$this->_redirect('admin//index');   */
		Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index'); // back to login page
	} 
	/* public function indexAction(){
		$login = new Zend_Session_Namespace('login');
		$login->login = true;
		echo 'controller login';
		exit;
	} */
	
}