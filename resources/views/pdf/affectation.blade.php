<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { font-size: 18px; font-weight: bold; }
        .details { margin-top: 10px; }
    </style>
</head>
<body>
    <div class="header">Affectation Details</div>
    <div class="details">
        <p><strong>Employee: {{ $affectation->type}}</strong> </p>
        <p><strong>Employee: {{ $affectation->employer->nom }}</strong> </p>
        <p><strong>Equipment: {{ $affectation->equipement->num_serie }}</strong> </p>
        <p><strong>Date: {{ $affectation->created_at->format('Y-m-d') }}</strong> </p>
        <!-- Add other relevant data here -->
    </div>
</body>
</html>
