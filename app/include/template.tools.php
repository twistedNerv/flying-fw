<?php

class templateTools extends template {
    
    public function __construct() {
        //
    }
    
    public function readableColour($bg) {
        list($r, $g, $b) = sscanf($color, "%02x%02x%02x");
        $squared_contrast = (
                $r * $r * .299 +
                $g * $g * .587 +
                $b * $b * .114 );
        return ($squared_contrast > pow(130, 2)) ? '000000' : 'FFFFFF';
    }
}
