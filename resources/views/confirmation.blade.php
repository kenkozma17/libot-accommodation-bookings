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
    <h1 class="text-center text-2xl font-bold">
      <span class="uppercase">Booking Confirmation:</span> {{ $booking->booking_confirmation }}
    </h1>
    <div class="mt-4">
      <p class="mb-6">{{ $booking->created_at_formatted }}</p>
      <p class="mb-2">Dear {{ $booking->guest->full_name }},</p>
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
        <td>{{ $booking->guest->full_name }}</td>
        <td>{{ $booking->room->name }}</td>
        <td>{{ $booking->check_in_formatted }}</td>
        <td>{{ $booking->check_out_formatted }}</td>
      </tr>
    </table>

    <div class="mt-4">
      <h2 class="font-bold">Payment Details</h2>
      <ul>
        <li>Payment Confirmation: {{ $booking->payment->paymongo_payment_id }}</li>
        <li>Payment Amount: {{ $booking->payment->payment_amount_formatted }}</li>
        <li>Payment Method: {{ $booking->payment->payment_method }}</li>
        <li>Payment Date: {{ $booking->payment->payment_date }}</li>
      </ul>
    </div>

    <div class="mt-4">
      <h2 class="font-bold">Guest Details</h2>
      <ul>
        <li>No. of Guests: {{ $booking->adult_count + $booking->children_count }}</li>
        <li>Email: {{ $booking->guest->email }}</li>
        <li>Phone Number: {{ $booking->guest->phone }}</li>
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