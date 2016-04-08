<?php

return [
    'status.0' => 'New order',
    'status.1' => 'Being processed',
    'status.2' => 'Out for delivery',
    'status.3' => 'Delivered',
    'status.4' => 'Cancelled',

    'number'    => 'Order number',
    'date'      => 'Order date',
    'create'    => 'Order placed',
    'completed' => 'Order completed',
    'details'   => 'Order details',
    'summary'   => 'Order summary',
    'history'   => 'Order history',

    'api.update.success' => 'Order updated',
    'api.error.status-same' => 'Order already set to this status',

    'email.confirmation.subject' => 'Your Zugy order confirmation and receipt [#:id]',
    'email.confirmation.paid' => 'Total paid',
    'email.delivery.subject' => 'Your Zugy order [#:id] is out for delivery',
    'email.delivery.driver' => 'Our driver is now on his way to you!',
    'email.delivery.trouble' => 'If anything goes wrong or we have trouble finding you, we will call you on your phone at <b>:phone</b>',
    'email.cancelled.subject' => 'Your Zugy order [#:id] was cancelled',
    'email.cancelled.questions' => 'If you have any questions regarding this cancellation you can reply to this email or call us at :phone.',
    'email.track.description' => 'You can track the current status of your order by clicking the button below.',
    'email.track' => 'Track order',

    'sign-in' => '<a href=":loginUrl">Sign in</a> to view more information on your order.',

    'total-before-vat' => 'Total before VAT',
    'vat' => 'VAT',
    'include-vat' => 'Order totals include',
];