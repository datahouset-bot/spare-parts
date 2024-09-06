
@extends('layouts.blank')
@section('pagecontent')

<title>Run SQL Query</title>
</head>
<body>

    <div class="row mx-3">
        <h1>Run SQL Query</h1>
    <form action="{{ route('sql_query_execute') }}" method="POST">
        @csrf
        <textarea name="sql_query" rows="10" cols="80" placeholder="Enter your SQL query here"></textarea><br>
        <button type="submit">Execute</button>
    </form>
</div>

    @if(isset($results))
        <h2>Results</h2>
        <pre>{{ print_r($results, true) }}</pre>
    @endif

    @if(isset($error))
        <h2>Error</h2>
        <pre>{{ $error }}</pre>
    @endif
</body>
@endsection