<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Codes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <table>
        {{-- <thead>
            <tr>
                <th>Product Code</th>
                <th>Product Code</th>
                <th>Product Code</th>
            </tr>
        </thead> --}}
        <tbody>
            @foreach($products->chunk(3) as $productChunk)
                <tr>
                    @foreach($productChunk as $product)
                        <td>{{ $product->code }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
