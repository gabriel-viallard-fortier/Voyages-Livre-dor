<!-- REQUETES SQL PDO  -->
<?php

// TODO :

// HASH PASSWORDS -> done
// reécrire update() -> done
// htmlspecialchars -> done
// ob_clean()
// vider le cache


class User
{
    private $dbco;
    public $isAdmin = 0;
    private $id;
    public $login;
    public $email;
    public $country;
    public $zip;
    public $logged;

    // Est appelée automatiquement lors de l’initialisation de notre User.
    // Initialise les différents attributs de notre User.
    public function __construct()
    {
        //On essaie de se connecter
        try {
            $this->dbco = db_connect();
            //On définit le mode d'erreur de PDO sur Exception
            $this->dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo 'Connexion à la base de données réussie<br>';
        }
        /*On capture les exceptions si une exception est lancée et on affiche
    les informations relatives à celle-ci*/ catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage() . "<br>";
            exit();
        }
    }

    // Crée l'utilisateur dans la BDD, retourne les informations de l'utilisateur    
    public function register($isAdmin, $login, $email, $country, $zip, $password)
    {

        // On interroge la BDD pour ne pas créer de doublons d'emails
        //on prepare la requete SQL
        $verif = $this->dbco->prepare("SELECT email FROM users WHERE email = ?");
        //On execute la requete
        $verif->execute(array($email));
        // On fait sortir les resultats
        $verifResult = $verif->fetchAll(PDO::FETCH_ASSOC);

        // Si l'email demandé n'existe pas: 
        // 1: on enregistre l'utilisateur
        // 2 :puis on retourne les infos du compte en BDD
        if ($verifResult === []) {

            // 1:Insertion du nouvel utilisateur dans la base de données

            // Préparation de la requete
            $insert = $this->dbco->prepare("INSERT INTO users (isAdmin, login, email, country, zip, password) VALUES (?,?,?,?,?,?)");
            // Execution de la requete avec hashage ARGON2ID du mdp
            $insert->execute(array($isAdmin, $login, $email, $country, $zip, password_hash($password, PASSWORD_BCRYPT)));


            // 2: Récupération des infos en BDD

            // Préparation de la requete
            $data = $this->dbco->prepare("SELECT * FROM users WHERE email = ?;");
            // Exécution de la requete
            $data->execute(array($email));
            // Extraction des données
            $result = $data->fetchAll(PDO::FETCH_ASSOC);
            // on retourne les informations de l'utilisateur (BDD) dans un tableau
            return [
                $result[0]['isAdmin'],
                $result[0]['id'],
                $result[0]['login'],
                $result[0]['email'],
                $result[0]['country'],
                $result[0]['zip'],
                $result[0]['password'],
            ];
        }
        // Si login existe déjà on affiche une erreur
        else {
            set_flash('error', "Email " . $email . " déjà enregistré ! <br>");
            return false;
        }
    }


    // Connecte l’utilisateur, et donne aux attributs de la classe 
    // les valeurs correspondantes à celles de l’utilisateur connecté.
    public function connect($email, $password)
    {

        // Selection des champs de l'utilisateur en fonction du login
        // Préparation de la requete
        $select = $this->dbco->prepare("SELECT * FROM users WHERE email=? ");
        // Exécution de la requete
        $select->execute(array($email));
        // Extraction des données
        $result = $select->fetchAll(PDO::FETCH_ASSOC);


        // On verifie le login puis le mdp:
        // Si aucun tel login dans le resultat de la requete
        if ($result === []) {
            set_flash('error', "Aucun utilisateur associé à cet email<br>");
        }

        // Si le login existe dans la BDD
        else {

            // on verifie le mdp par rapport au hash dans la BDD
            if (!password_verify($password, $result[0]['password'])) {
                set_flash('error', "Erreur: mot de passe invalide<br>");
                return [
                    'isAdmin' => $this->isAdmin,
                    'id' => $this->getId(),
                    'logged' => false,
                    'login' => $this->login,
                    'email' => $this->email,
                    'country' => $this->country,
                    'zip' => $this->zip
                ];

            }

            // Si OK, on accepte la connection
            else {

                // Assignation des propriétés de l'objet en fonction de la BDD
                $this->logged = true;
                $this->isAdmin = $result[0]['isAdmin'];
                $this->id = $result[0]['id'];
                $this->login = $result[0]['login'];
                $this->email = $result[0]['email'];
                $this->country = $result[0]['country'];
                $this->zip = $result[0]['zip'];

                return [
                    'id' => $this->getId(),
                    'logged' => true,
                    'isAdmin' => $this->isAdmin,
                    'login' => $this->login,
                    'email' => $this->email,
                    'country' => $this->country,
                    'zip' => $this->zip,
                ];

            }
        }
    }


    // Déconnecte l’utilisateur
    public function disconnect()
    {
        // Si déjà loggé
        if ($this->logged === true) {
            $this->logged = false;
            $_SESSION['message'] = "Utilisateur " . $this->login . " déconnecté avec succès.<br>";
        }
        // sinon
        else {
            set_flash('error',"Aucun utilisateur connecté.<br>");
        }
    }


    // Supprime ET déconnecte un utilisateur
    public function delete()
    {

        $this->disconnect();
        $delete = $this->dbco->prepare("DELETE FROM users WHERE id = ?");
        $delete->execute(array($this->id));

        $_SESSION['message'] = "Utilisateur " . $this->login . " supprimé avec succès.<br>";
    }

    // Met à jour les attributs de l’objet, et modifie les 
    // informations en base de données.
    public function update($login, $email, $country, $zip, $oldPassword, $password)
    {
        // On interroge la BDD pour ne pas créer de doublons de logins
        // on prepare la requete SQL
        $verif = $this->dbco->prepare("SELECT * FROM users WHERE email = ?");
        //On execute la requete
        $verif->execute(array($email));
        // On fait sortir les resultats
        $verifResult = $verif->fetchAll(PDO::FETCH_ASSOC);
        if ($verifResult === null || $verifResult[0]['email'] === $email) {
            if (verify_password($oldPassword, $verifResult[0]['password'])) {
                $update = $this->dbco->prepare("UPDATE users SET 
                                                        login=?,
                                                        email=?,
                                                        country=?,
                                                        zip=?,
                                                        password=?
                                                        WHERE id=?");
                $update->execute(array($login, $email, $country, $zip, password_hash($password, PASSWORD_BCRYPT), $this->id));

                set_flash('success', "Utilisateur mis a jour avec succès.<br>");
                return true;
            } else {
                set_flash('error', "Mot de passe actuel invalide");
            }
        } else {
            set_flash('error', "Email " . $email . " non disponible<br>");
            return false;
        }
    }

    // Retourne un booléen (true ou false) permettant de savoir si
    // un utilisateur est connecté ou non
    public function isConnected()
    {
        if ($this->logged === true) {
            $_SESSION['message'] = "Status " . $this->login . ": connecté<br>";
            return $this->logged;
        } else {

            $_SESSION['message'] = "Status " . $this->login . ": déconnecté<br>";
            return $this->logged;
        }
    }

    // retourne l'id de l'utilisateur
    public function getId()
    {
        return $this->id;
    }


    //Retourne le login de l’utilisateur
    public function getLogin()
    {
        return $this->login;
    }

    public function getEmail()
    {
        return $this->email;
    }

    // Retourne le prenom de l’utilisateur
    public function getCountry()
    {
        return $this->country;
    }
    // Retourne le nom de l’utilisateur
    public function getZip()
    {
        return $this->zip;
    }

    //Retourne un tableau contenant l’ensemble des informations de
    // l’utilisateur
    public function getAllInfos()
    {
        $allInfos = [
            $this->getId(),
            $this->getLogin(),
            $this->getcountry(),
            $this->getZip(),
            $this->getEmail(),
            $this->isConnected(),
        ];
        return $allInfos;
    }

    public static function logged($ret)
    {
        $user = new self();

        $user->isAdmin = $ret['isAdmin'];
        $user->id = $ret['id'];
        $user->login = $ret['login'];
        $user->email = $ret['email'];
        $user->country = $ret['country'];
        $user->zip = $ret['zip'];
        $user->logged = true;

        return $user;
    }

    public function admin()
    {
        $admin = $this->dbco->prepare('SELECT * FROM users');
        $admin->execute();
        $display = $admin->fetchAll(PDO::FETCH_ASSOC);
        return $display;
    }

}