<?php


namespace Helpers;


class Date 
{
    public static function dateToFr($date, $format = "Le %d %B %Y à %H:%M")
    {
        setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
        date_default_timezone_set('Europe/Paris');
        return strftime($format, strtotime($date));
    }

    /**
     * Vérifie si une date est bien valide
     * @param $date
     * @return bool
     */
    public static function isValid($date){
        date_default_timezone_set('UTC');
        $d = \DateTime::createFromFormat('d-m-Y', $date);
        return $d && $d->format('d-m-Y') == $date;
    }

    /**
     * Reformate une date au format jj-mm-aaaa
     * @param $date
     * @return bool|string
     */
    public static function reFormat($date)
    {
        date_default_timezone_set('UTC');
        return date("d-m-Y", strtotime($date));
    }

    /**
     * Formate au timestamp mysql
     * @param $date
     * @return bool|string
     */
    public static function toMysqlTimestamp($date){
        return date("Y-m-d H:i:s", strtotime($date));
    }
    
    public static function functionName($date) {
        return \DateTime::createFromFormat($format, $time);
    }
    
    
} 