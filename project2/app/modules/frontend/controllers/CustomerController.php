<?php 
class CustomerController extends Zend_Controller_Action{
	
	public function indexAction(){
		/* $login = Zend_Auth::getInstance();
		if($login->hasIdentity()){
			$this->_redirect('admin/index');
		}*/
		$dosave=0; 
		if($this->_request->isPost()){ 
			
			$err='';
			$value['username'] = $this->_request->getParam('username'); 
			$value['password'] = $this->_request->getParam('password');
			
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
					$this->_redirect('/frontend/index');
				}else{
					$err.= "<li>Username or Password incorrect!</li>";
					$this->view->error = $err;
					$this->view->data = $value;
				}
			} else{
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
		$authAdapter->setTableName('customer')
					->setIdentityColumn('cus_email')
					->setCredentialColumn('cus_pass');
		return $authAdapter;
	}
	public function logoutAction()  
	{  
		Zend_Auth::getInstance()->clearIdentity();
		//$url = $this->baseUrl().'';
		$this->_redirect('/frontend/index');
	}
	public function registerAction(){
		$cus = new Frontend_Model_Customer();
		$glo = new Frontend_Model_Global();
		if($this->_request->isPost()){
			$cus_email = $this->_request->getParam('email');
            $cus_pass = $this->_request->getParam('password');
			$cus_cpass = $this->_request->getParam('cpass');
			$errce='';
			$errcp='';
			$errcpass='';
			$data=array();
			if($cus_email==''){
               $errce = 'Please fill your email!';
               $data['cus_email']='';
            }else if($cus->checkAccount($cus_email)){
				$errce = 'This email address has been registed!';
				$data['cus_email']=$cus_email;
			}else if(!$glo->checkEmail($cus_email)){
				$errce = 'This email address is invalid!';
				$data['cus_email']=$cus_email;
			}else {
               $data['cus_email']=$cus_email;
            } 
			if($cus_pass==''){
               $errcp = 'Please fill your password!';
               $data['cus_pass']='';
            }else{
               $data['cus_pass']=$cus_pass;
            }
			if($cus_cpass==''){
				$errcpass='Please confirm your password!';
				$data['cus_cpass']='';
			} else if($cus_cpass!==$cus_pass){
				$errcpass='Your pass word not match';
				$data['cus_cpass']='';
			} else {
				$data['cus_cpass']=$cus_cpass;
			}
			if($errce!='' || $errcp!=='' || $errcpass!==''){
                $this->view->errce = $errce;
				$this->view->errcp = $errcp;
				$this->view->errcpass = $errcpass;
                $this->view->cus = $data;
            }else{
                $check = $cus->addCustomer($cus_email,md5($cus_pass));
                if($check){
                   $this->_redirect('/frontend/customer/empty');
                }
             }
		}
	}
	public function emptyAction(){
		
	}
}