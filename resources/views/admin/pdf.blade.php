<h3>Liste des Notes - Classe {{ $classe->nom }}</h3>

<table border="1" width="100%" cellpadding="5">
    <tr>
        <th>Nom</th>
        <th>Note</th>
    </tr>

    @foreach($eleves as $eleve)
    <tr>
        <td>{{ $eleve->user->name }}</td>
        <td>{{ $eleve->note->valeur ?? 'N/A' }}</td>
    </tr>
    @endforeach
</table>