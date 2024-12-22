<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Décharge Affectation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
        }
        .content {
            margin-top: 20px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        .important {
            margin-top: 20px;
            font-size: 12px;
        }
        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .footer div {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sonatrach Transport par Canalisation</h1>
        <h2>Direction Technologies de l'Information <br> Département Infrastructure et Réseau</h2>
    </div>
    <div class="content">
        <p>Sidi-Arcine, le<strong >{{$currentDate}}</strong></p>
        <h2 style="text-align: center;">DÉCHARGE AFFECTATION N°{{ $affectation->id_history }}/INF/{{ $affectation->equipement->Type }}/2024</h2>
        <p>
            Il a été remis ce jour, à  <strong>{{ $affectation->employer->prenom }} {{ $affectation->employer->nom }} {{ $affectation->employer->fonc }} {{ $affectation->employer->structure->nom }}</strong>, 
            le matériel informatique suivant :
        </p>
        <table>
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th>N° Série</th>
                    <th>Observation</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $affectation->equipement->Type }} {{ $affectation->equipement->marque }}</td>
                    <td>{{ $affectation->equipement->num_serie }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <div class="important">
            <p><strong>Important:</strong></p>
            <ul>
                <li>Le Micro-ordinateur est configuré pour l'exploitation exclusive sur le réseau informatique de SONATRACH.</li>
                <li>L'utilisateur est tenu de respecter les dispositions de la "Charte d'utilisation du système d'information de Sonatrach E-023 (R1)".</li>
                <li>Pour toute demande d'assistance informatique adresser un mail à <strong>TRC_helpdesk@sonatrach.dz</strong></li>
            </ul>
        </div>
    </div>
    <div class="footer">
        <div>
            <p>P/Le Département RXS</p>
            <br><br>
            <p>____________________</p>
        </div>
        <div>
            <p>P/Le Bénéficiaire</p>
            <br><br>
            <p>Le Restituant</p>
        </div>
    </div>

</body>
</html>
