<?php
    function formTransactionTable($transactArray, $accountId)
    {
        $tableData = "";
        foreach ($transactArray as $row)
        {
            $tableData .= '<tr>';
            if ($row['credit_id'] == $accountId)
            {
                $appendSign = '+';
                $transferDirection = 'From';
                $otherAccount = $row['debit_id'];
            }
            else
            {
                $appendSign = '-';
                $transferDirection = 'To';
                $otherAccount = $row['credit_id'];
            }
            $tableData .= '<td>'.substr($row['timestamp'], 0, 10).'</td>';
            $tableData .= '<td>'.$transferDirection.' Account '.$otherAccount.' ['.$row['type'].']</td>';
            $tableData .= '<td>'.$appendSign.$row['amount'].'</td>';
            $tableData .= '</tr>';
        }

        $table = '
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Transaction Details</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>'.$tableData.'                    
                </tbody>
            </table>
        ';
        echo $table;

    }
    
?>