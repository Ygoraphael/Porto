<?php

namespace App\Controller;

use Cosmos\System\Controller;

class Insecurity extends Controller {

    private $insecurity;
    private $response;

    public function __construct() {
        parent::__construct($this);
    }
	
	//** Save the news insecurities **//
    public function new_insecurity() {
        $name = basename($_FILES['file_name']['name']);
        $encryp = bin2hex(openssl_random_pseudo_bytes(2));
        $name_encryp = $encryp . "_" . $name;

        $this->uploadRegister($name_encryp);
        $this->helperSaveInsecurity($name_encryp);
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        \Cosmos\System\Helper::redirect('/panel/insecuritys');
    }

    private function uploadRegister($name_encryp) {
        $uploaddir = APP_PATH . 'html/assets/images/upload/';
        $name_encryp2 = $name_encryp;
        $uploadfile = $uploaddir . $name_encryp2;
        move_uploaded_file($_FILES['file_name']['tmp_name'], $uploadfile);
    }
	
    //** Ver Insecurity pc **//
    public function new_pc_insecurity() {
        $this->load("{$this->directory}/Insecurity", 'New_pc', false, false);
    }

    private function helperSaveInsecurity($name_encryp) {
        $this->insecurity = new \App\Model\Insecurity();
        $this->insecurity->register($name_encryp);
        if ($this->insecurity->getMessage()->getType() == 1) {
            $this->response['message'] = '%%Insecurity registered successfully%%!';
            $this->response['type'] = 1;
        } else {
            $this->response['message'] = '%%Insecurity could not be registered%%!';
            $this->response['type'] = 0;
        }
    }

    public function delete() {
        $this->insecurity = (new \App\Model\Insecurity());
        $this->status = $this->insecurity->delete();
        if ($this->status) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%Insecurity successfully erased%%!';
        }
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

	public function sendInsecurity(){
		$this->load("{$this->directory}/Insecurity", 'SendInsecurity', false, false);
	}
	
	//** ATRIBUTION THE INSECURITIES**//
	public function saveInsecurity(){
		$this->id = filter_input(INPUT_POST, 'Insecurity', FILTER_SANITIZE_NUMBER_INT);
		/**UPDATE IN INSECURITY**/
		$this->insecurity =(new \App\Model\Insecurity())->fetch($this->id);
		$this->insecurity->Atribution();
		
		/**UPDATE IN NOTIFICATION**/
		
		$parameters = [
			'value1' => ['=', $this->id,'AND'],
			'table1' =>['=', 'insecurity']
		]; 
		$notification = (new \App\Model\Notification)->listingRegisters($parameters);
		if( empty( $notification ) ){
			$this->Notification = (new \App\Model\Notification());
			$this->Notification->Atribution();
		} else {
			foreach( $notification as $not ){
				$this->id2 = $not->getId();
				$this->Notification = (new \App\Model\Notification())->fetch($this->id2);
				$this->Notification->Re_Atribution();
			}
		}
		
		if ($this->Notification->getMessage()->getType() == 1 && $this->insecurity->getMessage()->getType() == 1) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%Successfully assigned insecurity%%!';
        }else {
            $this->response['message'] = '%%Insecurity could not be attributed%%!';
            $this->response['type'] = 0;
        }
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }	
	
	
	public function answer() {
	$notification_id = (int) func_get_arg(0);
	$notification = (new \App\Model\Notification())->fetch($notification_id);
	
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	$ismobile=preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|zh-cn|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4));
		if($ismobile) { 
		
			if ($this->insecurity = (new \App\Model\Insecurity())->fetch($notification->getValue1())) {
				$_GET['value1'] = $notification->getValue1();
				$_GET['id'] = $notification_id;
				$_GET['description'] = $notification->getDescription();
				$this->load('Panel/Insecurity', 'Answer_phone_Insecurity', true, true);
			} else {
				\Cosmos\System\Helper::redirect('/panel/insecuritys');
			} 
		} else {
								
			if ($this->insecurity = (new \App\Model\Insecurity())->fetch($notification->getValue1())) {
				$_GET['value1'] = $notification->getValue1();
				$_GET['id'] = $notification_id;
				$_GET['description'] = $notification->getDescription();
				$this->load('Panel/Insecurity', 'Answer_pc_Insecurity', true, true);
			} else {
				\Cosmos\System\Helper::redirect('/panel/insecuritys');
			}
		}
    }
	
	
	//** Devolver Insercutiry **//
	public function RefundInsecurity(){
		$this->id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		$this->id2 = filter_input(INPUT_POST, 'id2', FILTER_SANITIZE_NUMBER_INT);
		$this->SaveRefund();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
		echo json_encode($this->response);		
	}
	
	private function SaveRefund(){
		/**UPDATE IN INSECURITY**/
		$this->insecurity =(new \App\Model\Insecurity())->fetch($this->id);
		$this->insecurity->SaveRefund();
		/**UPDATE IN NOTIFICATION**/
		$this->notification = (new \App\Model\Notification())->fetch($this->id2);
		$this->notification->SaveRefund();
		
		if ($this->insecurity->getMessage()->getType() == 1 && $this->notification->getMessage()->getType() == 1) {
			$this->response['type'] = 1;
			$this->response['message'] = '%%Insecurity returned successfully%%!';
		}else {
			$this->response['message'] = '%%Unable to return insecurity%%!';
			$this->response['type'] = 0;
		}		
	}
	
	//** RESOLVED INSECURITY**//
	public function SaveResolved(){
		$this->id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		$this->id2 = filter_input(INPUT_POST, 'id2', FILTER_SANITIZE_NUMBER_INT);
		$this->Resolved_Insecurity();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
		echo json_encode($this->response);
	}
	
	private function Resolved_Insecurity(){
		/**UPDATE IN INSECURITY**/
		$this->insecurity =(new \App\Model\Insecurity())->fetch($this->id);
		$this->insecurity->Resolved_Insecurity();
		/**UPDATE IN NOTIFICATION**/
		$this->notification = (new \App\Model\Notification())->fetch($this->id2);
		$this->notification->Resolved_Insecurity();

		if ($this->insecurity->getMessage()->getType() == 1 && $this->notification->getMessage()->getType() == 1) {
			$this->response['type'] = 1;
			$this->response['message'] = '%%Insecurity successfully resolved%%!';
		}else {
			$this->response['message'] = '%%Unable to resolve insecurity%%!';
			$this->response['type'] = 0;
		}		
	}
	
	/**CLOSE INSECURITY FOR BOSS**/
	public function Close_pc_insecurity() {
        $this->load("{$this->directory}/Insecurity", 'Close_pc_insecurity', false, false);
    }
	/**CLOSE INSECURITY FOR BOSS**/
	public function Close_phone_insecurity() {
        $this->load("{$this->directory}/Insecurity", 'Close_phone_insecurity', false, false);
    }

	//**RESOLVED INSECURITY FOR BOSS**//
	public function Close_Insecurity(){		
		$this->id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		$this->SaveClose_Insecurity();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
		echo $this->response['type'];
		 \Cosmos\System\Helper::redirect('/panel/insecuritys');
	}
	
	private function SaveClose_Insecurity(){
		/**UPDATE IN INSECURITY**/
		$this->insecurity =(new \App\Model\Insecurity())->fetch($this->id);
		$this->insecurity->SaveClose_Insecurity();
		/**UPDATE IN NOTIFICATION**/
		$this->notification = (new \App\Model\Notification());
		$this->notification->SaveClose_Insecurity();
		
		if ($this->insecurity->getMessage()->getType() == 1 && $this->notification->getMessage()->getType() == 1) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%Insecurity successfully resolved%%!';
        }else {
            $this->response['message'] = '%%Unable to resolve insecurity%%!';
            $this->response['type'] = 0;
        }
		
	}
	//** Nova Insecurity Telemóvel **//
	public function new_phone_insecurity() {
        $this->load("{$this->directory}/Insecurity", 'New_phone', false, false);
    }
	
	//** Ver Insecurity Pc **//
	public function see_pc_insecurity(){
		$this->load("{$this->directory}/Insecurity", 'See_pc_insecurity', false, false);
	}
	//** Ver Insecurity Telemóvel **//
	public function see_phone_insecurity(){
		$this->load("{$this->directory}/Insecurity", 'See_phone_insecurity', false, false);
	}
}
