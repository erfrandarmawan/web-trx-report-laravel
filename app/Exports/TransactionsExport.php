<?php

namespace App\Exports;

use App\Models\Transaction;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransactionsExport
{
    public function __construct(
        private readonly string $userId,
        private readonly string $startDate,
        private readonly string $endDate,
    ) {}

    public function download(string $fileName = 'transactions.xlsx'): StreamedResponse
    {
        return response()->streamDownload(function (): void {
            $writer = new Writer;
            $writer->openToFile('php://output');

            $writer->addRow(Row::fromValues(['ID', 'Amount', 'Transaction Date', 'Created At']));

            Transaction::where('user_id', $this->userId)
                ->whereBetween('trx_date', [$this->startDate, $this->endDate])
                ->orderBy('trx_date', 'desc')
                ->chunk(500, function ($transactions) use ($writer): void {
                    foreach ($transactions as $transaction) {
                        $writer->addRow(Row::fromValues([
                            $transaction->id,
                            $transaction->amount,
                            $transaction->trx_date->format('Y-m-d H:i:s'),
                            $transaction->created_at->format('Y-m-d H:i:s'),
                        ]));
                    }
                });

            $writer->close();
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
        ]);
    }
}
