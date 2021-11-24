<header>    
    <h1>Welcome back! 
        <?php 
            if($_SESSION['gender']=="Female"){
                echo "Ms. ";
            }
            else {
                echo "Mr. ";
            }
            echo $_SESSION['displayName'];
        ?>
    </h1>            
</header>
<main class="row">
    <div class="col-12 col-sm-6">
        <canvas id="myAccountChart" width="400" height="400"></canvas>
    </div>
    <div class="col-12 col-sm-6">
        <canvas id="myTransactionChart" width="400" height="400"></canvas>
    </div>
    <?php 
    include_once "connect.php";
    $thiscustomerid = $_SESSION['customerId'];
    
    // Get individual balance amount for bank accounts tied to customer id
    $balanceSql = "SELECT `balance` FROM bank_account "
            . "WHERE `account_id` IN "
            . "(SELECT `account_id` FROM bank_accounts_ref "
            . "WHERE `customer_id` = ?)"; 
    $balanceStmt = $connect->prepare($balanceSql);
    $balanceStmt->bindParam(1,$thiscustomerid, PDO::PARAM_STR);
    $balanceStmt->execute();
    $balanceResult = $balanceStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get bank account number tied to customer id (Concatenated as "Account *")
    $accountSql = "SELECT CONCAT(\"Account \",`account_id`) AS `account_id` FROM bank_accounts_ref "
            . "WHERE `customer_id` = ?"; 
    $accountStmt = $connect->prepare($accountSql);
    $accountStmt->bindParam(1,$thiscustomerid, PDO::PARAM_STR);
    $accountStmt->execute();
    $accountResult = $accountStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Convert SQL array to PHP array
    $accountArray = array_column($accountResult, 'account_id');
    $balanceArray = array_column($balanceResult, 'balance');
    
    // Get SQL param "?,?, ... ,?" for number of account number tied to customer
    $accountINArray = implode(',', array_fill(0, count($accountArray), '?'));
    
    // Get credit bank transactions from account number
    $creditTransactionSql = "SELECT SUM(`amount`) AS `total`, monthname(timestamp) AS `month` "
            . "FROM `transaction_data` "
            . "WHERE `credit_id` IN (".$accountINArray.")  AND (`timestamp` > timestamp(DATE_SUB(NOW(), INTERVAL 4 MONTH))) "
            . "GROUP BY `timestamp` "
            . "ORDER BY `timestamp` ASC;"; 
    $creditTransactionStmt = $connect->prepare($creditTransactionSql);
    $c = 0;
    foreach ($accountArray as $key=> $acc) {
        $c++;
        $creditTransactionStmt->bindParam($c,str_replace("Account","",$acc), PDO::PARAM_INT);
    }
    $creditTransactionStmt->execute();
    $creditTransactionResult = $creditTransactionStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get debit bank transactions from account number
    $debitTransactionSql = "SELECT SUM(`amount`) AS `total`, monthname(timestamp) AS `month` "
            . "FROM `transaction_data` "
            . "WHERE `debit_id` IN (".$accountINArray.")  AND (`timestamp` > timestamp(DATE_SUB(NOW(), INTERVAL 4 MONTH))) "
            . "GROUP BY `timestamp` "
            . "ORDER BY `timestamp` ASC;"; 
    $debitTransactionStmt = $connect->prepare($debitTransactionSql);
    $c = 0;
    foreach ($accountArray as $key=> $acc) {
        $c++;
        $debitTransactionStmt->bindParam($c,str_replace("Account","",$acc), PDO::PARAM_INT);
    }
    $debitTransactionStmt->execute();
    $debitTransactionResult = $debitTransactionStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get all the months of the transactions
    $dMonthArray = array_column($debitTransactionResult, 'month');
    $cMonthArray = array_column($creditTransactionResult, 'month');
    $monthArray = array_values(array_unique(array_merge ($cMonthArray, $dMonthArray)));
    
    $cTotalArray = array();
    
    $c = 0;
    foreach ($monthArray as $month) {
        if(in_array($month,$creditTransactionResult[$c])) {
            array_push($cTotalArray,$creditTransactionResult[$c]['total']);
        }
        else {
            array_push($cTotalArray,0);
            $c--;
        }
        $c++;
    }
    
    $dTotalArray = array();
    $c = 0;
    foreach ($monthArray as $month) {
        if(in_array($month,$debitTransactionResult[$c])) {
            array_push($dTotalArray,-1 * abs($debitTransactionResult[$c]['total']));
        }
        else {
            array_push($dTotalArray,0);
            $c--;
        }
        $c++;
    }
    
    ?>
    <script>
        // Doughnut Account Chart
        const ctx = document.getElementById('myAccountChart').getContext('2d');
        var accountLabels = <?php echo json_encode($accountArray); ?>;
        const balanceData = <?php echo json_encode($balanceArray); ?>;
        const accountData = {
                labels: accountLabels,
                datasets: [{
                    label: 'Account Dataset',
                    data: balanceData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            };
        
        const myAccountChart = new Chart(ctx, {
            type: 'doughnut',
            data: accountData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Accounts Balance'
                    }
                }
            }
        });
        
        // Stacked Bar Transaction Chart
        const ctx2 = document.getElementById('myTransactionChart').getContext('2d');
        var monthLabels = <?php echo json_encode($monthArray); ?>;
        const creditData = <?php echo json_encode($cTotalArray); ?>;
        const debitData = <?php echo json_encode($dTotalArray); ?>;
        const myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [
                                {
                                    label: 'Credit',
                                    data: creditData,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                    stack: 'Stack 0'
                                },
                                {
                                    label: 'Debit',
                                    data: debitData,
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1,
                                    stack: 'Stack 0'
                                }
                            ]
//                datasets: [{
//                    label: '# of Votes',
//                    data: [12, 19, 3, 5, 2, 3],
//                    backgroundColor: [
//                        'rgba(255, 99, 132, 0.2)',
//                        'rgba(54, 162, 235, 0.2)',
//                        'rgba(255, 206, 86, 0.2)',
//                        'rgba(75, 192, 192, 0.2)',
//                        'rgba(153, 102, 255, 0.2)',
//                        'rgba(255, 159, 64, 0.2)'
//                    ],
//                    borderColor: [
//                        'rgba(255, 99, 132, 1)',
//                        'rgba(54, 162, 235, 1)',
//                        'rgba(255, 206, 86, 1)',
//                        'rgba(75, 192, 192, 1)',
//                        'rgba(153, 102, 255, 1)',
//                        'rgba(255, 159, 64, 1)'
//                    ],
//                    borderWidth: 1
//                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Total Transactions past 4 months'
                    }
                },
                responsive: true,
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true
                        //type: 'logarithmic'
                    }
                }
            }
        });
    </script>
</main>

