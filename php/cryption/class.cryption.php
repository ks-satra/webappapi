<?php
    class cryption {
        public function cryption() { }
        public function encrypt($sData, $sKey) { 
            $sResult = ''; 
            for($i=0;$i<strlen($sData);$i++){ 
                $sChar    = substr($sData, $i, 1); 
                $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1); 
                $sChar    = chr(ord($sChar) + ord($sKeyChar)); 
                $sResult .= $sChar; 
            } 
            return $this->encode_base64($sResult); 
        } 
        public function decrypt($sData, $sKey) { 
            $sResult = ''; 
            $sData   = $this->decode_base64($sData); 
            for($i=0;$i<strlen($sData);$i++){ 
                $sChar    = substr($sData, $i, 1); 
                $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1); 
                $sChar    = chr(ord($sChar) - ord($sKeyChar)); 
                $sResult .= $sChar; 
            } 
            return $sResult; 
        } 
        private function encode_base64($sData) { 
            $sBase64 = base64_encode($sData); 
            return strtr($sBase64, '+/', '-_'); 
        } 
        private function decode_base64($sData) { 
            $sBase64 = strtr($sData, '-_', '+/'); 
            return base64_decode($sBase64); 
        }
    }
