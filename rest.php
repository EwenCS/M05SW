<?php
    $maConnexion = new PDO('mysql:host=localhost;dbname=CirparkEwen;charset=utf8','ec', 'ec');
    $req_type = $_SERVER['REQUEST_METHOD'];

     //Récupération du chemin dans l'URL 
     if(isset($_SERVER['PATH_INFO']))
     {
         $req_path = $_SERVER['PATH_INFO'];
         $req_data = explode('/',$req_path);
     }

    if ($req_type == 'GET')
    
        //rest.php/capteurs
        if (isset($req_data[1]) && $req_data[1] == "Capteur") 
        {
            $req = "SELECT nom,type,numero FROM Capteur";
            $reqprepare = $maConnexion -> prepare($req);
            $tableauDeDonnees=array($req_data[1]);
            $tableauDeDonnees = array();
            $reqprepare -> execute($tableauDeDonnees);
            $reponse = $reqprepare -> fetchAll(PDO::FETCH_ASSOC);
            print_r(json_encode($reponse));   
        } 
        if (isset($req_data[1]) && $req_data[1] == "etat") 
        {
            $req = "SELECT idcapteur,date,etat FROM etat";
            $reqprepare = $maConnexion -> prepare($req);
            $tableauDeDonnees=array($req_data[1]);
            $tableauDeDonnees = array();
            $reqprepare -> execute($tableauDeDonnees);
            $reponse = $reqprepare -> fetchAll(PDO::FETCH_ASSOC);
            print_r(json_encode($reponse));   
        } 
?>