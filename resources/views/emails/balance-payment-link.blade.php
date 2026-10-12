<p>Hello {{ $customerName }},</p>

<p>Your made-to-order purchase (order {{ $orderNumber }}) has shipped.</p>

<p>The remaining balance is {{ $currency }}{{ number_format($balanceAmount, 2) }}.</p>

<p><a href="{{ $paymentUrl }}">Pay the remaining balance</a></p>

<p>You can also find this payment link in the Payments section of your account.</p>
