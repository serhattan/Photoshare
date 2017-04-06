<?php
	
	//sistemde belirtilen mesajların kullanıcıya bildirilmesini sağlayan sınıf
	class Alert{

		//mesaj ekleme
		public static function addMessage($addedMessage){
			$_SESSION['message'][] = $addedMessage;
		}

		//herhangi bir mesaj var mı diye bakma
		public static function hasAnyMessage(){
			if(! isset($_SESSION['message'])) return false;
			if(gettype($_SESSION['message']) != "array") return false;
			if(count($_SESSION['message']) < 1) return false;
			return true;
		}

		//mesaj varsa bunları alıp döngüye sokabilmek, bir kere alınan mesajın temizlenmesi
		public static function getMessage(){
			if(self::hasAnyMessage()){
				$messages = $_SESSION['message'];
				unset($_SESSION['message']);
				return $messages;
			}
		}
	}

?>