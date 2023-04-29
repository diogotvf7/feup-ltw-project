<?php 

    function getUserType($user) {
        return $user == null ? null : get_class($user);
    }

    function removeOverflow($string, $maxSize) {
        if (strlen($string) > $maxSize) 
            return substr($string, 0, $maxSize - 3) . '...';
        return $string;
    }

    function timeAgo(DateTime $date) {
        $now = new DateTime();
        $diff = $now->diff($date);
        if ($diff->y > 0) return $diff->y . ' year' .  ($diff->y > 1 ? 's' : '') . ' ago';
        if ($diff->m > 0) return $diff->m . ' month' .  ($diff->m > 1 ? 's' : '') . ' ago';
        if ($diff->d > 0) return $diff->d . ' day' .  ($diff->d > 1 ? 's' : '') . ' ago';
        if ($diff->h > 0) return $diff->h . ' hour' .  ($diff->h > 1 ? 's' : '') . ' ago';
        if ($diff->i > 0) return $diff->i . ' minute' .  ($diff->i > 1 ? 's' : '') . ' ago';
        if ($diff->s > 0) return $diff->s . ' second' .  ($diff->s > 1 ? 's' : '') . ' ago';
        return 'just now';
    }
?>