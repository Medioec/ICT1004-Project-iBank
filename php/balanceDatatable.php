<?php
    function formBalanceTable($balanceArray)
    {
        $tableData = "";
        foreach ($balanceArray as $row)
        {
            $tableData .= '<tr>';
            $tableData .= '<td>'.$row['account_id'].'<br>['.$row['type'].']</td>';
            $tableData .= '<td>$'.$row['balance'].'</td>';
            $tableData .= '</tr>';
        }

        $table = '
            <table id="balance-table" class="table table-striped wrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Account</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>'.$tableData.'                    
                </tbody>
            </table>
        ';
        echo $table;

    }
    
?>