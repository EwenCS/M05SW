<?php
$maConnexion = new PDO('mysql:host=localhost;dbname=CirparkEwen;charset=utf8','ec', 'ec');
$req = "SELECT id,numero FROM capteurs";
$reqpreparer = $maConnexion->prepare($req);
$tableauDeDonnees = array();
$reqpreparer->execute($tableauDeDonnees);
$reponseSQL = $reqpreparer ->fetchAll(PDO::FETCH_ASSOC);


for($i=0;$i<count($reponseSQL);$i++)
{
    //print_r($reponseSQL[$i]["numero"]);

    $capteur = str_split($reponseSQL[$i]["numero"],2);

    $adrh = $capteur [0];
    $adrl = $capteur [1];
    $codeFonction="10";
    $bcc=dechex(hexdec($adrh)+hexdec($adrl)+hexdec($codeFonction)); // Addition decimale puis conversion hexa

    $ipServeur = "172.20.21.58";
    $port = "10001";

    $message = hex2bin($adrh. $adrl.$codeFonction.$bcc);
    echo "Capteur: ".$adrh.$adrl. $codeFonction.$bcc;
    
    $sock = socket_create(AF_INET, SOCK_DGRAM, 0);

    //Send the message to the server
    socket_sendto($sock, $message, strlen($message), 0, $ipServeur, $port);

    //Now receive reply from server and print it
    socket_recvfrom ( $sock, $reponse, 2045, MSG_WAITALL, $ipServeur, $port );

    $tableauData = str_split(bin2hex($reponse),2);
    if (($tableauData[2] == "00"))
    {
        echo " : Libre\n";

    } elseif (($tableauData[2] == "01"))
    {
        echo " : Occupée\n";
    }
}
    //echo bin2hex($reponse);     //Convertir reponse en hexa 
?>