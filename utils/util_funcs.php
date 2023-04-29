<?php 

    function getUserType($user) {
        return $user == null ? null : get_class($user);
    }

    function removeOverflow($string, $maxSize) {
        if (strlen($string) > $maxSize) 
            return substr($string, 0, $maxSize - 3) . '...';
        return $string;
    }

?>