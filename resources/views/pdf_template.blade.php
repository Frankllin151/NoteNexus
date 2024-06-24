<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Template</title>
</head>

<body>
    
    @foreach ($anotacoes as $anotacao)
        <h1 class="text-lg font-semibold">{{ $anotacao->nomelivro }}</h1>
        <ul>
            @foreach ($anotacao->children as $capitulo)
                <h2 class=" text-[20px] font-semibold">{{ $capitulo->capitulo }}</h2>
                <ul>
                    @foreach ($capitulo->children as $trecho)
                        <p>{{ $trecho->trecho }}</p>
                    @endforeach
                </ul>
            @endforeach
        </ul>
    @endforeach
</body>

</html>
