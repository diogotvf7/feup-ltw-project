<?php 
    function getUserType($user) {
        return $user == null ? null : get_class($user);
    }
?>