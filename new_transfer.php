<!DOCTYPE html>
<html>
    <?php
        include "head.inc.php";
    ?>
    <body>
        <?php
            include "nav.inc.php";
        ?>
        <div class="page-bg">
            <div class="page-body">
                <div class="side-menu">
                    <h2>Options</h2>
                    <ul>
                        <li>
                            <a class="side-menu-link" href="">View transaction history</a>
                        </li>
                        <li>
                            <a class="side-menu-link" href="">Transfer to own account</a>
                        </li>
                        <li>
                            <a class="side-menu-link" href="">Transfer to other account</a>
                        </li>
                    </ul>
                </div>
                <div class="main-content">
                    
                    <h2>Transfer to own account</h2>
                    
                    <form action="">
                        <div class="form-group">
                            <label for="from-account-select">Account to transfer from:</label>
                            <select name="transferFromAccountIn" id="from-account-select">
                            <option value="DummyOption">DummyOption</option>
                            <option value="DummyOption">DummyOption</option>
                            <option value="DummyOption">DummyOption</option>
                            <option value="DummyOption">DummyOption</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="to-account-select">Account to transfer to:</label>
                            <select name="transferToAccountIn" id="to-account-select">
                            <option value="DummyOption">DummyOption</option>
                            <option value="DummyOption">DummyOption</option>
                            <option value="DummyOption">DummyOption</option>
                            <option value="DummyOption">DummyOption</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="transfer-amount">Amount:</label>
                            <input class="form-control" type="number" id="transfer-amount" name="transferAmountIn"
                                max length="45" placeholder="Enter amount" pattern="^[0-9]+$">
                        </div>

                        <div class="form-group">
                            <button class="" type="submit">Submit</button>
                        </div>

                        
                    </form>
                    
                    
                </div>
            </div>
        </div>
        
    </body>
</html>