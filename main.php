<?php

$BDD = new PDO('mysql:host=localhost;dbname=CirparkEwen;charset=utf8','ec', 'ec');
$req = "SELECT id,numero FROM Capteur";
    $reqpreparer=$BDD->prepare($req,array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $reqpreparer->execute(NULL);
    $DATA=$reqpreparer ->fetchAll(PDO::FETCH_ASSOC);

  



        for ($i=0;$i<count($DATA);$i++){

            

            $capteur=str_split($DATA[$i]['numero'],2);

            $adrh=$capteur [0];
            $adrl=$capteur [1];
            $codeFonction="10";
            $bcc=dechex(hexdec($adrh)+hexdec($adrl)+hexdec($codeFonction)); // Addition decimale puis conversion hexa




            $ipServeur = "172.20.21.58";
            $port="10001";

            $message=hex2bin($adrh. $adrl.$codeFonction.$bcc);
            echo "message envoyé : ".$adrh.$adrl. $codeFonction.$bcc;

            $sock=socket_create(AF_INET, SOCK_DGRAM, 0);

            //récupérer la liste des idcapteurs ainsi que la le numéro de la table capteur


            //Send the message to the server
            socket_sendto($sock, $message, strlen($message), 0, $ipServeur, $port);

            //Now receive reply from server and print it
            socket_recvfrom ( $sock, $reponse, 2045, MSG_WAITALL, $ipServeur, $port );

            $tableauData=str_split(bin2hex($reponse),2);
            if (($tableauData[2] == "00"))
            {
                $etat="  Libre\n";
                echo "  Libre\n";

            } elseif (($tableauData[2] == "01"))
            {
                $etat="  Occupée\n";
                echo "  Occupée\n";
            }

            $DateTime=Date('Y-m-d H:i:s');
            echo ($DateTime);
            $ReqEtat = "INSERT INTO etat (idcapteur,date,etat) VALUES (?,?,?) ";    
            $ReqpreparerEtat=$BDD->prepare($ReqEtat,array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $tableauEtat=array($DATA[$i]['id'],$DateTime,$etat);
            $ReqpreparerEtat->execute($tableauEtat);

        }
?>