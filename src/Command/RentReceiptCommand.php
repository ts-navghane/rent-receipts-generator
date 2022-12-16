<?php

declare(strict_types=1);

namespace App\Command;

use App\Helper\HTMLHelper;
use DateInterval;
use DateTime;
use DateTimeInterface;
use Dompdf\Dompdf;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RentReceiptCommand extends Command
{
    private array $config;

    public function __construct(array $config)
    {
        parent::__construct();
        $this->config = $config;
    }

    public function configure(): void
    {
        $this->setName('rent-receipts')
            ->setDescription('Generate Rent Receipts PDF')
            ->setHelp('This command allows you to create Rent Receipts');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = new DateTime($this->config['{$startDate}']);
        $end   = new DateTime($this->config['{$endDate}']);

        $this->config['{$getIndianCurrency}'] = $this->getIndianCurrency($this->config['{$rentAmount}']);

        while ($start <= $end) {
            $this->config['{$fullMonth}'] = $start->format('F');
            $this->config['{$year}']      = $start->format('Y');
            $this->config['{$date}']      = $start->format('Y-m-d');

            $dompdf = new Dompdf();
            $dompdf->setPaper('A4');
            $dompdf->loadHtml(HTMLHelper::getHTMLTemplate($this->config));
            $dompdf->render();

            $this->outputFile($start, $dompdf);

            $start->add(new DateInterval('P1M'));
        }

        return 1;
    }

    private function getIndianCurrency(float $number): string
    {
        $decimal      = round($number - ($no = floor($number)), 2) * 100;
        $digitsLength = strlen((string)$no);
        $i            = 0;
        $str          = [];
        $words        = [
            0  => '',
            1  => 'One',
            2  => 'Two',
            3  => 'Three',
            4  => 'Four',
            5  => 'Five',
            6  => 'Six',
            7  => 'Seven',
            8  => 'Eight',
            9  => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety',
        ];
        $digits       = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];
        while ($i < $digitsLength) {
            $divider = ($i === 2) ? 10 : 100;
            $number  = floor($no % $divider);
            $no      = floor($no / $divider);
            $i       += $divider === 10 ? 1 : 2;
            if ($number) {
                $plural  = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter === 1 && $str[0]) ? ' and ' : null;
                $str[]   = ($number < 21)
                    ? $words[$number].' '.$digits[$counter].$plural.' '.$hundred
                    : $words[floor(
                        $number / 10
                    ) * 10].' '.$words[$number % 10].' '.$digits[$counter].$plural.' '.$hundred;
            } else {
                $str[] = null;
            }
        }
        $rupees = implode('', array_reverse($str));
        $paise  = ($decimal > 0) ? ".".($words[$decimal / 10]." ".$words[$decimal % 10]).' Paise' : '';

        return trim($rupees.$paise);
    }

    private function outputFile(DateTimeInterface $start, Dompdf $dompdf): void
    {
        file_put_contents('output/'.$start->format('Y_m_d').'_Rent_Receipt.pdf', $dompdf->output());
    }
}
