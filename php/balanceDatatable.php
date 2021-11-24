<?php
if (0) {
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
} else {
    function formBalanceTable($balanceArray)
    {
        $echoData = "";
        foreach ($balanceArray as $row)
        {
            $echoData .= 
            '
            <form method="post">
                <div class="card mt-3">
                    <div class="card-header">
                        Account: '.$row["account_id"].' ['.$row["type"].']
                    </div>
                    <div class="card-body row">
                        <div class="col mr-auto">
                            <h5 class="card-title">Balance</h5>
                            <p class="card-text">$'.$row["balance"].'</p>
                        </div>
                        <div class=col-auto>
                            <button class="btn btn-primary mt-3" type="submit" name="accountId" value="'.$row["account_id"].'">Manage</a>
                        </div>
                    </div>
                </div>
            </form>
            

            ';
        }
        echo $echoData;

    }
}
?>
