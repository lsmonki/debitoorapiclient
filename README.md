debitoorapiclient
=================

Debitoor php api clent library,
Work in progress



## Usage :

You can instantiate an api for each types of services :

* Customers
* DraftInvoices
* Invoices
* Expenses
* Products
* Quotes
* etc.


Each service provides an interface to the methods provided in debitoor api,
you can see what is in "Services/servicename.json" to check what parameters can be sent.


## Example :

```PHP
$customerService = DebitoorApiClient::getService('Customers', array('access_token' => $auth_token));

// list customers
$customerService->getCustomers();

// get customer by id
$customerService->getCustomer(array('customer_id' => 'your customer id'));


// get customer by id
$customerService->createCustomer(
    array(
        'customer_id'   => 'your customer id',
        'name'          => 'your customer name',
        'address'       => 'customer address',
        'email'         => 'customer@debitoor',
        'phone'         => '000-000-00-00'
    )
);

```
