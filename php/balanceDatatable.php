<?php
    function formBalanceTable($balanceArray)
    {
        $tableData = "";
        foreach ($balanceArray as $row)
        {
            $tableData .= '<tr>';
            $tableData .= '<td>'.$row['account_id'].'</td>';
            $tableData .= '<td>'.$row['type'].'</td>';
            $tableData .= '<td>'.$row['balance'].'</td>';
            $tableData .= '</tr>';
        }

        $table = '
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Account no.</th>
                        <th>Account Type</th>
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