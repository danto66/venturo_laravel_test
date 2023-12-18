<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Venturo Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        td,
        th {
            font-size: 11px;
        }
    </style>
</head>

<body class="vsc-initialized">
    <div class="container-fluid">
        <div class="card" style="margin: 2rem 0rem;">
            <div class="card-header">Venturo - Laporan penjualan tahunan per menu</div>
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <select name="tahun" id="my-select" class="form-control">
                                    <option value="">Pilih Tahun</option>
                                    <option value="2021" {{ $period == 2021 ? 'selected' : '' }}>2021</option>
                                    <option value="2022" {{ $period == 2022 ? 'selected' : '' }}>2022</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                        </div>
                    </div>
                </form>

                @if (!empty($resources))
                    <hr>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" style="margin: 0">
                            <thead>
                                <tr class="table-dark">
                                    <th rowspan="2" style="text-align:center;vertical-align: middle;width: 250px;">
                                        Menu</th>
                                    <th colspan="12" style="text-align: center;">Periode Pada {{ $period }}
                                    </th>
                                    <th rowspan="2" style="text-align:center;vertical-align: middle;width:75px">Total
                                    </th>
                                </tr>

                                <tr class="table-dark">
                                    @foreach ($months as $month)
                                        <th style="text-align: center;width: 75px;"> {{ $month }} </th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($resources as $keyCategory => $category)
                                    <tr>
                                        <td colspan="14" class="table-secondary"> {{ ucfirst($keyCategory) }} </td>
                                    </tr>
                                    @foreach ($category as $item)
                                        <tr>
                                            <td> {{ $item['name'] }} </td>
                                            @if (isset($item['monthly']))
                                                @foreach ($item['monthly'] as $value)
                                                    <td> {{ $value ? number_format($value, 0, ',') : '' }} </td>
                                                @endforeach
                                            @else
                                                @foreach ($months as $month)
                                                    <td> </td>
                                                @endforeach
                                            @endif
                                            <td> {{ isset($item['total']) ? number_format($item['total'], 0, ',') : 0 }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                <tr class="table-dark">
                                    <td><b>Total</b></td>
                                    @foreach ($grandTotal['monthly'] as $value)
                                        <td> <b> {{ $value ? number_format($value, 0, ',') : '' }} </b> </td>
                                    @endforeach
                                    <td> <b> {{ number_format($grandTotal['total'], 0, ',') }} </b> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
