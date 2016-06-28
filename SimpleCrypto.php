class SimpleCrypto {

    private $table = [];
    private $defTable = null;
    private $key = null;
    
    //
    //  User defined encryption key for encrypting and/or decrypting
    //
    public function setKey($k) {
        //  Check if key only contains alphanumeric characters
        if ( !ctype_alpha($k) ) return false;
        foreach ( str_split($k) as $k => $v ) $this->key .= dechex(ord($v));
        //  Generate Vigenere table once key has been assigned
        $this->vTable();
    }
    
    //
    //  Check if text contains if characters are in the Vigenere table
    //
    private function cleanText($t) {
        $return = null;
        foreach ( str_split($t) as $k => $v ) $return .= ( stripos($this->defTable, $v) !== false ? $v : null );
        return $return;
    }
    
    //
    //  Encryption and decryption process
    //
    private function encrypt($t, $reverse = false) {
        $defTable = str_split($this->defTable);
        $msg = str_split(strtolower($this->cleanText($t)));
        $count = 0;
        $return = null;
        for ( $x = 0; $x < count($msg); $x++ ) {
            $count %= strlen($this->key);
            private function encrypt($t, $reverse = false) {
        $defTable = str_split($this->defTable);
        $msg = str_split(strtolower($this->cleanText($t)));
        $count = 0;
        $return = null;
        for ( $x = 0; $x < count($msg); $x++ ) {
            $count %= strlen($this->key);
            $return .= ( !$reverse ? $this->table[$count][array_search($msg[$x], $defTable)] : $defTable[array_search($msg[$x], $this->table[$count])] );
            $count++;
        }        
        return $return;
    }
            $count++;
        }        
        return $return;
    }    
    
    //
    //  Vigenere table creation process
    //
    private function vTable() {
        //  Generate table using selected ascii codes that composes letters, numbers and punctuations
        foreach ( [[97, 122], [48, 57], [32, 47], [58, 64]] as $c ) {
            for ( $x=$c[0]; $x <= $c[1]; $x++ ) $this->defTable .= chr($x);
        }
        //  Complete the Vigenere table by inserting the key in to the table
        $seq = str_split($this->defTable);
        foreach ( str_split($this->key) as $k => $v ) {
            $index = array_search($v, $seq);            
            $temp = [];            
            for ($x = 0; $x < count($seq); $x++) {                
                $index %= count($seq);
                array_push($temp, $seq[$index]);                
                $index++;
            }
            array_push($this->table, $temp);
        }
    }
}
