<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture prestation {{ $prestation->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1f2937; font-size: 14px; }
        h1 { margin-bottom: 24px; }
        .row { margin-bottom: 8px; }
        .label { font-weight: bold; display: inline-block; width: 150px; }
        table { width: 100%; border-collapse: collapse; margin-top: 28px; }
        th, td { border: 1px solid #d1d5db; padding: 10px; text-align: left; }
        th { background: #f3f4f6; }
        .total { text-align: right; font-size: 18px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Facture de prestation</h1>

    <div class="row"><span class="label">Référence :</span> #{{ $prestation->id }}</div>
    <div class="row"><span class="label">Date de fin :</span> {{ $prestation->date_fin?->format('d/m/Y') }}</div>
    <div class="row"><span class="label">Client :</span> {{ $prestation->mission->client->name }}</div>
    <div class="row"><span class="label">Prestataire :</span> {{ $prestation->prestataire->name }}</div>

    <table>
        <thead>
            <tr>
                <th>Mission</th>
                <th>Délai prévu</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $prestation->mission->titre }}</td>
                <td>{{ $prestation->offre->delai_execution }} jour(s)</td>
                <td>{{ number_format($prestation->montant, 2, ',', ' ') }} DH</td>
            </tr>
        </tbody>
    </table>

    <div class="total">Total : {{ number_format($prestation->montant, 2, ',', ' ') }} DH</div>
</body>
</html>
