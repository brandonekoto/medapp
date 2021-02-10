<?php

namespace composants;

class Session
{       
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        return $this;
    }
    public function setFlash($message, $type = "success")
    {
        if (is_array($message)) {
            $result = "";
            foreach ($message as $k => $v) {
                $result .= "<p>$v</p>";
            }
            $_SESSION['flash']['message'] = $result;
        } else {
            $_SESSION['flash']['message'] = $message;
        }
        $_SESSION['flash']['type'] = $type;
    }

    /**
     * Permet d'afficher un message flash si il est défini
     * @return string
     */
    public function flash()
    {
        if (isset($_SESSION['flash'])) {
            echo "<div href='#' style='display:inline-box' class=' alert alert-" . $_SESSION['flash']['type'] . "'>" . $_SESSION['flash']['message'] . "</div>";
            unset($_SESSION['flash']);
        }
    }

    /**
     * Lit la session à l'index $key
     * @param $key
     * @return null
     */
    public function read($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Supprimer l'index $key de la session
     * @param string|array $key
     */
    public function delete($key)
    {
        if (is_array($key)) {
            foreach ($key as $k) {
                if (isset($_SESSION[$k])) {
                    unset($_SESSION[$k]);
                }
            }
        } elseif (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Ajoute un index $key à la session et lui attribut la valeur $value
     * @param $key
     * @param $value
     */
    public function write($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Stocke le langage dans la session.
     * @param $lang
     */
    public function setLanguage($lang)
    {
        $_SESSION['LANG'] = $lang;
    }

}