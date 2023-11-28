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
            <h5 style="text-transform: uppercase; color:black">Expense Report ({{date('d-m-Y', strtotime($from_date))}}) - ({{date('d-m-Y', strtotime($to_date))}})</h5>
        </div>
    </div>
   
   


    <div class="card">
        <table id="customers">
            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Date</th>
                    <th>Bank</th>
                    <th>Amount</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody id="customer_index">
                @foreach ($Expensearr_data as $keydata => $outputs)
                <tr>
                    <td>{{ ++$keydata }}</td>
                    <td style="font-size: 14px;">{{ date('d-m-Y', strtotime($outputs['date'])) }}</td>
                    <td style="font-size: 14px;">{{ $outputs['bank'] }}</td>
                    <td style="font-size: 14px;">{{ $outputs['price'] }}</td>
                    <td style="font-size: 14px;">{{ $outputs['note'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</body>
</html>
