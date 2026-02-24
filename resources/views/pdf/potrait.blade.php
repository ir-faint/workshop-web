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

    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quo cupiditate alias quam repellat? Sunt obcaecati, ipsam animi id illo provident dignissimos ipsa adipisci repellendus quam quasi! Obcaecati, consectetur! Eos, repellendus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, laborum cupiditate molestiae consectetur dicta nihil veritatis inventore id reiciendis tenetur quasi ducimus illo sequi aliquam accusantium eveniet eligendi excepturi similique. Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium veniam repudiandae enim odio quas eaque velit reiciendis eos quasi culpa ipsum quos doloribus rem debitis dolorum porro hic, cum quibusdam.</p>
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