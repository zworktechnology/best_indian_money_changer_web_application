<!DOCTYPE html>
<html>
<head>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            padding-top: 20px;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: left;
            background-color: #fff;
            color: black;
        }


        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Float four columns side by side */
        .column {
            float: left;
            width: 30%;
            padding: 0 10px;
        }

        /* Remove extra left and right margins, due to padding */
        .row {
            margin: 0 -5px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        @media screen and (max-width: 600px) {
            .column {
                width: 100%;
                display: block;
                margin-bottom: 20px;
            }
        }

        /* Style the counter cards */
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            padding: 16px;
            text-align: center;
            background-color: #f1f1f1;
        }

        .logoname {
            display: flex;
        }

    </style>
</head>
<body>
   <div class="logoname">
        <div>
            <h4  style="text-transform: uppercase; color:green">Vendor Report </h4>
        </div>
    </div>
   
   



    <table id="customers">
        <thead>
            <tr>
                <th>Sl. No</th>
                <th>Vendor</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody id="customer_index">
            @foreach ($Vendorarr_data as $keydata => $outputs)
            <tr>
                <td>{{ ++$keydata }}</td>
                <td style="font-size: 14px;">{{ $outputs['name'] }}</td>
                <td style="font-size: 14px;">{{ $outputs['address'] }}</td>
                <td style="font-size: 14px;">{{ $outputs['phone_number'] }}</td>
                <td style="font-size: 14px;">{{ $outputs['purchase_totalamount'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</body>
</html>
