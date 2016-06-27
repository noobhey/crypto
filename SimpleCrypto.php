class SimpleCrypto {

    private $table = [];
    private $defTable = null;
    private $key = null;
    
    public function setKey($k) {
        if ( !ctype_alpha($k) ) return false;
        foreach ( str_split($k) as $k => $v ) $this->key .= dechex(ord($v));
        $this->vTable();
    }
    
    private function cleanText($t) {
        $return = null;
        foreach ( str_split($t) as $k => $v ) $return .= ( stripos($this->defTable, $v) !== false ? $v : null );
        return $return;
    }
    
    private function encrypt($t) {
        $defTable = str_split($this->defTable);
        $msg = str_split(strtolower($this->cleanText($t)));
        $count = 0;
        $return = null;
        for ( $x = 0; $x < count($msg); $x++ ) {
            $count %= strlen($this->key);
            $index = array_search($msg[$x], $defTable);
            $return .= $this->table[$count][$index];
            $count++;
        }        
        return $return;
    }    
    
    private function decrypt($t) {
        $defTable = str_split($this->defTable);
        $msg = str_split(strtolower($this->cleanText($t)));
        $count = 0;
        $return = null;
        for ( $x=0; $x < count($msg); $x++ ) {
            $count %= strlen($this->key);
            $index = array_search($msg[$x], $this->table[$count]);
            $return .= $defTable[$index];
            $count++;
        }
        return $return;
    }
    
    private function vTable() {       
        foreach ( [[97, 122], [48, 57], [32, 47], [58, 64]] as $c ) {
            for ( $x=$c[0]; $x <= $c[1]; $x++ ) $this->defTable .= chr($x);
        }
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
