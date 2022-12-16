<?php

declare(strict_types=1);

$note = 'The HRA tax benefit is applicable only for the amount paid towards rent. ';
$note .= 'Payment towards other expenses like maintenance, water, electricity, food, security deposits, ';
$note .= 'late payment charges etc. are excluded. ';
$note .= 'If other expenses are being paid along with the rent, ';
$note .= 'the rent receipt should contain a break-up of all the components paid.';

return [
    '{$startDate}'         => '2022-04-01',
    '{$endDate}'           => '2023-03-31',
    '{$employeeID}'        => '987654321',
    '{$fullName}'          => 'Mr. Jane Doe',
    '{$address}'           => '3960 Hardman Road',
    '{$city}'              => 'Pune',
    '{$pinCode}'           => 411006,
    '{$state}'             => 'Maharashtra',
    '{$country}'           => 'India',
    '{$rentAmount}'        => 20000.00,
    '{$paymentMode}'       => 'Online',
    '{$landlordPAN}'       => 'ABCDE1234F',
    '{$landlordName}'      => 'Mr. John Doe',
    '{$landlordSignature}' => getImageBase64(__DIR__.'/../signatures/john_doe.png'),
    '{$note}'              => '<u><strong>Note: </strong></u>'.$note,
];


function getImageBase64(string $path): string
{
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);

    return 'data:image/'.$type.';base64,'.base64_encode($data);
}
