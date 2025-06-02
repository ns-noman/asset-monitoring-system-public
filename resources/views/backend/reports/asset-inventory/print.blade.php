<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $data['title'] }}</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/admin-assets') }}/plugins/fontawesome-free/css/all.min.css">  
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/admin-assets') }}/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
</head>

<body>
    <div class="wrapper">
        <section class="invoice">
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        {{-- <i class="fas fa-globe"></i>  --}}
                        {{ $data['basicInfo']['title'] }}
                        <small class="float-right">Date: {{ date('Y-m-d') }}</small>
                    </h2>
                </div>
            </div>
            <div class="row invoice-info d-flex justify-content-center">
                <div class="col-sm-6 invoice-col d-flex justify-content-center">
                    <h1>{{ $data['title'] }}</h1>
                </div>
            </div>
            <div class="row invoice-info mt-5">
                <div class="col-sm-12 invoice-col">
                    <p><span style="font-size: 16px;"><b>Description:</b></span> Provides a detailed list of all assets currently being monitored.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Asset Code</th>
                                <th>Asset Name</th>
                                <th>Category Name</th>
                                <th>Location</th>
                                <th>Condition</th>
                                <th>Status</th>
                                <th>Acquisition Date</th>
                                <th>Value(BDT)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $locationMap = ['In Store','','In Transit','In Garage'];
                            @endphp
                            @foreach ($data['assetList'] as $assetList)
                                <tr>
                                    @php
                                        if ($assetList['location'] == '1') $locationMap[$assetList['location']] = $assetList['branch_title'];
                                    @endphp
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $assetList['code'] }}</td>
                                    <td>{{ $assetList['title'] }}</td>
                                    <td>{{ $assetList['category_title'] }}</td>
                                    <td>{{ $locationMap[$assetList['location']] }}</td>
                                    <td>{{ $assetList['is_okay'] == '1' ? 'Ok' : 'Not Ok' }}</td>
                                    <td>{{ $assetList['status'] == '1' ? 'Active' : 'Iactive' }}</td>
                                    <td>{{ $assetList['purchase_date'] }}</td>
                                    <td>{{ $assetList['purchase_value'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
