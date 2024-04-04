if(document.getElementById('planNAV'))
    document.getElementById('planNAV').addEventListener('click',AfficherPlanHTML);

    if(document.getElementById('capteurNAV'))
        document.getElementById('capteurNAV').addEventListener('click',RecupererListeCapteurs)

function RecupererListeCapteurs(){
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var listeCapteurs = JSON.parse(this.responseText);
            var capteurs=listeCapteurs.valeur;
            var html="<table class='tableau'>";
            html+="<tr><th>Nom</th><th>Type</th><th>Numero</th></tr>";
            for(let i=0;i<capteurs.length;i++){
                Nom=capteurs[i].nom;
                Type=capteurs[i].Type;
                html+="<tr><td>"+Nom+"</td><td>"+Type+"</td><td>Numero</td></tr>";
            }
            document.getElementById('section').innerHTML=html;
            console.log(listeCapteurs);

        }
    };
    xhttp.open("GET", "http://172.20.21.212/~ec/M05SW/rest.php/Capteur");
    xhttp.send();
} 