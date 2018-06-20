<?php

class AuthService
{
    /**
     * Gibt den boolschen Wert des Login-Status zurück. Ist $cookey gesetzt, ist die Prüfung stärker
     * @param string $cookey Der Inhalt des AuthCookies
     * @return bool
     */
    public static function checkIsLoggedIn($cookey = '') {
        if (empty($cookey)) {
            // Schwache Prüfung: Nur die Frage, ob Session angelegt
            if (empty(s::get('kirby_auth_secret'))) {
                return false;
            }
        } else {
            // Starke Prüfung: Braucht übergebenen Wert aus Cookie!
            $username = site()->user()->username();
            if (s::get('kirby_auth_secret') !== sha1($username . $cookey)) {
                return false;
            }
        }
        return true;
    }
}