<!DOCTYPE html>
<html>
<head>
    <title>Test View</title>
</head>
<body>
    <h1>Test Candidate Notes</h1>
    
    @php
        $candidate = \App\Models\Candidate::with(['notes.user'])->find(10);
        dump($candidate->toArray());
    @endphp
    
    <h2>Notes:</h2>
    <ul>
        @foreach($candidate->notes as $note)
            <li>
                {{ $note->content }} 
                <small>by {{ $note->user->name }} ({{ $note->created_at->diffForHumans() }})</small>
            </li>
        @endforeach
    </ul>
</body>
</html>
