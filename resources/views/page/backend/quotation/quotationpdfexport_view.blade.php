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
            background-color: #fff;
        }

        .logoname {
            display: flex;
        }

    </style>
</head>
<body>
   <div class="logoname">
        <div style="text-align:center;">
            <h5 style="text-transform: uppercase; color:black">Quotation Report ({{date('d-m-Y', strtotime($from_date))}}) - ({{date('d-m-Y', strtotime($to_date))}})</h5>
        </div>
    </div>
   
   


        <table id="customers">
            <thead>
                <tr>
                    <th>Q.no</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>GrossAmount</th>
                    <th>Tax</th>
                    <th>Discount</th>
                    <th>Extracost</th>
                    <th> Total</th>
                </tr>
            </thead>
            <tbody id="customer_index">
                @foreach ($Quotationarr_data as $keydata => $outputs)
                <tr>
                    <td>{{ $outputs['quotation_number'] }}</td>
                    <td style="font-size: 14px;">{{ date('d-m-Y', strtotime($outputs['date'])) }}</td>
                    <td style="font-size: 14px;">{{ $outputs['customer'] }}</td>
                    <td style="font-size: 14px;">{{ $outputs['gross_amount'] }}</td>
                    <td style="font-size: 14px;">{{ $outputs['tax_amount'] }}</td>
                    <td style="font-size: 14px;">{{ $outputs['discount_price'] }}</td>
                    <td style="font-size: 14px;">{{ $outputs['extracost_amount'] }}</td>
                    <td style="font-size: 14px;">{{ $outputs['grand_total'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    
</body>
</html>
