<!DOCTYPE html>
<html>
<head>
    <title>Laporan Portrait</title>
    <style>
        /* Simple CSS for the PDF */
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Tanggal: {{ $date }}</p>
    </div>

    <h3>{{ $sub_title }}</h3>

    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, ipsum saepe. Doloribus, aspernatur, adipisci pariatur facere harum possimus id praesentium corrupti nihil facilis quae repudiandae, fugiat hic quidem magnam odit! Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti facilis, veritatis quaerat repellat veniam ea quibusdam vitae quas nesciunt dolor temporibus, omnis atque. Necessitatibus itaque cumque pariatur at praesentium aspernatur? Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum, aut sapiente qui autem in fugit est rem, recusandae blanditiis vero vitae quod tempora obcaecati dolor debitis perspiciatis optio praesentium! Animi!</p>
    {{-- <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Laravel PDF</td>
                <td>Easy to implement</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Paper Size</td>
                <td>A4 Portrait</td>
            </tr>
        </tbody>
    </table> --}}
</body>
</html>