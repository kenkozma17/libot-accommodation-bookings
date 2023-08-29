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
    <title>Invoice Example</title>
  </head>
  <body>
    <h1 class="text-center text-2xl uppercase font-bold">Booking Confirmation: 00001</h1>
    <div class="mt-4">
      <p class="mb-6">January 2, 2023</p>
      <p class="mb-2">Dear Valued Guest,</p>
      <p>
        Thank you for your reservation at Catanduanes Midtown Inn. Please find your reservation details as follows:
      </p>
    </div>
    <table class="w-full mt-4">
      <tr>
        <th>Name</th>
        <th>Room</th>
        <th>Check In</th>
        <th>Check Out</th>
      </tr>
      <tr>
        <td>Ken Kozma</td>
        <td>Exclusive Deluxe</td>
        <td>January 1, 2023</td>
        <td>January 3, 2023</td>
      </tr>
    </table>

    <div class="mt-4">
      <h2 class="font-bold">Payment Details</h2>
      <ul>
        <li>Payment Confirmation: #123</li>
        <li>Payment Amount: P2500</li>
        <li>Payment Method: Cash</li>
        <li>Payment Date: January 2, 2023</li>
      </ul>
    </div>

    <div class="mt-4">
      <h2 class="font-bold">Guest Details</h2>
      <ul>
        <li>No. of Guests: 5</li>
        <li>Email: kenkozma17@gmail.com</li>
        <li>Phone Number: +63 969 042 6656</li>
      </ul>
    </div>

    <div class="mt-4">
      <h2 class="font-bold">Reminders</h2>
      <p>Check In: 2:00pm</p>
      <p>Check Out: 11:00am</p>
    </div>


    
  </body>
  <style>
  table {
    border-collapse: collapse;
  }
  th {
    background: #ccc;
  }

  th, td {
    border: 1px solid #ccc;
    padding: 8px;
  }

  tr:nth-child(even) {
    background: #efefef;
  }

  tr:hover {
    background: #d1d1d1;
  }
  </style>
</html>