<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <script src="{{ asset('assets/template/presensi-abdul') }}/plugins/qrcode/qrcode.js"></script>
    <style>
        body{
            font-family: sans-serif;
        }
        table{
            border: 0.1px solid #708090;
        }
        tr td{
            text-align: center;
            border: 0.1px solid #708090;
            font-weight: 20;
        }
        tr th{
            border: 0.1px solid #708090;
        }
        input[type=text] {
            border: none;
            background: transparent;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">PT DCITS<br><small>Digital China Information Service Company Ltd.</small></h2>
    <p style="text-align: center;">Palma One Floor.6, 605, H.R Rasuna Said Street RT/RW. 008/004, Kuningan Timur, Setiabudi, Jakarta Selatan, DKI Jakarta 12950</p>
    <hr>
    <p style="text-align: center; font-weight: bold;">QR Code Presensi {{ $absensi->nama }}</p>
    <center>
        <div id="qr-event"></div>
    </center>
</body>
<script>
    new QRCode(document.getElementById("qr-event"), "{{ $kode }}");
    setTimeout(() => {
        window.print();
    }, 500);
</script>
</html>