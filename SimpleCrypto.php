class SimpleCrypto {

    private $table;
    private $key;
    private $defTable = "abcdefghijklmnopqrstuvwxyz1234567890!?.,_#$ @-*/";
    
    public function setKey($k) {
        $this->key = $k;
        $this->vTable($k);
    }
    
    public function setTable($t) {
        $this->defTable = $t;
    }
    
    private function cleanText($t) {
        $return = null;
        foreach ( str_split($t) as $k => $v ) {
            $return .= ( stripos($this->defTable, $v) !== false ? $v : null );
        }
        return $return;
    }
    
    public function encrypt($t) {        
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
    
    public function decrypt($t) {
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
    
    private function vTable($key) {
        $seq = str_split($this->defTable);
        $table = [];        
        foreach ( str_split($this->key) as $k => $v ) {
            $index = array_search($v, $seq);            
            $temp = [];            
            for ($x = 0; $x < count($seq); $x++) {                
                $index %= count($seq);
                array_push($temp, $seq[$index]);                
                $index++;
            }
            array_push($table, $temp);
        }
        $this->table = $table;
    }
}
