# rent-receipts-generator

### Prerequisites
1. You have cloned this repo.
2. You are in the cloned directory.
3. PHP 8.1
4. Composer 2

### Usage:

1. `composer install`
2. Configure desired values in `config/config.php` -- The keys are self-explanatory.
3. Put png image of desired signature in `signatures` directory.  
4. `./console rent-receipts`

This will generate desired rent receipts in output directory. 

You may change format of your rent receipt in `src/Helper/rent-receipt-template.html`.
Note: Keep the desired tokens as it is for the Receipts to output correct data.

Tokens to note:
1. {$startDate} - Rent start date
2. {$endDate} - Rent end date
3. {$employeeID} - Employee Id
4. {$fullName} - Full name of the employee
5. {$address} - Address of the rented premise
6. {$city} - City of the rented premise
7. {$pinCode} - Pin code of the rented premise
8. {$state} - State of the rented premise
9. {$country} - Country of the rented premise
10. {$rentAmount} - Rent every month
11. {$paymentMode} - Payment mode e.g. Online, Cash, etc.
12. {$landlordPAN} - PAN number of the Landlord
13. {$landlordName} - Full name of the Landlord
14. {$landlordSignature} - Path of the png file located in `signatures/`
15. {$note} - Footer note in the receipt

function

[Rent Receipt PDF Example](output/2022_04_01_Rent_Receipt.pdf)

You may use https://www.signwell.com/online-signature/type/ for your name's png signature.

* [Signature Example 1](signatures/john_doe.png)

* [Signature Example 2](signatures/jane_doe.png)
