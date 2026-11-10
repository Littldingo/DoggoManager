<!DOCTYPE>
<html lang="de">
<meta charset="utf-8">

<head>
    @vite(['resources/js/app.js', 'resources/css/app.css', 'resources/css/feed.css'])
    <title>Dog feeding</title>
</head>

<body>
    <div id="gesamtes">
        <div id="block1">
            <h1>Feeding plan for {{ $daten->first()->hund }}</h1>
            <nav><a href=/create><img width="20px" height= "auto" src={{ asset('storage/arrow-back.png') }}></a></nav>
        </div>
        <div id="gesamt_feed">
            <table class="card" id = "feeding_table">
                <thead>
                    <th>Day</th>
                    <th>Meat</th>
                    <th>Bones</th>
                    <th>Offal</th>
                    <th>Vegetables</th>
                    <th>Fat</th>
                </thead>
                <tbody>
                    @foreach ($daten as $feed)
                        <tr>
                            <th>{{ $feed->tag }}</th>

                            <td id="sum" data-flesh_q="{{ $feed->fleisch }}">{{ $feed->fleisch }}
                                {{ $feed->flesh_q }} g
                            </td>

                            <td data-bones_q>{{ $feed->knochen }} {{ $feed->bones_q }} g</td>

                            <td data-offal_q>{{ $feed->innereien }} {{ $feed->offal_q }} g</td>

                            <td data-vegetables_q>{{ $feed->vegetables_q }} g</td>

                            <td data-fat_q>{{ $feed->fat_q }} g</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="collectionTables">
                <h3>Order list for 4 weeks</h3>
                <table id="bestellmenge_fleisch" class="tables">
                    <tbody>
                        @foreach ($fleisch as $sorteFleisch)
                            <tr>
                                <th scope="row">{{ $sorteFleisch->name }}: </th>
                                <td>{{ $sorteFleisch->summe }} g</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <table id="bestellmenge_bones" class="tables">
                    <tbody>
                        @foreach ($bones as $sorteBones)
                            <tr>
                                <th scope="row">{{ $sorteBones->name }}: </th>
                                <td>{{ $sorteBones->summe }} g</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <table id="bestellmenge_offal" class="tables">
                    <tbody>
                        @foreach ($offal as $sorteOffal)
                            <tr>
                                <th scope="row">{{ $sorteOffal->name }}: </th>
                                <td>{{ $sorteOffal->summe }} g</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <table id="bestellmenge_rest" class="tables">
                    <tbody>

                        <tr>
                            <th scope="row">Vegetables: </th>
                            <td>{{ $vegetables }} g</td>
                        </tr>
                        <tr>
                            <th scope="row">Fat:</th>
                            <td>{{ $fat }} g</td>
                        </tr>


                    </tbody>
                </table>

                <a href="https://ellisbarferie.de/shop/" target="blank"><button type="button">Order</button></a>
            </div>
        </div>
    </div>
    <script>
        const cycleDay = @json($cycleDay);
        const daten = @json($daten);
    </script>
</body>

</html>
