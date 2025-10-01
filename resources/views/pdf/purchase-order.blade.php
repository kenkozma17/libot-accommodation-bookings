<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind Elements styles-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />

    <!-- Tailwind CSS config -->
    <script src="https://cdn.tailwindcss.com/3.3.0"></script>
    <title>Purchase Order</title>
  </head>
  <body>
    <h1 class="text-center text-2xl font-bold uppercase">
      Purchase Order
    </h1>

    <table>
      <tr>
        <td style="width: 50%">Seller:______________________</td>
        <td style="width: 50%; text-align: right">P.O. No:______________________</td>
      </tr>
      <tr>
        <td style="width: 50%">Requesting Dept:______________</td>
        <td style="width: 50%; text-align: right">Date:______________________</td>
      </tr>
      <tr>
        <td>Purpose:______________________</td>
      </tr>
    </table>

    <table class="styled">
      <tr>
        <th scope="col">
          Qty.
        </th>
        <th scope="col">
          Unit
        </th>
        <th scope="col">
          Description
        </th>
        <th scope="col">
          Unit Price
        </th>
        <th scope="col">
          Amount
        </th>
        <th scope="col">
          Notes
        </th>
      </tr>
      @php $estCostTotal = 0; @endphp
      @foreach($items as $item)
        @php $estCostTotal+= $item['est_refill_cost'] @endphp
        <tr>
          <td>{{ $item['refill_quantity'] }}</td>
          <td>{{ $item['unit'] }}</td>
          <td style="max-width: 250px;">{{ $item['name'] }}</td>
          <td>{{ $item['est_cost_formatted'] }}</td>
          <td>{{ $item['est_refill_cost_formatted'] }}</td>
          <td></td>
        </tr>
      @endforeach
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>Total</td>
        <td>P{{ number_format($estCostTotal, 2) }}</td>
        <td></td>
      </tr>
      <tr>
        <td colspan="6">
          <p style="font-weight: 700;">Prepared By:</p>
          <p>_________________________</p>
          <p>Signature over printed name</p>
          <p>Date & Time</p>
        </td>
      </tr>
    </table>

    <table class="styled" style="margin-top: 0;">
      <tr style="display: none;">
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
      </tr>
      <tr>
        <td colspan="2">
          <p style="font-weight: 700;">Confirmed By:</p>
          <p>___________________</p>
          <p>Signature over printed name</p>
          <p>Date & Time</p>
        </td>
        <td colspan="2">
          <p style="font-weight: 700;">Approved By:</p>
          <p>___________________</p>
          <p>Signature over printed name</p>
          <p>Date & Time</p>
        </td>
        <td colspan="2">
          <p style="font-weight: 700;">Received By:</p>
          <p>___________________</p>
          <p>Signature over printed name</p>
          <p>Date & Time</p>
        </td>
      </tr>
    </table>
  </body>
  <style>
  table {
    width: 100%; /* Make the table span the full width */
    border-collapse: collapse;
    margin-top: 32px;
  }

  table.styled th, table.styled td {
    border: 1px solid #ddd; /* Light gray border for cells */
    padding: 8px; /* Padding inside cells for readability */
    text-align: left; /* Align text to the left within cells */
  }

  table.styled th {
    background-color: #f2f2f2; /* Light gray background for table headers */
    color: #333; /* Darker text for headers */
    font-weight: bold; /* Bold text for headers */
  }

  table.styled tr:nth-child(even) {
    background-color: #f9f9f9; /* Alternate row background color for readability */
  }
  </style>
</html>
